<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    // عرض صفحة الدفع
    public function index()
    {
        $cart = session()->get('cart');
        
        // لو السلة فاضية، نرجعه للرئيسية
        if (!$cart || count($cart) == 0) {
            return redirect()->route('home')->with('error', 'سلتك فارغة!');
        }

        return view('checkout');
    }

    // حفظ الطلب في الداتا بيز
    public function store(Request $request)
    {
        // 1. التأكد من البيانات
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $cart = session()->get('cart');
        if (!$cart) return redirect()->route('home');

        // 2. حساب الإجمالي الكلي
        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // 3. إنشاء الطلب الأساسي
        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => auth()->user()->name,
            'customer_phone' => $request->phone,
            'customer_email' => auth()->user()->email, // ضفناها عشان موجودة في الجدول
            'shipping_address' => $request->address,   // ده الاسم الصح للعنوان عندك
            'total_amount' => $total,
            'payment_method' => 'cash',              // ضفناها عشان موجودة في الجدول
            'status' => 'pending'                    // شيلنا الـ notes خالص عشان مش في الجدول
        ]);

       // 4. حفظ المنتجات اللي جوه الطلب وخصمها من المخزن
        foreach ($cart as $id => $details) {
            // حفظ تفاصيل المنتج في الطلب
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $details['name_ar'], // ضفنا السطر ده عشان الداتا بيز عايزاه
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);

            // خصم الكمية من مخزون المنتج
            $product = Product::find($id);
            if ($product) {
                $product->decrement('stock', $details['quantity']);
            }
        } // هنا نهاية الـ foreach بشكل صحيح

        // 5. تفريغ السلة وتوجيه العميل لصفحة النجاح
        session()->forget('cart');
        // إرسال الإيميل للعميل
Mail::to(auth()->user()->email)->send(new OrderConfirmation($order));
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