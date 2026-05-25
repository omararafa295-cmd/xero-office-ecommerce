@extends('layouts.store')
@section('title', __('نتيجة الدفع') . ' - Xero Office')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-20">
    <div class="bg-white dark:bg-gray-800 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-lg p-8 md:p-10 text-center">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center text-5xl border-4 {{ $isSuccess ? 'bg-green-100 text-green-600 border-green-200 dark:bg-green-900/20 dark:border-green-800' : 'bg-yellow-100 text-yellow-600 border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800' }}">
            {{ $isSuccess ? '✓' : '!' }}
        </div>

        <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-3">
            {{ $isSuccess ? __('تم تأكيد الدفع بنجاح') : __('لم يكتمل الدفع بعد') }}
        </h1>

        <p class="text-gray-500 dark:text-gray-400 font-bold mb-8">
            {{ $isSuccess ? __('تم تسجيل الدفع على الطلب ويمكننا الآن بدء تجهيز الشحنة.') : __('يمكنك إعادة المحاولة مرة أخرى من الزر بالأسفل أو من صفحة طلباتي.') }}
        </p>

        <div class="bg-gray-50 dark:bg-gray-900/40 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 mb-8 text-right">
            <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-200 dark:border-gray-700">
                <span class="font-bold text-gray-500 dark:text-gray-400">{{ __('رقم الطلب') }}</span>
                <span class="font-black text-gray-900 dark:text-white">#{{ $order->id }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-200 dark:border-gray-700">
                <span class="font-bold text-gray-500 dark:text-gray-400">{{ __('طريقة الدفع') }}</span>
                <span class="font-black text-gray-900 dark:text-white">{{ $order->payment_method_label }}</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="font-bold text-gray-500 dark:text-gray-400">{{ __('حالة الدفع') }}</span>
                <span class="font-black {{ $isSuccess ? 'text-green-600' : 'text-yellow-600' }}">{{ $order->payment_status_label }}</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(!$isSuccess && $order->isPayable() && auth()->id() === $order->user_id)
                <a href="{{ route('payments.paymob.retry', $order) }}" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-bold transition">
                    {{ __('إعادة المحاولة') }}
                </a>
            @endif

            <a href="{{ route('my.orders') }}" class="bg-gray-900 hover:bg-black text-white px-8 py-3 rounded-xl font-bold transition">
                {{ __('الذهاب إلى طلباتي') }}
            </a>
        </div>
    </div>
</div>
@endsection
