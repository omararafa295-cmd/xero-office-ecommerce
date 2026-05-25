<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaymobService
{
    public function isMethodConfigured(string $paymentMethod): bool
    {
        return filled($this->integrationIdFor($paymentMethod));
    }

    public function createIntention(Order $order): array
    {
        $paymentMethodId = $this->integrationIdFor($order->payment_method);

        if (!$paymentMethodId) {
            throw new RuntimeException('Paymob integration id is missing for the selected payment method.');
        }

        $payload = [
            'amount' => $this->orderTotalCents($order),
            'currency' => config('services.paymob.currency', 'EGP'),
            'payment_methods' => [(int) $paymentMethodId],
            'items' => $this->paymobItems($order),
            'billing_data' => $this->billingData($order),
            'special_reference' => (string) ($order->payment_reference ?: $order->id),
            'notification_url' => route('payments.paymob.webhook'),
            'redirection_url' => route('payments.paymob.callback', $order),
            'extras' => [
                'order_id' => (string) $order->id,
                'payment_reference' => (string) ($order->payment_reference ?: $order->id),
                'payment_method' => $order->payment_method,
            ],
        ];

        if ($order->payment_method === 'wallet' && $order->wallet_number) {
            $payload['wallet_mobile_number'] = $order->wallet_number;
        }

        $response = $this->request()->post('/v1/intention/', $payload);

        if ($response->failed()) {
            throw new RuntimeException($this->errorMessage($response));
        }

        $data = $response->json();
        $clientSecret = data_get($data, 'client_secret');

        if (!$clientSecret) {
            throw new RuntimeException('Paymob client secret was not returned.');
        }

        return [
            'intention_id' => (string) (data_get($data, 'id') ?? data_get($data, 'intention_order_id') ?? ''),
            'client_secret' => $clientSecret,
            'checkout_url' => $this->checkoutUrl($clientSecret),
            'payload' => $data,
        ];
    }

    public function checkoutUrl(string $clientSecret): string
    {
        $baseUrl = rtrim(config('services.paymob.checkout_base_url'), '/');
        $publicKey = config('services.paymob.public_key');

        if (!$publicKey) {
            throw new RuntimeException('Paymob public key is missing.');
        }

        return $baseUrl.'/unifiedcheckout/?publicKey='.urlencode($publicKey).'&clientSecret='.urlencode($clientSecret);
    }

    public function integrationIdFor(string $paymentMethod): ?string
    {
        return match ($paymentMethod) {
            'card' => config('services.paymob.card_integration_id'),
            'wallet' => config('services.paymob.wallet_integration_id'),
            default => null,
        };
    }

    protected function paymobItems(Order $order): array
    {
        $totalCents = $this->orderTotalCents($order);

        return [[
            'name' => 'Order #'.$order->id,
            'amount' => $totalCents,
            'description' => 'Order payment for Xero Office',
            'quantity' => 1,
        ]];
    }

    protected function orderTotalCents(Order $order): int
    {
        return (int) round(((float) $order->total_amount) * 100);
    }

    protected function billingData(Order $order): array
    {
        [$firstName, $lastName] = $this->splitName($order->customer_name);

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $order->customer_email ?? 'customer@example.com',
            'phone_number' => $order->customer_phone,
            'apartment' => 'NA',
            'floor' => 'NA',
            'street' => $order->shipping_address,
            'building' => 'NA',
            'shipping_method' => 'PKG',
            'postal_code' => 'NA',
            'city' => 'Cairo',
            'country' => 'EG',
            'state' => 'Cairo',
        ];
    }

    protected function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/', trim($fullName)) ?: [];
        $firstName = $parts[0] ?? 'Customer';
        $lastName = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : 'Customer';

        return [$firstName, $lastName];
    }

    protected function request()
    {
        $baseUrl = rtrim((string) config('services.paymob.base_url'), '/');
        if (str_ends_with($baseUrl, '/api')) {
            $baseUrl = substr($baseUrl, 0, -4);
        }
        $secretKey = config('services.paymob.secret_key');

        if (!$secretKey) {
            throw new RuntimeException('Paymob secret key is missing.');
        }

        return Http::baseUrl($baseUrl)
            ->acceptJson()
            ->contentType('application/json')
            ->withToken($secretKey)
            ->timeout(30);
    }

    protected function errorMessage(Response $response): string
    {
        return data_get($response->json(), 'message')
            ?? data_get($response->json(), 'detail')
            ?? data_get($response->json(), 'errors.0.message')
            ?? 'Paymob request failed.';
    }
}
