@extends('layouts.store')
@section('title', __('تتبع طلبك') . ' - Xero Office')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-16">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-black mb-4">{{ __('تتبع حالة طلبك') }}</h1>
        <p class="text-gray-500 font-bold">{{ __('أدخل بيانات الطلب لمتابعة حالته لحظة بلحظة') }}</p>
    </div>

    <form action="{{ route('order.track.result') }}" method="POST" class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 mb-10">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="order_id" placeholder="{{ __('رقم الطلب (مثال: 105)') }}" required class="p-4 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl outline-none focus:ring-2 focus:ring-red-600">
            <input type="text" name="phone" placeholder="{{ __('رقم الموبايل المسجل') }}" required class="p-4 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl outline-none focus:ring-2 focus:ring-red-600">
        </div>
        <button type="submit" class="w-full mt-4 bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl transition shadow-lg">{{ __('تتبع الآن') }}</button>
    </form>

    @if(isset($order))
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 dark:border-gray-700 pb-4">
                <span class="font-black">{{ __('طلب رقم:') }} #{{ $order->id }}</span>
                <span class="bg-red-50 text-red-600 px-3 py-1 rounded-lg text-xs font-black">{{ __($order->status) }}</span>
            </div>

            <div class="relative flex flex-col gap-8">
                @php 
                    $statuses = [
                        'pending' => __('تم استلام الطلب'), 
                        'processing' => __('جاري التجهيز'), 
                        'shipped' => __('خرج للشحن'), 
                        'delivered' => __('تم التسليم')
                    ];
                    $currentStatus = $order->status;
                    $reached = true;
                @endphp

                @foreach($statuses as $key => $label)
                    <div class="flex items-center gap-4 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center z-10 {{ $reached ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-400' }}">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <span class="font-bold {{ $reached ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">{{ $label }}</span>
                        @if($key == $currentStatus) @php $reached = false; @endphp @endif
                    </div>
                @endforeach
                <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-[19px]' : 'left-[19px]' }} top-4 w-0.5 h-[80%] bg-gray-100 dark:bg-gray-700 -z-0"></div>
            </div>
        </div>
    @endif
</div>
@endsection