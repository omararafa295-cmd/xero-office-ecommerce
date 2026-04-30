@extends('layouts.admin')
@section('title', 'إضافة منتج جديد - Xero Office')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-black mb-8 text-center text-gray-900 dark:text-white transition-colors">إضافة منتج جديد </h1>

    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 text-sm font-bold border border-red-200 dark:border-red-800">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>❌ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 transition-colors">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">اسم عربي</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar') }}" required
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">اسم إنجليزي</label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" 
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">القسم</label>
                    <select name="category_id" required
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                        <option value="">اختر القسم...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">السعر الحالي (ج.م)</label>
        <input type="number" name="price" step="0.01" required placeholder="مثال: 500"
            class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition-all">
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">السعر قبل الخصم (اختياري)</label>
        <input type="number" name="old_price" step="0.01" placeholder="مثال: 750"
            class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition-all border-dashed">
        <p class="text-[10px] text-gray-400 mt-1">* سيظهر مشطوباً بجانب السعر الحالي لعمل تأثير الخصم.</p>
    </div>
</div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">المخزون</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" required
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">صورة المنتج</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full p-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition 
                        file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 dark:file:bg-gray-600 dark:file:text-white dark:hover:file:bg-gray-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">وصف المنتج</label>
                <textarea name="description_ar" rows="4" 
                    class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">{{ old('description_ar') }}</textarea>
            </div>

            <div class="mt-8 text-center">
                <button type="submit" class="bg-gray-900 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white font-bold text-lg py-4 px-12 rounded-xl transition shadow-md w-full md:w-1/2">
                    حفظ المنتج
                </button>
            </div>
        </form>
    </div>
</div>
@endsection