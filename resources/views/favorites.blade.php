@extends('layouts.store')
@section('title', __('قائمة المفضلة') . ' - Xero Office')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 min-h-[60vh]">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-xl flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-heart text-2xl"></i>
        </div>
        <h1 class="text-3xl font-black text-gray-900 dark:text-white">{{ __('قائمة المفضلة') }}</h1>
    </div>

    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($favorites as $favorite)
                @if($favorite->product)
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden group hover:shadow-lg transition hover:-translate-y-1 relative">
                    <div class="absolute top-3 left-3 z-20">
                        <form action="{{ route('products.favorite', $favorite->product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-10 h-10 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center text-red-600 hover:scale-110 transition shadow-sm" title="{{ __('إزالة من المفضلة') }}">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('product.show', $favorite->product->id) }}" class="block">
                        <div class="h-56 w-full bg-gray-50 dark:bg-gray-900/80 p-4 flex items-center justify-center overflow-hidden border-b border-gray-100 dark:border-gray-700">
                            <img src="{{ asset('storage/' . $favorite->product->image) }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6">
                            <span class="text-xs font-bold text-gray-400 mb-2 block">
                                {{ $favorite->product->category ? (app()->getLocale() == 'ar' ? $favorite->product->category->name_ar : $favorite->product->category->name_en) : __('بدون تصنيف') }}
                            </span>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-red-600 transition-colors">
                                {{ app()->getLocale() == 'ar' ? $favorite->product->name_ar : $favorite->product->name_en }}
                            </h3>
                            <p class="text-red-600 font-black text-2xl mt-4">{{ number_format($favorite->product->price, 2) }} <span class="text-sm text-gray-500">{{ __('ج.م') }}</span></p>
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center">
            <div class="w-28 h-28 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-6 text-gray-300 dark:text-gray-600">
                <i class="fa-regular fa-heart text-6xl"></i>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white mb-3">{{ __('قائمة المفضلة فارغة') }}</p>
            <p class="text-gray-500 font-bold mb-8 text-lg">{{ __('لم تقم بحفظ أي منتجات في مفضلتك حتى الآن.') }}</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-lg hover:shadow-red-500/30 hover:-translate-y-1">
                <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-arrow-right' : 'fa-solid fa-arrow-left' }}"></i> {{ __('اكتشف المنتجات') }}
            </a>
        </div>
    @endif
</div>
@endsection