@extends('layouts.store')
@section('title', __('طلباتي') . ' - Xero Office')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10 min-h-[60vh]">
    <h1 class="text-3xl font-black mb-8 text-gray-900 dark:text-white transition-colors">{{ __('طلباتي السابقة') }} 📦</h1>

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col md:flex-row justify-between items-center gap-6 transition-colors hover:shadow-md">
                    
                    <div class="flex flex-col gap-2 w-full md:w-1/3">
                        <span class="text-gray-500 dark:text-gray-400 font-bold text-sm">{{ __('رقم الطلب') }}</span>
                        <span class="text-2xl font-black text-gray-900 dark:text-white">#{{ $order->id }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 mt-2">🕒 {{ $order->created_at->format('Y-m-d') }}</span>
                    </div>

                    <div class="w-full md:w-1/3 flex md:justify-center">
                        @if($order->status == 'pending')
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">⏳ {{ __('قيد الانتظار - جاري المراجعة') }}</span>
                        @elseif($order->status == 'processing')
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">⚙️ {{ __('جاري التجهيز بالمخزن') }}</span>
                        @elseif($order->status == 'shipped')
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 border border-purple-200 dark:border-purple-800">🚚 {{ __('تم الشحن - في الطريق إليك') }}</span>
                        @elseif($order->status == 'delivered')
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">✅ {{ __('تم التوصيل بنجاح') }}</span>
                        @else
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">❌ {{ __('تم الإلغاء') }}</span>
                        @endif
                    </div>

                    <div class="w-full md:w-1/3 flex flex-col md:items-end gap-1">
                        <span class="text-gray-500 dark:text-gray-400 font-bold text-sm">{{ __('الإجمالي') }}</span>
                        <span class="text-2xl font-black text-red-600">{{ number_format($order->total_amount, 2) }} <span class="text-sm">{{ __('ج.م') }}</span></span>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <span class="text-7xl block mb-6">🛒</span>
            <p class="text-2xl font-bold text-gray-500 dark:text-gray-400 mb-6">{{ __('لم تقم بأي طلبات حتى الآن.') }}</p>
            <a href="{{ route('home') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-md">{{ __('تصفح المنتجات') }}</a>
        </div>
    @endif
</div>
@endsection