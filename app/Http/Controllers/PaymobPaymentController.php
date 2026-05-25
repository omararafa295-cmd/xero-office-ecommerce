<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymobPaymentController extends Controller
{
    public function retry(Order $order, PaymobService $paymobService): RedirectResponse
    {
        abort_unless(Auth::id() === $order->user_id, 403);

        if (!$order->isPayable()) {
            return redirect()->route('my.orders')->with('error', 'هذا الطلب غير متاح لإعادة الدفع.');
        }

        $order->loadMissing('items', 'user');

        try {
            $intention = $paymobService->createIntention($order);

            $order->update([
                'payment_status' => 'pending',
                'paymob_intention_id' => $intention['intention_id'] ?: null,
                'paymob_client_secret' => $intention['client_secret'],
                'paymob_checkout_url' => $intention['checkout_url'],
                'payment_payload' => json_encode($intention['payload'], JSON_UNESCAPED_UNICODE),
            ]);

            return redirect()->away($intention['checkout_url']);
        } catch (\Throwable $e) {
            $order->update([
                'payment_status' => 'failed',
                'payment_payload' => json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE),
            ]);

            return redirect()->route('my.orders')->with('error', $this->paymobErrorMessage($e));
        }
    }

    public function callback(Request $request, Order $order, CheckoutController $checkoutController): View
    {
        $success = filter_var($request->query('success'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $pending = filter_var($request->query('pending'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $transactionId = $request->query('id') ?? $request->query('txn_id') ?? $request->query('transaction_id');

        if ($success === true && $pending !== true) {
            $this->markAsPaid($order, $request->query(), $transactionId);
            $checkoutController->finalizeOrder($order);
        } elseif ($success === false) {
            $order->update([
                'payment_status' => 'failed',
                'payment_payload' => json_encode([
                    'callback' => $request->query(),
                ], JSON_UNESCAPED_UNICODE),
            ]);
        }

        $order->refresh();

        return view('payments.paymob-result', [
            'order' => $order,
            'isSuccess' => $order->payment_status === 'paid',
        ]);
    }

    public function webhook(Request $request, CheckoutController $checkoutController): JsonResponse
    {
        $payload = $request->json()->all() ?: $request->all();

        $order = $this->resolveOrderFromPayload($payload);

        if (!$order) {
            return response()->json(['ok' => false, 'message' => 'Order not found.'], 404);
        }

        $success = (bool) data_get($payload, 'obj.success', data_get($payload, 'success', false));
        $pending = (bool) data_get($payload, 'obj.pending', data_get($payload, 'pending', false));
        $transactionId = data_get($payload, 'obj.id') ?? data_get($payload, 'id');

        if ($success && !$pending) {
            $this->markAsPaid($order, $payload, $transactionId);
            $checkoutController->finalizeOrder($order);
        } elseif (!$success && !$pending) {
            $order->update([
                'payment_status' => 'failed',
                'payment_payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'paymob_transaction_id' => $transactionId ? (string) $transactionId : $order->paymob_transaction_id,
            ]);
        }

        return response()->json(['ok' => true]);
    }

    protected function resolveOrderFromPayload(array $payload): ?Order
    {
        $merchantReference = data_get($payload, 'obj.order.merchant_order_id')
            ?? data_get($payload, 'merchant_order_id')
            ?? data_get($payload, 'obj.order.special_reference')
            ?? data_get($payload, 'special_reference')
            ?? data_get($payload, 'obj.extras.payment_reference')
            ?? data_get($payload, 'extras.payment_reference')
            ?? data_get($payload, 'obj.extras.order_id')
            ?? data_get($payload, 'extras.order_id');

        if ($merchantReference) {
            $byReference = Order::query()
                ->where('payment_reference', $merchantReference)
                ->orWhere('id', preg_replace('/\D+/', '', (string) $merchantReference))
                ->first();

            if ($byReference) {
                return $byReference;
            }
        }

        $paymobIntentionId = data_get($payload, 'obj.order.id') ?? data_get($payload, 'order.id');

        if ($paymobIntentionId) {
            return Order::where('paymob_intention_id', (string) $paymobIntentionId)->first();
        }

        return null;
    }

    protected function markAsPaid(Order $order, array $payload, mixed $transactionId = null): void
    {
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => $order->paid_at ?? now(),
            'paymob_transaction_id' => $transactionId ? (string) $transactionId : $order->paymob_transaction_id,
            'payment_payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);
    }

    protected function paymobErrorMessage(\Throwable $e): string
    {
        $message = $e->getMessage();

        return match (true) {
            str_contains($message, 'integration id is missing') => 'وسيلة الدفع المحددة غير متاحة حاليًا. يرجى اختيار وسيلة أخرى.',
            str_contains($message, 'Integration ID/Name does not exist') => 'وسيلة الدفع المحددة غير متاحة حاليًا. يرجى اختيار وسيلة أخرى.',
            str_contains($message, 'public key is missing') => 'خدمة الدفع غير متاحة حاليًا. يرجى المحاولة مرة أخرى لاحقًا.',
            str_contains($message, 'secret key is missing') => 'خدمة الدفع غير متاحة حاليًا. يرجى المحاولة مرة أخرى لاحقًا.',
            str_contains($message, 'unmatched_item_prices') => 'تعذر تجهيز عملية الدفع حاليًا. يرجى المحاولة مرة أخرى.',
            default => 'تعذر بدء عملية الدفع حاليًا. يرجى المحاولة مرة أخرى.',
        };
    }
}
