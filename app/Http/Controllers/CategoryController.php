<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // عرض الأقسام + فورم الإضافة
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // حفظ قسم جديد
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'slug' => Str::slug($request->name_en), // بيعمل اللينك أوتوماتيك (مثال: paper-tools)
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'تم إضافة القسم بنجاح! ✅');
    }

    // مسح قسم
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        return redirect()->back()->with('success', 'تم مسح القسم بنجاح! ');
    }
}