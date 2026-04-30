@extends('layouts.store')
@section('title', __('تم الطلب بنجاح!') . ' - Xero Office')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-20 text-center">
    <div class="bg-white dark:bg-gray-800 p-10 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 transition-colors">
        
        <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 text-green-500 rounded-full flex items-center justify-center text-5xl mx-auto mb-6 border-4 border-green-200 dark:border-green-800 animate-bounce">
            🎉
        </div>
        
        <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-4">{{ __('تم استلام طلبك بنجاح!') }}</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 font-bold mb-8">
            {{ __('شكراً لتسوقك من Xero Office. سيتم التواصل معك قريباً لتأكيد الشحن.') }}
        </p>

        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-2xl mb-8 border border-gray-200 dark:border-gray-600 inline-block">
            <span class="text-gray-500 dark:text-gray-400 text-sm block mb-1">{{ __('رقم الطلب الخاص بك') }}</span>
            <span class="text-3xl font-black text-red-600">#{{ session('order_id') }}</span>
        </div>

        <div class="flex gap-4 justify-center">
            <a href="{{ route('my.orders') ?? '#' }}" class="bg-gray-900 dark:bg-gray-700 hover:bg-black dark:hover:bg-gray-600 text-white px-8 py-3 rounded-xl font-bold transition shadow-md">
                {{ __('متابعة طلباتي') }}
            </a>
            <a href="{{ route('home') }}" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-md">
                {{ __('العودة للرئيسية') }}
            </a>
        </div>
        
    </div>
</div>
@endsection