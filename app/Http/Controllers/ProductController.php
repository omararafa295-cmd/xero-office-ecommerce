<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'old_price' => 'nullable|numeric|gt:price',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'slug' => Str::slug($request->name_en),
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'old_price' => $request->old_price,
        ]);

        return redirect()->route('products.index')->with('success', 'تم إضافة المنتج!');
    }

    public function edit(Product $product) {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|gt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'slug' => Str::slug($request->name_en),
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'stock' => $request->stock,
        ];

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'تم تعديل المنتج!');
    }

    public function destroy(Product $product) {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return back()->with('success', 'تم الحذف!');
    }

    // دالة إضافة/إزالة المفضلة
    public function toggleFavorite($id) {
        $user = auth()->user();
        $favorite = Favorite::where('user_id', $user->id)->where('product_id', $id)->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create(['user_id' => $user->id, 'product_id' => $id]);
        }
        return back();
    }
    public function favorites()
    {
        $favorites = \App\Models\Favorite::where('user_id', auth()->id())->with('product')->get();
        return view('favorites', compact('favorites'));
    }
}