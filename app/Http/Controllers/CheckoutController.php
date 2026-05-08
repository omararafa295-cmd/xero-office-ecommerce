<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Governorate;
use App\Models\Coupon;

class CheckoutController extends Controller
{
    // عرض صفحة الدفع
    public function index()
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
            // This block should ideally not be reached if 'verified' middleware is applied
            // but keeping it for robustness or if guest checkout was allowed before.
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
                        ]
                    ];
                    $total += $details['price'] * $details['quantity'];
                }
            }
        }
        
        // لو السلة فاضية، نرجعه للرئيسية
        if (empty($cartItems) || count($cartItems) == 0) { // Check if $cartItems is empty
            return redirect()->route('home')->with('error', 'سلتك فارغة!');
        }

        $governorates = Governorate::all();

        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            // حساب الخصم بناءً على نوعه (ثابت أو نسبة مئوية من إجمالي السلة)
            $discount = $coupon['type'] == 'fixed' ? $coupon['value'] : ($total * ($coupon['value'] / 100));
        }

        // Pass cart items and total to the view
        return view('checkout', compact('cartItems', 'total', 'governorates', 'discount'));
    }

    // حفظ الطلب في الداتا بيز
    public function store(Request $request)
    {
        // 1. التأكد من البيانات
        $request->validate([
            'phone' => 'required|string|max:20',
            'governorate' => 'required|exists:governorates,id',
            'address' => 'required|string|max:255',
        ]);

        $user = Auth::user(); // Get authenticated user
        // Get user's cart with items and their products eager loaded
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) { // Check if cart exists and has items
            return redirect()->route('home')->with('error', 'سلتك فارغة!');
        }

        // جلب المحافظة المختارة من الداتا بيز
        $governorate = Governorate::findOrFail($request->governorate);
        $shippingCost = $governorate->shipping_cost;

        // 2. حساب الإجمالي الكلي
        $subtotal = $cart->total; // Use the total from the Cart model
        
        $discount = 0;
        $couponCode = null;
        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            $discount = $coupon['type'] == 'fixed' ? $coupon['value'] : ($subtotal * ($coupon['value'] / 100));
            $couponCode = $coupon['code'];
        }

        $totalAmount = max(0, $subtotal - $discount) + $shippingCost; // نخصم من المنتجات فقط وليس من سعر الشحن
        $fullAddress = $governorate->name_ar . ' - ' . $request->address;

        // 3. إنشاء الطلب الأساسي
        $order = Order::create([
            'user_id' => $user->id, // Use authenticated user's ID
            'customer_name' => $user->name, // Use authenticated user's name
            'customer_phone' => $request->phone,
            'customer_email' => $user->email, // Use authenticated user's email
            'shipping_address' => $fullAddress,
            'total_amount' => $totalAmount,
            'discount_amount' => $discount,
            'coupon_code' => $couponCode,
            'payment_method' => 'cash',
            'status' => 'pending'
        ]);

       // 4. حفظ المنتجات اللي جوه الطلب وخصمها من المخزن
        foreach ($cart->items as $cartItem) { // Iterate through cart items from the database
            // التأكد من توفر المخزون قبل أي شيء
            if ($cartItem->product->stock < $cartItem->quantity) {
                return redirect()->route('cart.index')->with('error', 
                    __('عذراً، المنتج') . ' ' . $cartItem->product->name_ar . ' ' . __('غير متوفر بالكمية المطلوبة حالياً.')
                );
            }

            // حفظ تفاصيل المنتج في الطلب
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name_ar, // Access product name via relationship
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price
            ]);

            // خصم الكمية من مخزون المنتج
            $product = $cartItem->product; // Product is already loaded
            if ($product) {
                $product->decrement('stock', $cartItem->quantity);
            }
        }

        // 5. تفريغ السلة وتوجيه العميل لصفحة النجاح
        $cart->items()->delete(); // Clear cart items from database
        $cart->delete(); // Delete the cart itself

        // زيادة عدد مرات استخدام الكوبون وحذفه من الجلسة
        if (session()->has('coupon')) {
            Coupon::where('code', session()->get('coupon')['code'])->increment('used_count');
            session()->forget('coupon');
        }

        $order->loadMissing('items');
        Mail::to($user->email)->send(new OrderConfirmation($order));
        return redirect()->route('checkout.success')->with('order_id', $order->id);
    }

    // عرض صفحة نجاح الطلب
    public function success()
    {
        if (!session('order_id')) {
            return redirect()->route('home');
        }
        return view('checkout-success');
    }
}
