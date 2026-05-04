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

        // Pass cart items and total to the view
        return view('checkout', compact('cartItems', 'total'));
    }

    // حفظ الطلب في الداتا بيز
    public function store(Request $request)
    {
        // 1. التأكد من البيانات
        $request->validate([
            'phone' => 'required|string|max:20',
            'governorate' => 'required|string',
            'address' => 'required|string|max:255',
        ]);

        $user = Auth::user(); // Get authenticated user
        // Get user's cart with items and their products eager loaded
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) { // Check if cart exists and has items
            return redirect()->route('home')->with('error', 'سلتك فارغة!');
        }

        // أسعار الشحن
        $shippingCosts = [
            'الشرقية' => 40,
            'القاهرة' => 70,
            'الجيزة' => 80,
            'الإسكندرية' => 100,
            'الدقهلية' => 60,
            'القليوبية' => 60,
            'المنوفية' => 60,
            'الغربية' => 60,
            'باقي المحافظات' => 80,
        ];

        $gov = $request->governorate;
        $shippingCost = $shippingCosts[$gov] ?? 80;

        // 2. حساب الإجمالي الكلي
        $subtotal = $cart->total; // Use the total from the Cart model
        
        $totalAmount = $subtotal + $shippingCost;
        $fullAddress = $gov . ' - ' . $request->address;

        // 3. إنشاء الطلب الأساسي
        $order = Order::create([
            'user_id' => $user->id, // Use authenticated user's ID
            'customer_name' => $user->name, // Use authenticated user's name
            'customer_phone' => $request->phone,
            'customer_email' => $user->email, // Use authenticated user's email
            'shipping_address' => $fullAddress,
            'total_amount' => $totalAmount,
            'payment_method' => 'cash',
            'status' => 'pending'
        ]);

       // 4. حفظ المنتجات اللي جوه الطلب وخصمها من المخزن
        foreach ($cart->items as $cartItem) { // Iterate through cart items from the database
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