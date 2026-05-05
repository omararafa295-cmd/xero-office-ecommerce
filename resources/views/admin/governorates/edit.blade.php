@extends('layouts.admin')
@section('title', 'تعديل محافظة')

@section('content')
<div class="max-w-2xl mx-auto py-4">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-all">
        <h2 class="text-2xl font-black mb-8 text-gray-900 dark:text-white border-b pb-4">تعديل: <span class="text-red-600">{{ $governorate->name_ar }}</span></h2>
        
        <form action="{{ route('governorates.update', $governorate->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">اسم المحافظة (بالعربي)</label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $governorate->name_ar) }}" required 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition-all">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">اسم المحافظة (EN)</label>
                <input type="text" name="name_en" value="{{ old('name_en', $governorate->name_en) }}" required 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">سعر الشحن (ج.م)</label>
                <input type="number" step="0.01" name="shipping_cost" value="{{ old('shipping_cost', $governorate->shipping_cost) }}" required 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition-all">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl transition shadow-md">حفظ التغييرات</button>
                <a href="{{ route('governorates.index') }}" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white font-black py-4 rounded-xl transition text-center shadow-sm">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
