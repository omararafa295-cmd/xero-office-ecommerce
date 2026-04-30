@extends('layouts.admin')
@section('title', 'نواقص المخزون')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                المنتجات منخفضة المخزون
            </h2>
            <p class="text-gray-500 font-bold text-sm mt-1">المنتجات التي تقل كميتها عن 5 قطع وتحتاج لإعادة طلب.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/30 text-sm border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th class="p-4 text-gray-500 font-bold">المنتج</th>
                        <th class="p-4 text-gray-500 font-bold text-center">الكمية المتبقية</th>
                        <th class="p-4 text-gray-500 font-bold text-center">السعر</th>
                        
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($low_stock_products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="p-4 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-xl object-cover border border-gray-200">
                                <span class="font-bold text-gray-900 dark:text-white">{{ $product->name_ar }}</span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="bg-red-100 text-red-700 font-black px-4 py-1.5 rounded-full text-sm animate-pulse">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="p-4 text-center font-bold text-gray-700 dark:text-gray-300">
                                {{ $product->price }} ج.م
                            </td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center">
                                <div class="w-16 h-16 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <h3 class="text-lg font-black text-gray-900 dark:text-white">المخزون ممتاز!</h3>
                                <p class="text-gray-500 font-bold mt-1">لا توجد أي منتجات منخفضة المخزون حالياً.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection