<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class StoreController extends Controller
{
    /**
     * عرض الصفحة الرئيسية للمتجر
     */
    public function index()
    {
        // جلب جميع الأقسام لعرضها في الرئيسية
        $categories = Category::all();
        
        // جلب أحدث 8 منتجات نشطة فقط
        $products = Product::where('is_active', 1)
                           ->latest()
                           ->take(12)
                           ->get();
        
        // توجيه البيانات لصفحة welcome
        return view('welcome', compact('categories', 'products'));
    }
    // عرض تفاصيل منتج واحد
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        // جلب منتجات مشابهة (من نفس القسم) عشان نشجع العميل يشتري أكتر
        $related_products = Product::where('category_id', $product->category_id)
                                   ->where('id', '!=', $id)
                                   ->take(10)
                                   ->get();

        return view('product', compact('product', 'related_products'));
    }
    // دالة البحث
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // البحث في الاسم والوصف بالعربي
        $products = Product::where('is_active', 1)
            ->where(function($q) use ($query) {
                $q->where('name_ar', 'LIKE', "%{$query}%")
                  ->orWhere('description_ar', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->paginate(12); // استخدمنا paginate عشان لو النتايج كتير

        return view('search_results', compact('products', 'query'));
    }

    public function category(Request $request, $slug)
{
    $category = Category::where('name_en', $slug)->firstOrFail();
    $query = Product::where('category_id', $category->id);

    // فلترة بالسعر
    if ($request->has('min_price') && $request->min_price != '') {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->has('max_price') && $request->max_price != '') {
        $query->where('price', '<=', $request->max_price);
    }

    $products = $query->paginate(12);
    return view('category_products', compact('category', 'products'));
}
    // دالة إرجاع اقتراحات البحث كـ JSON
    public function searchSuggestions(Request $request)
    {
        $query = $request->input('query');
        
        // بندور في الاسم بالعربي والانجليزي وبنجيب 5 منتجات بس عشان القايمة متبقاش طويلة جداً
        $products = \App\Models\Product::where('name_ar', 'LIKE', "%{$query}%")
                        ->orWhere('name_en', 'LIKE', "%{$query}%")
                        ->take(5)
                        ->get(['id', 'name_ar', 'price', 'image']);
        
        return response()->json($products);
    }
    // عرض صفحة الشروط والأحكام
    public function terms()
    {
        return view('terms');
    }
}