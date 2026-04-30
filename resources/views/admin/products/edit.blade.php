@extends('layouts.admin')
@section('title', 'تعديل المنتج')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold dark:text-white">تعديل: {{ $product->name_ar }}</h1>
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-xero-red font-bold">&larr; العودة للقائمة</a>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">اسم المنتج (عربي)</label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-xero-red dark:text-white border border-gray-200 dark:border-gray-600">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">اسم المنتج (إنجليزي)</label>
                <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-xero-red dark:text-white border border-gray-200 dark:border-gray-600">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">القسم</label>
                <select name="category_id" class="w-full p-3 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-xero-red dark:text-white border border-gray-200 dark:border-gray-600">
                    <option value="">بدون قسم</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">السعر الحالي (ج.م)</label>
        <input type="number" name="price" value="{{ $product->price }}" step="0.01" required
            class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition-all">
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">السعر قبل الخصم (اختياري)</label>
        <input type="number" name="old_price" value="{{ $product->old_price }}" step="0.01"
            class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition-all border-dashed">
    </div>
</div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">المخزون</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 rounded-xl focus:ring-xero-red dark:text-white border border-gray-200 dark:border-gray-600">
            </div>
        </div>

        <div class="mt-6 border-t dark:border-gray-700 pt-6">
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">صورة المنتج (اتركها فارغة إذا لم ترد تغييرها)</label>
            
            @if($product->image)
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-2">الصورة الحالية:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 rounded-lg object-cover shadow-sm border dark:border-gray-600">
                </div>
            @endif

            <input type="file" name="image" accept="image/*" class="w-full p-3 bg-gray-50 dark:bg-gray-700 rounded-xl text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
        </div>

        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 text-xl font-bold py-4 rounded-xl transition shadow-lg mt-6">
            تحديث بيانات المنتج
        </button>
    </form>
</div>
@endsection