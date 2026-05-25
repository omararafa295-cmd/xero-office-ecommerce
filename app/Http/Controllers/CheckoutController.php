<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Coupon;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PaymobService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(PaymobService $paymobService): View|RedirectResponse
    {
        $cartItems = [];
        $total = 0;

        if (Auth::check()) {
            $cart = Auth::user()->cart;
            if ($cart) {
                $cartItems = $cart->items()->with('product')->get();
                $total = $cart->total;
            }
        } else {
            $sessionCart = session()->get('cart');
            if ($sessionCart) {
                foreach ($sessionCart as $id => $details) {
                    $cartItems[] = (object) [
                        'product_id' => $id,
                        'quantity' => $details['quantity'],
                        'price' => $details['price'],
                        'product' => (object) [
                            'name_ar' => $details['name_ar'],
                            'name_en' => $details['name_en'],
                            'image' => $details['image'],
                        ],
                    ];
                    $total += $details['price'] * $details['quantity'];
                }
            }
        }

        if (empty($cartItems) || count($cartItems) === 0) {
            return redirect()->route('home')->with('error', 'سلة التسوق فارغة.');
        }

        $governorates = Governorate::all();
        $discount = 0;
        $paymobCardEnabled = $paymobService->isMethodConfigured('card');
        $paymobWalletEnabled = $paymobService->isMethodConfigured('wallet');

        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            $discount = $coupon['type'] === 'fixed'
                ? $coupon['value']
                : ($total * ($coupon['value'] / 100));
        }

        return view('checkout', compact(
            'cartItems',
            'total',
            'governorates',
            'discount',
            'paymobCardEnabled',
            'paymobWalletEnabled'
        ));
    }

    public function store(Request $request, PaymobService $paymobService): RedirectResponse
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'governorate' => 'required|exists:governorates,id',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cash,card,wallet',
            'wallet_number' => 'nullable|required_if:payment_method,wallet|string|max:20',
        ]);

        if (
            ($request->payment_method === 'card' && !$paymobService->isMethodConfigured('card'))
            || ($request->payment_method === 'wallet' && !$paymobService->isMethodConfigured('wallet'))
        ) {
            return redirect()->route('checkout.index')->withInput()->with(
                'error',
                'وسيلة الدفع المحددة غير متاحة حاليًا. يرجى اختيار وسيلة أخرى.'
            );
        }

        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('home')->with('error', 'سلة التسوق فارغة.');
        }

        foreach ($cart->items as $cartItem) {
            if (!$cartItem->product || $cartItem->product->stock < $cartItem->quantity) {
                return redirect()->route('cart.index')->with(
                    'error',
                    __('المنتج') . ' ' . optional($cartItem->product)->name_ar . ' ' . __('غير متوفر بالكمية المطلوبة حاليًا.')
                );
            }
        }

        $governorate = Governorate::findOrFail($request->governorate);
        $shippingCost = $governorate->shipping_cost;
        $subtotal = $cart->total;

        [$discount, $couponCode] = $this->couponData($subtotal);

        $totalAmount = max(0, $subtotal - $discount) + $shippingCost;
        $fullAddress = $governorate->name_ar . ' - ' . $request->address;

        $order = DB::transaction(function () use ($user, $cart, $request, $fullAddress, $totalAmount, $discount, $couponCode) {
            $order = Order::create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_phone' => $request->phone,
                'customer_email' => $user->email,
                'shipping_address' => $fullAddress,
                'notes' => $request->notes,
                'total_amount' => $totalAmount,
                'discount_amount' => $discount,
                'coupon_code' => $couponCode,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'cash_on_delivery' : 'pending',
                'wallet_number' => $request->payment_method === 'wallet' ? $request->wallet_number : null,
                'payment_reference' => 'XO-' . strtoupper(Str::random(10)),
                'status' => 'pending',
            ]);

            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name_ar,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);
            }

            return $order->load('items.product', 'user');
        });

        if ($order->payment_method === 'cash') {
            $this->finalizeOrder($order);

            return redirect()->route('checkout.success')->with([
                'order_id' => $order->id,
                'payment_method_label' => $order->payment_method_label,
            ]);
        }

        try {
            $intention = $paymobService->createIntention($order);

            $order->update([
                'paymob_intention_id' => $intention['intention_id'] ?: null,
                'paymob_client_secret' => $intention['client_secret'],
                'paymob_checkout_url' => $intention['checkout_url'],
                'payment_payload' => json_encode($intention['payload'], JSON_UNESCAPED_UNICODE),
            ]);

            return redirect()->away($intention['checkout_url']);
        } catch (\Throwable $e) {
            $order->update([
                'payment_status' => 'failed',
                'payment_payload' => json_encode([
                    'error' => $e->getMessage(),
                ], JSON_UNESCAPED_UNICODE),
            ]);

            return redirect()->route('my.orders')->with('error', $this->paymobErrorMessage($e));
        }
    }

    public function success(): View|RedirectResponse
    {
        if (!session('order_id')) {
            return redirect()->route('home');
        }

        return view('checkout-success');
    }

    public function finalizeOrder(Order $order): void
    {
        $order->loadMissing('items.product', 'user');

        if ($order->finalized_at) {
            return;
        }

        DB::transaction(function () use ($order) {
            $order->refresh()->loadMissing('items.product', 'user');

            if ($order->finalized_at) {
                return;
            }

            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            if ($order->user) {
                $cart = $order->user->cart()->with('items')->first();

                if ($cart) {
                    foreach ($order->items as $orderItem) {
                        $cartItem = $cart->items->firstWhere('product_id', $orderItem->product_id);

                        if (!$cartItem) {
                            continue;
                        }

                        if ($cartItem->quantity > $orderItem->quantity) {
                            $cartItem->decrement('quantity', $orderItem->quantity);
                        } else {
                            $cartItem->delete();
                        }
                    }

                    if ($cart->items()->count() === 0) {
                        $cart->delete();
                    }
                }
            }

            if ($order->coupon_code) {
                Coupon::where('code', $order->coupon_code)->increment('used_count');
                if (session()->has('coupon') && session()->get('coupon')['code'] === $order->coupon_code) {
                    session()->forget('coupon');
                }
            }

            $order->update([
                'paid_at' => $order->payment_method === 'cash' ? null : now(),
                'finalized_at' => now(),
            ]);
        });

        if ($order->customer_email) {
            Mail::to($order->customer_email)->send(new OrderConfirmation($order->fresh('items.product', 'user')));
        }
    }

    protected function couponData(float $subtotal): array
    {
        $discount = 0;
        $couponCode = null;

        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            $discount = $coupon['type'] === 'fixed'
                ? $coupon['value']
                : ($subtotal * ($coupon['value'] / 100));
            $couponCode = $coupon['code'];
        }

        return [$discount, $couponCode];
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
