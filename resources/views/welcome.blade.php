@extends('layouts.store')
@section('title', __('الرئيسية') . ' - Xero Office')

@section('content')
<style>
    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }
    .animate-float-slow { animation: float 6s ease-in-out infinite; }
    .animate-float-medium { animation: float 5s ease-in-out infinite 1s; }
    .animate-float-fast { animation: float 4s ease-in-out infinite 2s; }
</style>

<div class="relative z-10 text-center px-4 mt-8">
    <span class="inline-block bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-4 py-1.5 rounded-full text-sm font-black mb-6 border border-red-100 dark:border-red-800/50">
        {{ __('🚀 الخيار الأول لحلول الطباعة') }}
    </span>
    
    <h1 class="text-2xl sm:text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-4 md:mb-6 leading-tight px-2">
        {{ __('اكتشف عالم الطباعة') }} <br> <span class="text-red-600">{{ __('الاحترافي') }}</span>
    </h1>
    
    <p class="text-gray-600 dark:text-gray-300 font-bold text-sm sm:text-lg md:text-xl max-w-2xl mx-auto mb-8 md:mb-10 px-4">
        {{ __('أفضل الطابعات، أحبار أصلية، وقطع غيار بضمان حقيقي. كل ما يحتاجه مكتبك في مكان واحد.') }}
    </p>
    
    <a href="#categories" class="inline-flex items-center gap-2 md:gap-3 bg-red-600 hover:bg-red-700 text-white px-6 py-3 md:px-8 md:py-4 rounded-xl font-bold transition-all shadow-[0_8px_20px_rgba(220,38,38,0.3)] hover:-translate-y-1 text-sm md:text-lg">
        {{ __('تصفح المنتجات') }} <i class="fa-solid fa-arrow-down-long animate-bounce"></i>
    </a>
</div>
    
<div class="relative bg-white dark:bg-gray-800 rounded-3xl md:rounded-[2.5rem] my-8 md:my-16 mx-4 max-w-7xl xl:mx-auto shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col md:flex-row items-center gap-6 md:gap-10 p-6 md:p-12">
    
    <div class="absolute left-10 top-1/2 -translate-y-1/2 w-64 h-64 bg-red-100 dark:bg-red-900/20 rounded-full blur-[60px] pointer-events-none"></div>

    <div class="md:w-1/2 relative w-full flex justify-center order-2 md:order-1">
        <img src="{{ asset('images/hero-printer.png') }}" alt="Xero LaserJet Printer" class="max-w-full h-auto object-contain hover:scale-105 transition-transform duration-500 drop-shadow-xl relative z-10" style="max-height: 350px;">
    </div>

    <div class="md:w-1/2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} order-1 md:order-2 relative z-10">
        <span class="inline-block bg-red-50 dark:bg-red-900/30 text-red-600 px-4 py-1.5 rounded-full text-sm font-black mb-4 border border-red-100 dark:border-red-800/50">
            {{ __('عرض خاص لفترة محدودة ⏱️') }}
        </span>
        
        <h2 class="text-xl sm:text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 md:mb-6 leading-tight">
            {{ __('طابعات') }} <br> <span class="text-red-600">Xero LaserJet</span> <br> {{ __('جيل جديد من الكفاءة') }}
        </h2>
        
        <p class="text-gray-600 dark:text-gray-300 font-bold mb-6 md:mb-8 text-sm sm:text-lg md:text-xl leading-relaxed">
            {{ __('استمتع بأداء لا يضاهى مع أحدث تقنيات الطباعة الليزر. توفير في الحبر، سرعة في الإنجاز، وجودة تدوم طويلاً.') }}
        </p>
        
        <a href="#shop" class="inline-flex items-center gap-2 md:gap-3 bg-gray-900 dark:bg-gray-100 hover:bg-red-600 dark:hover:bg-red-600 text-white dark:text-gray-900 hover:text-white px-6 py-3 md:px-8 md:py-4 rounded-xl font-bold transition-colors shadow-md text-sm md:text-lg">
            {{ __('ابدأ التسوق') }} <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i>
        </a>
    </div>

</div>

<div class="max-w-7xl mx-auto px-4 mb-10 md:mb-16 relative z-20" data-aos="fade-up" data-aos-delay="300">
    <div class="bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 md:p-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 divide-x divide-x-reverse divide-gray-100 dark:divide-gray-700" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <div class="flex flex-col items-center text-center group">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-red-50 dark:bg-gray-700 rounded-full flex items-center justify-center text-red-600 mb-3 md:mb-4 group-hover:scale-110 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-truck-fast text-xl md:text-2xl"></i>
                </div>
                <h4 class="font-black text-gray-900 dark:text-white text-sm sm:text-base md:text-lg mb-1">{{ __('شحن سريع') }}</h4>
                <p class="text-xs sm:text-sm font-bold text-gray-500">{{ __('استلم شحنتك خلال 3 أيام عمل') }}</p>
            </div>
            
            <div class="flex flex-col items-center text-center group">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-50 dark:bg-gray-700 rounded-full flex items-center justify-center text-blue-600 mb-3 md:mb-4 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-rotate-left text-xl md:text-2xl"></i>
                </div>
                <h4 class="font-black text-gray-900 dark:text-white text-sm sm:text-base md:text-lg mb-1">{{ __('إرجاع مجاني') }}</h4>
                <p class="text-xs sm:text-sm font-bold text-gray-500">{{ __('إرجاع مجانى فى حالة التلفيات') }}</p>
            </div>
            
            <div class="flex flex-col items-center text-center group">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-green-50 dark:bg-gray-700 rounded-full flex items-center justify-center text-green-600 mb-3 md:mb-4 group-hover:scale-110 group-hover:bg-green-600 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-headset text-xl md:text-2xl"></i>
                </div>
                <h4 class="font-black text-gray-900 dark:text-white text-sm sm:text-base md:text-lg mb-1">{{ __('خدمة العملاء') }}</h4>
                <p class="text-xs sm:text-sm font-bold text-gray-500">{{ __('دعم مجاني على مدار الساعة') }}</p>
            </div>
            
            <div class="flex flex-col items-center text-center group">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-purple-50 dark:bg-gray-700 rounded-full flex items-center justify-center text-purple-600 mb-3 md:mb-4 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-credit-card text-xl md:text-2xl"></i>
                </div>
                <h4 class="font-black text-gray-900 dark:text-white text-sm sm:text-base md:text-lg mb-1">{{ __('الدفع') }}</h4>
                <p class="text-xs sm:text-sm font-bold text-gray-500">{{ __('طرق دفع تناسب الجميع') }}</p>
            </div>
        </div>
    </div>
</div>

<div id="categories" class="max-w-7xl mx-auto px-4 py-12 scroll-mt-20">
    <div class="text-center mb-12" data-aos="fade-up">
    <h2 class="text-xl md:text-4xl font-black text-gray-900 dark:text-white mb-4 transition-colors">{{ __('تسوق حسب القسم') }}</h2>
    <div class="h-1.5 w-20 bg-red-600 mx-auto rounded-full"></div>
</div>
</div>
    </div>

    <div class="flex flex-wrap justify-center gap-3 sm:gap-6 md:gap-8">
        @php
            $home_categories = \App\Models\Category::all();
        @endphp

        @foreach($home_categories as $index => $category)
        <a href="{{ route('category.show', $category->name_en) }}" class="w-[calc(50%-6px)] sm:w-40 md:w-48 lg:w-56 group bg-white dark:bg-gray-800 p-4 md:p-8 rounded-2xl md:rounded-[2rem] border-2 border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:border-red-500 dark:hover:border-red-500 transition-all text-center" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
            <div class="w-16 h-16 md:w-24 md:h-24 bg-gray-50 dark:bg-gray-900/50 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4 transition-all duration-500 group-hover:scale-110 p-2 md:p-3 relative overflow-hidden">
                <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/logo.png') }}" alt="{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}" class="w-full h-full object-contain drop-shadow-lg relative z-10">
            </div>
            <h3 class="font-black text-xs sm:text-sm md:text-lg text-gray-900 dark:text-white group-hover:text-red-600 transition-colors">{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</h3>
        </a>
        @endforeach
    </div>
</div>

<div class="w-full bg-white dark:bg-gray-800 border-y border-gray-100 dark:border-gray-700 py-8 my-16 overflow-hidden relative shadow-inner">
    <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-white dark:from-gray-800 to-transparent z-10 pointer-events-none"></div>
    <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-white dark:from-gray-800 to-transparent z-10 pointer-events-none"></div>
    
    <div class="flex items-center space-x-16 space-x-reverse animate-marquee whitespace-nowrap px-8" dir="ltr">
        @for($i=0; $i<2; $i++)
            <h2 class="text-2xl md:text-4xl font-black text-gray-300 dark:text-gray-700 mx-4 md:mx-8">HP</h2>
            <h2 class="text-2xl md:text-4xl font-black text-gray-300 dark:text-gray-700 mx-4 md:mx-8">CANON</h2>
            <h2 class="text-2xl md:text-4xl font-black text-gray-300 dark:text-gray-700 mx-4 md:mx-8">EPSON</h2>
            <h2 class="text-2xl md:text-4xl font-black text-gray-300 dark:text-gray-700 mx-4 md:mx-8">SAMSUNG</h2>
            <h2 class="text-2xl md:text-4xl font-black text-gray-300 dark:text-gray-700 mx-4 md:mx-8">BROTHER</h2>
            <h2 class="text-2xl md:text-4xl font-black text-gray-300 dark:text-gray-700 mx-4 md:mx-8">LEXMARK</h2>
            <h2 class="text-2xl md:text-4xl font-black text-gray-300 dark:text-gray-700 mx-4 md:mx-8">XEROX</h2>
        @endfor
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 mb-16">
    <div class="relative bg-gradient-to-r from-red-600 to-red-800 rounded-3xl md:rounded-[3rem] p-6 md:p-16 shadow-2xl flex flex-col md:flex-row items-center justify-between overflow-hidden" data-aos="zoom-in" data-aos-duration="800">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-[80px]"></div>
            <div class="absolute right-20 top-10 w-40 h-40 bg-black/20 rounded-full blur-[40px]"></div>
        </div>

        <div class="w-full md:w-1/2 z-10 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} mb-8 md:mb-0">
            <div class="inline-flex items-center gap-2 bg-black/30 backdrop-blur text-white px-4 py-2 rounded-full text-sm font-bold mb-6 border border-white/10">
                <i class="fa-solid fa-bolt text-yellow-400 animate-pulse"></i> {{ __('عرض الفلاش السريع') }}
            </div>
            <h2 class="text-xl sm:text-4xl md:text-5xl font-black text-white leading-tight mb-3 md:mb-4">{{ __('خصم 30% على أحبار') }}<br>{{ __('الجيل الجديد') }}</h2>
            <p class="text-red-100 font-bold text-xs sm:text-base md:text-lg mb-6 md:mb-8">{{ __('العرض ينتهي قريباً، اغتنم الفرصة الآن قبل نفاذ الكمية!') }}</p>
            
            <div id="timer-container" class="flex gap-2 sm:gap-4 {{ app()->getLocale() == 'ar' ? 'justify-end md:justify-start' : 'justify-start' }}" dir="ltr">
                <div class="bg-white/10 backdrop-blur border border-white/20 rounded-xl sm:rounded-2xl w-16 h-16 sm:w-20 sm:h-20 flex flex-col items-center justify-center">
                    <span id="hours" class="text-2xl sm:text-3xl font-black text-white">00</span>
                    <span class="text-[10px] sm:text-xs text-red-200 font-bold mt-1">{{ __('ساعة') }}</span>
                </div>
                <div class="bg-white/10 backdrop-blur border border-white/20 rounded-xl sm:rounded-2xl w-16 h-16 sm:w-20 sm:h-20 flex flex-col items-center justify-center">
                    <span id="minutes" class="text-2xl sm:text-3xl font-black text-white">00</span>
                    <span class="text-[10px] sm:text-xs text-red-200 font-bold mt-1">{{ __('دقيقة') }}</span>
                </div>
                <div class="bg-white/10 backdrop-blur border border-white/20 rounded-xl sm:rounded-2xl w-16 h-16 sm:w-20 sm:h-20 flex flex-col items-center justify-center">
                    <span id="seconds" class="text-2xl sm:text-3xl font-black text-white">00</span>
                    <span class="text-[10px] sm:text-xs text-red-200 font-bold mt-1">{{ __('ثانية') }}</span>
                </div>
            </div>
        </div>

        <div class="w-full md:w-5/12 z-10 relative">
            <div class="absolute inset-0 bg-white/20 rounded-full blur-[60px] animate-pulse"></div>
            <img src="{{ asset('images/logo.png') }}" alt="Flash Sale" class="relative z-10 w-full object-contain drop-shadow-[0_20px_20px_rgba(0,0,0,0.5)] animate-float-slow brightness-0 invert">
        </div>
    </div>
</div>

<div id="products" class="max-w-7xl mx-auto px-4 py-16">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-12 gap-6" data-aos="fade-up">
        <div class="text-center sm:text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
            <h2 class="text-xl md:text-4xl font-black text-gray-900 dark:text-white mb-4 transition-colors">{{ __('أحدث المنتجات') }}</h2>
            <div class="h-1.5 w-20 bg-red-600 mx-auto sm:mx-0 rounded-full"></div>
        </div>
        <!-- أزرار التقليب -->
        <div class="hidden sm:flex items-center gap-2">
            <button onclick="scrollLatestProducts('prev')" class="w-12 h-12 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full flex items-center justify-center text-gray-500 hover:text-red-600 hover:border-red-600 transition-all shadow-sm group">
                <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-chevron-right' : 'fa-solid fa-chevron-left' }} group-hover:scale-110 transition-transform"></i>
            </button>
            <button onclick="scrollLatestProducts('next')" class="w-12 h-12 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full flex items-center justify-center text-gray-500 hover:text-red-600 hover:border-red-600 transition-all shadow-sm group">
                <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right' }} group-hover:scale-110 transition-transform"></i>
            </button>
        </div>
    </div>

    <div id="latest-products-container" class="flex gap-4 sm:gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-6 sm:pb-8 hide-scrollbar">
        @foreach($products as $index => $product)
            <div class="flex-none w-[80%] sm:w-[calc(50%-12px)] md:w-[calc(33.333%-16px)] lg:w-[calc(25%-18px)] snap-start bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl shadow-md border-2 border-gray-200 dark:border-gray-700 hover:border-red-500 dark:hover:border-red-500 overflow-hidden group hover:shadow-[0_10px_30px_rgba(220,38,38,0.15)] transition-all duration-300 relative flex flex-col" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                <div class="absolute top-4 left-4 z-20">
                    <form action="{{ route('products.favorite', $product->id) }}" method="POST" class="favorite-form">
                        @csrf
                        <button type="submit" class="w-10 h-10 bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 hover:border-red-500 hover:scale-110 transition-all shadow-sm">
                            @if(auth()->check() && auth()->user()->favorites->contains('product_id', $product->id)) 
                                <i class="fa-solid fa-heart text-red-600"></i>
                            @else 
                                <i class="fa-regular fa-heart"></i>
                            @endif
                        </button>
                    </form>
                </div>
                <a href="{{ route('product.show', $product->id) }}" class="relative h-48 sm:h-56 overflow-hidden block bg-gray-50 dark:bg-gray-900/80 p-3 sm:p-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-center">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                </a>
                <div class="p-4 sm:p-6 flex flex-col flex-grow">
                    <span class="text-xs font-bold text-gray-400 dark:text-gray-500 mb-2">
                        {{ $product->category ? (app()->getLocale() == 'ar' ? $product->category->name_ar : $product->category->name_en) : __('عام') }}
                    </span>
                    <a href="{{ route('product.show', $product->id) }}">
                        <h3 class="font-bold text-sm sm:text-lg text-gray-900 dark:text-white mb-1 sm:mb-2 line-clamp-2 group-hover:text-red-600 transition-colors">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h3>
                    </a>
                   <div class="mt-auto pt-4 flex justify-between items-end">
                        
                        <div class="flex flex-col">
                            @if($product->old_price && $product->old_price > $product->price)
                                <span class="text-sm text-gray-400 dark:text-gray-500 line-through font-bold mb-0.5">{{ number_format($product->old_price, 2) }} {{ __('ج.م') }}</span>
                            @endif
                            <span class="text-xl sm:text-2xl font-black text-red-600">{{ number_format($product->price, 2) }} <span class="text-xs sm:text-sm text-gray-500">{{ __('ج.م') }}</span></span>
                        </div>
                        
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart-form">
                            @csrf
                            <button type="submit" class="bg-gray-100 border border-gray-200 dark:border-gray-600 text-gray-700 dark:bg-gray-700 dark:text-white hover:bg-red-600 hover:text-white hover:border-red-600 dark:hover:bg-red-600 w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl flex items-center justify-center transition-all shadow-sm group/btn">
                                <i class="fa-solid fa-cart-plus group-hover/btn:scale-110 transition-transform"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="about" class="max-w-6xl mx-auto px-4 py-12 md:py-16">
    <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-10 relative overflow-hidden">
        
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-50 dark:bg-red-900/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="text-center max-w-4xl mx-auto">
            <div class="w-12 h-12 mx-auto bg-red-50 dark:bg-red-900/30 text-red-600 rounded-xl flex items-center justify-center mb-4">
                <i class="fa-solid fa-building text-xl"></i>
            </div>
            
            <h2 class="text-xl md:text-3xl font-black text-gray-900 dark:text-white mb-4 md:mb-5">
                {{ __('من نحن') }}
                <div class="w-12 h-1 bg-red-600 mx-auto mt-3 rounded-full"></div>
            </h2>

            <p class="text-gray-600 dark:text-gray-300 font-bold leading-relaxed mb-6 md:mb-8 text-sm md:text-lg">
                {{ __('تأسست شركة') }} 
                <span class="inline-block bg-red-50 dark:bg-red-900/30 text-red-600 px-3 py-0.5 rounded-lg text-sm font-black mx-1">Xero Office</span> 
                <span class="inline-block bg-red-50 dark:bg-red-900/30 text-red-600 px-3 py-0.5 rounded-lg text-sm font-black mx-1">{{ __('منذ عام 2004') }}</span>،
                {{ __('لتمثل الوجهة الأولى لحلول الطباعة المتكاملة والأدوات المكتبية. بخبرة تمتد لأكثر من 20 عاماً، نقدم لك أحدث الطابعات، وأجود أنواع الأحبار، مع خدمات صيانة احترافية تضمن استمرار أعمالك بكفاءة وبدون توقف.') }}
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5">
            
            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 md:p-5 rounded-xl md:rounded-2xl flex flex-col items-center text-center border border-gray-100 dark:border-gray-700 transition hover:-translate-y-1 hover:shadow-md">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-100 dark:bg-purple-900/30 text-purple-600 rounded-full flex items-center justify-center mb-2 md:mb-3">
                    <i class="fa-solid fa-headset text-base md:text-lg"></i>
                </div>
                <h3 class="text-lg md:text-xl font-black text-gray-900 dark:text-white mb-1">24/7</h3>
                <p class="text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400">{{ __('دعم فني مستمر') }}</p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 md:p-5 rounded-xl md:rounded-2xl flex flex-col items-center text-center border border-gray-100 dark:border-gray-700 transition hover:-translate-y-1 hover:shadow-md">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-full flex items-center justify-center mb-2 md:mb-3">
                    <i class="fa-solid fa-boxes-stacked text-base md:text-lg"></i>
                </div>
                <h3 class="text-lg md:text-xl font-black text-gray-900 dark:text-white mb-1">500+</h3>
                <p class="text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400">{{ __('منتج متاح') }}</p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 md:p-5 rounded-xl md:rounded-2xl flex flex-col items-center text-center border border-gray-100 dark:border-gray-700 transition hover:-translate-y-1 hover:shadow-md">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-full flex items-center justify-center mb-2 md:mb-3">
                    <i class="fa-solid fa-handshake text-base md:text-lg"></i>
                </div>
                <h3 class="text-lg md:text-xl font-black text-gray-900 dark:text-white mb-1">1000+</h3>
                <p class="text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400">{{ __('عميل يثق بنا') }}</p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 md:p-5 rounded-xl md:rounded-2xl flex flex-col items-center text-center border border-gray-100 dark:border-gray-700 transition hover:-translate-y-1 hover:shadow-md">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 rounded-full flex items-center justify-center mb-2 md:mb-3">
                    <i class="fa-solid fa-award text-base md:text-lg"></i>
                </div>
                <h3 class="text-lg md:text-xl font-black text-gray-900 dark:text-white mb-1">2004</h3>
                <p class="text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400">{{ __('سنة التأسيس') }}</p>
            </div>

        </div>
    </div>
</div>
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-float { animation: float 4s ease-in-out infinite; }
    
    @keyframes float-slow {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
    }
    .animate-float-slow { animation: float-slow 6s ease-in-out infinite; }

    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(100%); }
    }
    .animate-marquee { animation: marquee 25s linear infinite; }
    
    /* إخفاء شريط التمرير للكاروسيل */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // جلب وقت انتهاء العرض من السيرفر مباشرة (موحد لجميع الزوار)
        let endTime = {{ $flashSaleEndTime }};

        let timer = setInterval(function() {
            let now = new Date().getTime();
            let distance = endTime - now;

            if (distance < 0) {
                clearInterval(timer);
                document.getElementById("timer-container").innerHTML = "<div class='bg-black/40 backdrop-blur border border-red-400 text-white font-bold px-6 py-4 rounded-2xl'>{{ __('انتهى العرض! ترقبوا عروضنا القادمة قريباً ⏳') }}</div>";
                return;
            }

            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("hours").innerText = hours < 10 ? "0" + hours : hours;
            document.getElementById("minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
            document.getElementById("seconds").innerText = seconds < 10 ? "0" + seconds : seconds;
        }, 1000);
    });

    function scrollLatestProducts(direction) {
        const container = document.getElementById('latest-products-container');
        const card = container.querySelector('.flex-none');
        if (!card) return;
        
        const scrollAmount = card.offsetWidth + 24; 
        const isRtl = "{{ app()->getLocale() }}" === "ar";
        
        let delta = direction === 'next' ? scrollAmount : -scrollAmount;
        if (isRtl) delta = -delta; 
        
        container.scrollBy({ left: delta, behavior: 'smooth' });
    }
</script>
@endsection