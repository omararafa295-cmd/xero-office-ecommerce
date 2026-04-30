<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // عرض صفحة السلة
    public function index()
    {
        return view('cart');
    }

 public function addToCart(Request $request, $id)
    {
        // 1. بنجيب المنتج من الداتا بيز
        $product = \App\Models\Product::findOrFail($id);

        // 2. بنستقبل الكمية (لو داس من صفحة المنتج هياخد الرقم، لو داس من الرئيسية هيعتبرها 1 أوتوماتيك)
        $quantity = $request->input('quantity', 1);

        // 3. بنجيب السلة الحالية من الجلسة (Session)
        $cart = session()->get('cart', []);

        // 4. لو المنتج موجود أصلاً في السلة، هنزود كميته بس
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // لو مش موجود، هنضيفه كمنتج جديد في السلة
            $cart[$id] = [
                "name_ar" => $product->name_ar,
                "name_en" => $product->name_en,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        // 5. نحفظ السلة في الجلسة
        session()->put('cart', $cart);

        // 6. السحر هنا: لو العميل داس على زرار "اشتري الآن" 
        if($request->has('buy_now')) {
            return redirect()->route('checkout.index'); // يروح لصفحة الدفع فوراً
        }

        // 7. لو داس "أضف للسلة" العادية، يفضل في نفس صفحته ويطلعله رسالة نجاح
        return redirect()->back()->with('success', 'تم إضافة المنتج للسلة بنجاح!');
    }
    // حذف منتج من السلة
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]); // بيمسح المنتج من المصفوفة
            session()->put('cart', $cart); // بيحفظ السلة من جديد
        }

        return redirect()->back()->with('success', 'تم حذف المنتج من السلة!');
    }
}