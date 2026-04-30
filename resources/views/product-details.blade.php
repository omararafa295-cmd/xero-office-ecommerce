@extends('layouts.store')

@section('title', app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="mb-6">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 transition font-bold flex items-center gap-2 w-fit">
            <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-arrow-right' : 'fa-solid fa-arrow-left' }}"></i> {{ __('العودة للرئيسية') }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row">
        
        <div class="md:w-1/2 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center p-8 relative">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}" class="max-w-full h-auto rounded-xl drop-shadow-md hover:scale-105 transition-transform duration-500 object-contain max-h-[350px]">
            @else
                <div class="flex flex-col items-center justify-center text-gray-300 dark:text-gray-600">
                    <i class="fa-solid fa-image text-8xl mb-4"></i>
                    <span class="font-bold text-lg">{{ __('لا توجد صورة') }}</span>
                </div>
            @endif
        </div>

        <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-center">
            
            <span class="inline-block bg-red-50 dark:bg-red-900/30 text-red-600 px-3 py-1 rounded-lg text-sm font-black w-fit mb-3 border border-red-100 dark:border-red-800/50">
                {{ $product->category ? (app()->getLocale() == 'ar' ? $product->category->name_ar : $product->category->name_en) : __('بدون تصنيف') }}
            </span>
            
            <h1 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white mb-2">
                {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
            </h1>
            
            <div class="flex items-center gap-2 mb-5">
                <div class="flex text-yellow-400 text-sm gap-0.5">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <span class="text-sm font-bold text-gray-500 dark:text-gray-400 pt-1">{{ __('(4.8/5 تقييم)') }}</span>
            </div>
            
            <div class="mb-6 flex flex-col">
                @if(isset($product->old_price) && $product->old_price > $product->price)
                    <span class="text-base text-gray-400 dark:text-gray-500 line-through font-bold mb-1">{{ number_format($product->old_price, 2) }} {{ __('ج.م') }}</span>
                @endif
                <div class="text-3xl font-black text-red-600 dark:text-red-500">
                    {{ number_format($product->price, 2) }} <span class="text-lg text-gray-500 font-bold">{{ __('ج.م') }}</span>
                </div>
            </div>
            
            <p class="text-base text-gray-600 dark:text-gray-300 mb-6 leading-relaxed font-semibold">
                {{ app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en }}
            </p>

            <div class="mb-6 flex items-center gap-2 bg-gray-50 dark:bg-gray-900/50 p-3 rounded-xl w-fit border border-gray-100 dark:border-gray-700">
                @if($product->stock > 0)
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-green-700 dark:text-green-400 font-bold text-sm">{{ __('متوفر في المخزون') }} ({{ $product->stock }})</span>
                @else
                    <span class="flex h-3 w-3 rounded-full bg-red-500"></span>
                    <span class="text-red-600 dark:text-red-400 font-bold text-sm">{{ __('نفذت الكمية') }}</span>
                @endif
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto flex flex-col gap-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="flex items-center gap-3">
                    <span class="font-bold text-gray-700 dark:text-gray-300">{{ __('الكمية:') }}</span>
                    <div class="flex items-center border-2 border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden h-10 w-28 bg-white dark:bg-gray-900 shadow-sm">
                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-9 h-full bg-gray-50 dark:bg-gray-800 hover:bg-red-50 hover:text-red-600 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold transition flex items-center justify-center border-l border-gray-200 dark:border-gray-600"><i class="fa-solid fa-minus text-xs"></i></button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="flex-1 text-center border-none bg-transparent text-gray-900 dark:text-white focus:ring-0 p-0 font-black text-base h-full">
                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-9 h-full bg-gray-50 dark:bg-gray-800 hover:bg-red-50 hover:text-red-600 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold transition flex items-center justify-center border-r border-gray-200 dark:border-gray-600"><i class="fa-solid fa-plus text-xs"></i></button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 mt-1">
                    <button type="submit" name="buy_now" value="1" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-black py-3 px-2 rounded-2xl transition-all shadow-[0_8px_20px_rgba(220,38,38,0.3)] hover:shadow-[0_10px_25px_rgba(220,38,38,0.5)] hover:-translate-y-1 flex justify-center items-center gap-2 text-base group">
                        <i class="fa-solid fa-bolt-lightning text-yellow-300 group-hover:scale-125 transition-transform"></i> {{ __('اشتري الآن') }}
                    </button>
                    
                    <button type="submit" class="flex-1 bg-gray-100 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white font-bold py-3 px-2 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all flex justify-center items-center gap-2 text-base shadow-sm">
                        <i class="fa-solid fa-cart-shopping"></i> {{ __('أضف للسلة') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection