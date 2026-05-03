@extends('layouts.store')
@section('title', __('تتبع طلبك') . ' - Xero Office')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16 min-h-[70vh]">
    
    <div class="text-center mb-12 relative">
        <div class="absolute left-1/2 -translate-x-1/2 -top-6 w-32 h-32 bg-red-600/10 rounded-full blur-[40px] pointer-events-none"></div>
        <div class="w-16 h-16 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-red-100 dark:border-red-800">
            <i class="fa-solid fa-map-location-dot"></i>
        </div>
        <h1 class="text-4xl font-black mb-4 text-gray-900 dark:text-white">{{ __('تتبع حالة طلبك') }}</h1>
        <p class="text-gray-500 font-bold text-lg">{{ __('أدخل بيانات الطلب لمتابعة حالته لحظة بلحظة وبكل سهولة') }}</p>
    </div>

    <form action="{{ route('order.track.result') }}" method="POST" class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-[2rem] shadow-xl shadow-gray-100 dark:shadow-none border border-gray-100 dark:border-gray-700 mb-12 relative z-10">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="relative group">
                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-5' : 'left-0 pl-5' }} flex items-center pointer-events-none text-gray-400 group-focus-within:text-red-600 transition-colors">
                    <i class="fa-solid fa-hashtag text-lg"></i>
                </div>
                <input type="text" name="order_id" placeholder="{{ __('رقم الطلب (مثال: 105)') }}" required 
                    class="w-full p-4 {{ app()->getLocale() == 'ar' ? 'pr-14' : 'pl-14' }} bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all font-bold text-gray-900 dark:text-white text-lg">
            </div>

            <div class="relative group">
                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-5' : 'left-0 pl-5' }} flex items-center pointer-events-none text-gray-400 group-focus-within:text-red-600 transition-colors">
                    <i class="fa-solid fa-phone text-lg"></i>
                </div>
                <input type="text" name="phone" placeholder="{{ __('رقم الموبايل المسجل') }}" required 
                    class="w-full p-4 {{ app()->getLocale() == 'ar' ? 'pr-14' : 'pl-14' }} bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all font-bold text-gray-900 dark:text-white text-lg">
            </div>

        </div>
        
        <button type="submit" class="w-full mt-8 bg-gray-900 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white font-black py-4 rounded-2xl transition-all shadow-[0_8px_20px_rgba(220,38,38,0.2)] hover:-translate-y-1 flex justify-center items-center gap-3 text-lg">
            {{ __('تتبع الطلب') }} <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>

    @if(isset($order))
        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-lg overflow-hidden mt-8">
            
            <!-- هيدر النتيجة -->
            <div class="bg-gray-50 dark:bg-gray-900/50 p-6 md:p-8 border-b border-gray-100 dark:border-gray-700 flex flex-wrap gap-6 justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-900 dark:text-white font-black text-xl">
                        #
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-bold mb-1">{{ __('رقم الطلب') }}</p>
                        <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $order->id }}</p>
                    </div>
                </div>
                <div class="hidden sm:block w-px h-10 bg-gray-200 dark:bg-gray-700"></div>
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">{{ __('تاريخ الطلب') }}</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $order->created_at->format('Y-m-d') }}</p>
                </div>
                <div class="hidden sm:block w-px h-10 bg-gray-200 dark:bg-gray-700"></div>
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">{{ __('الإجمالي') }}</p>
                    <p class="text-xl font-black text-red-600">{{ number_format($order->total_amount, 2) }} <span class="text-sm">{{ __('ج.م') }}</span></p>
                </div>
            </div>

            <div class="p-8 md:p-12">
                @if($order->status == 'cancelled')
                    <div class="text-center py-6">
                        <div class="w-24 h-24 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 text-5xl">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-2">{{ __('تم إلغاء هذا الطلب') }}</h3>
                        <p class="text-gray-500 font-bold">{{ __('للأسف تم إلغاء الطلب، يمكنك تقديم طلب جديد في أي وقت.') }}</p>
                    </div>
                @else
                    @php 
                        $statuses = [
                            'pending' => ['label' => __('تم استلام الطلب'), 'icon' => 'fa-clipboard-check'], 
                            'processing' => ['label' => __('جاري التجهيز'), 'icon' => 'fa-box-open'], 
                            'shipped' => ['label' => __('خرج للشحن'), 'icon' => 'fa-truck-fast'], 
                            'delivered' => ['label' => __('تم التسليم'), 'icon' => 'fa-house-circle-check']
                        ];
                        $currentStatus = $order->status;
                        $statusKeys = array_keys($statuses);
                        $currentIndex = array_search($currentStatus, $statusKeys);
                    @endphp

                    <!-- شريط التقدم (Timeline) -->
                    <div class="relative mt-4 mb-4">
                        <!-- الخط الخلفي للشاشات الكبيرة -->
                        <div class="hidden md:block absolute top-7 left-10 right-10 h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full z-0"></div>
                        <!-- الخط النشط للشاشات الكبيرة -->
                        <div class="hidden md:block absolute top-7 {{ app()->getLocale() == 'ar' ? 'right-10' : 'left-10' }} h-1.5 bg-red-600 rounded-full z-0 transition-all duration-1000" style="width: {{ $currentIndex !== false ? ($currentIndex / (count($statuses) - 1)) * 100 : 0 }}%"></div>
                        
                        <div class="flex flex-col md:flex-row justify-between relative z-10 gap-10 md:gap-0">
                            @foreach($statuses as $key => $data)
                                @php 
                                    $stepIndex = array_search($key, $statusKeys);
                                    $isCompleted = $currentIndex !== false && $stepIndex <= $currentIndex;
                                    $isCurrent = $stepIndex == $currentIndex;
                                @endphp
                                <div class="flex md:flex-col items-center gap-5 md:gap-4 flex-1 relative group">
                                    <!-- الخط العمودي للموبايل -->
                                    @if(!$loop->last)
                                    <div class="md:hidden absolute {{ app()->getLocale() == 'ar' ? 'right-[1.4rem]' : 'left-[1.4rem]' }} top-14 h-14 w-1.5 bg-gray-100 dark:bg-gray-700 rounded-full z-0"></div>
                                    <div class="md:hidden absolute {{ app()->getLocale() == 'ar' ? 'right-[1.4rem]' : 'left-[1.4rem]' }} top-14 w-1.5 bg-red-600 rounded-full z-0 transition-all duration-1000" style="height: {{ $currentIndex > $stepIndex ? '3.5rem' : '0' }}"></div>
                                    @endif

                                    <!-- الأيقونة (الدائرة) -->
                                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center relative z-10 transition-all duration-500 border-4 border-white dark:border-gray-800 {{ $isCompleted ? 'bg-red-600 text-white shadow-[0_0_15px_rgba(220,38,38,0.3)]' : 'bg-gray-100 dark:bg-gray-700 text-gray-400' }}">
                                        @if($isCompleted && !$isCurrent)
                                            <i class="fa-solid fa-check text-xl"></i>
                                        @else
                                            <i class="fa-solid {{ $data['icon'] }} text-xl {{ $isCurrent ? 'animate-bounce' : '' }}"></i>
                                        @endif
                                        
                                        <!-- مؤثر النبض للخطوة الحالية -->
                                        @if($isCurrent)
                                        <span class="absolute inset-0 rounded-full border-2 border-red-600 animate-ping opacity-75"></span>
                                        @endif
                                    </div>
                                    
                                    <!-- النص (Label) -->
                                    <div class="text-right md:text-center mt-1">
                                        <h4 class="font-black text-lg {{ $isCompleted ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">{{ $data['label'] }}</h4>
                                        @if($isCurrent)
                                            <p class="text-xs font-bold text-red-600 mt-1">{{ __('الحالة الحالية') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection