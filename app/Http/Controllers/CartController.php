<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // عرض صفحة السلة
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
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $id => $details) {
                // Mimic product relationship for session cart to unify view logic
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

        return view('cart', compact('cartItems', 'total'));
    }

 public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        if (Auth::check()) {
            $user = Auth::user();
            // Get or create cart for the user
            $cart = $user->cart()->firstOrCreate([]);

            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }
            $cartCount = $cart->items->sum('quantity'); // Get total quantity of items in the database cart
        } else {
            // If not authenticated, continue using session cart
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    "name_ar" => $product->name_ar,
                    "name_en" => $product->name_en,
                    "quantity" => $quantity,
                    "price" => $product->price,
                    "image" => $product->image
                ];
            }
            session()->put('cart', $cart);
            $cartCount = array_sum(array_column($cart, 'quantity')); // Get total quantity of items in the session cart
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة المنتج للسلة بنجاح!', // Success message
                'cart_count' => $cartCount // Return the correct cart count
            ]);
        }

        if($request->has('buy_now')) {
            return redirect()->route('checkout.index'); // يروح لصفحة الدفع فوراً
        }

        return redirect()->back()->with('success', 'تم إضافة المنتج للسلة بنجاح!');
    }
    // حذف منتج من السلة
    public function removeFromCart($id)
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart;
            if ($cart) {
                $cartItem = $cart->items()->where('product_id', $id)->first();
                if ($cartItem) {
                    $cartItem->delete();
                }
            }
        } else {
            $cart = session()->get('cart');

            if(isset($cart[$id])) {
                unset($cart[$id]); // بيمسح المنتج من المصفوفة
                session()->put('cart', $cart); // بيحفظ السلة من جديد
            }
        }

        return redirect()->back()->with('success', 'تم حذف المنتج من السلة!');
    }
}