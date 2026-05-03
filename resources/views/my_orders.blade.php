@extends('layouts.store')
@section('title', __('طلباتي') . ' - Xero Office')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-16 min-h-[70vh]">
    
    <div class="text-center mb-12 relative">
        <div class="absolute left-1/2 -translate-x-1/2 -top-6 w-32 h-32 bg-red-600/10 rounded-full blur-[40px] pointer-events-none"></div>
        <div class="w-16 h-16 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-red-100 dark:border-red-800">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <h1 class="text-4xl font-black mb-4 text-gray-900 dark:text-white">{{ __('طلباتي السابقة') }}</h1>
        <p class="text-gray-500 font-bold text-lg">{{ __('تابع حالة وتفاصيل جميع طلباتك السابقة من مكان واحد') }}</p>
    </div>

    @if($orders->count() > 0)
        <div class="grid grid-cols-1 gap-6 md:gap-8">
            @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 p-6 md:p-8 flex flex-col transition-all group relative overflow-hidden">
                    
                    <!-- التفاصيل العلوية للكارت -->
                    <div class="flex flex-wrap gap-6 justify-between items-start md:items-center mb-6 border-b border-gray-100 dark:border-gray-700 pb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gray-50 dark:bg-gray-900/50 rounded-2xl flex items-center justify-center text-gray-900 dark:text-white font-black text-xl border border-gray-200 dark:border-gray-700 group-hover:bg-red-50 dark:group-hover:bg-red-900/20 group-hover:text-red-600 group-hover:border-red-100 transition-colors">
                                #
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white">{{ __('طلب رقم') }} {{ $order->id }}</h3>
                                <p class="text-sm text-gray-500 font-bold mt-1 flex items-center gap-1">
                                    <i class="fa-regular fa-calendar-days"></i> {{ $order->created_at->format('Y-m-d') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <p class="text-sm text-gray-500 font-bold mb-1">{{ __('الإجمالي') }}</p>
                            <p class="text-2xl font-black text-red-600">{{ number_format($order->total_amount, 2) }} <span class="text-sm">{{ __('ج.م') }}</span></p>
                        </div>
                    </div>

                    <!-- تفاصيل الحالة والأزرار -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        
                        @php
                            $statusStyles = [
                                'pending' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'text' => 'text-yellow-600', 'border' => 'border-yellow-200 dark:border-yellow-800', 'icon' => 'fa-clock', 'label' => __('قيد الانتظار - جاري المراجعة')],
                                'processing' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-600', 'border' => 'border-blue-200 dark:border-blue-800', 'icon' => 'fa-box-open', 'label' => __('جاري التجهيز بالمخزن')],
                                'shipped' => ['bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600', 'border' => 'border-purple-200 dark:border-purple-800', 'icon' => 'fa-truck-fast', 'label' => __('تم الشحن - في الطريق إليك')],
                                'delivered' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-600', 'border' => 'border-green-200 dark:border-green-800', 'icon' => 'fa-circle-check', 'label' => __('تم التوصيل بنجاح')],
                                'cancelled' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'text' => 'text-red-600', 'border' => 'border-red-200 dark:border-red-800', 'icon' => 'fa-circle-xmark', 'label' => __('تم الإلغاء')],
                            ];
                            $current = $statusStyles[$order->status] ?? $statusStyles['pending'];
                        @endphp
                        
                        <div class="inline-flex items-center gap-2 {{ $current['bg'] }} {{ $current['text'] }} px-4 py-2 rounded-xl text-sm font-black border {{ $current['border'] }}">
                            <i class="fa-solid {{ $current['icon'] }}"></i> {{ $current['label'] }}
                        </div>

                        <a href="{{ route('order.track.form') }}" class="w-full md:w-auto bg-gray-50 hover:bg-red-600 dark:bg-gray-900 dark:hover:bg-red-600 text-gray-700 dark:text-gray-200 hover:text-white px-6 py-3 rounded-xl font-bold transition-colors shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-location-crosshairs"></i> {{ __('تتبع الطلب') }}
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center">
            <div class="w-28 h-28 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-6 text-gray-300 dark:text-gray-600">
                <i class="fa-solid fa-clipboard-list text-6xl"></i>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white mb-3">{{ __('لا توجد طلبات سابقة') }}</p>
            <p class="text-gray-500 font-bold mb-8 text-lg">{{ __('لم تقم بإجراء أي طلبات حتى الآن. اكتشف منتجاتنا وابدأ التسوق!') }}</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-lg hover:shadow-red-500/30 hover:-translate-y-1">
                <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-arrow-right' : 'fa-solid fa-arrow-left' }}"></i> {{ __('تصفح المنتجات') }}
            </a>
        </div>
    @endif
</div>
@endsection