@extends('layouts.store')
@section('title', __('قسم') . ' ' . (app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en) . ' - Xero Office')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    
    <nav class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-8 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-red-600 transition"><i class="fa-solid fa-house text-xs"></i> {{ __('الرئيسية') }}</a>
        <span class="text-gray-300 dark:text-gray-600">/</span>
        <span class="text-gray-900 dark:text-white">{{ __('قسم') }} {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</span>
    </nav>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 mb-10 text-center flex flex-col items-center justify-center relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-600/5 rounded-full blur-[50px] pointer-events-none"></div>
        
        @php
            $icons = [
                'printers' => 'images/printer.png',
                'inks' => 'images/ink.png',
                'cartridges' => 'images/cartridge.png',
                'maintenance' => 'images/tool.png',
            ];
            $categoryIcon = array_key_exists($category->slug, $icons) ? $icons[$category->slug] : 'images/logo.png';
        @endphp

        <div class="w-24 h-24 mb-6 rounded-3xl bg-gray-50 dark:bg-gray-100 flex items-center justify-center p-4 shadow-inner border border-gray-200">
            <img src="{{ asset($categoryIcon) }}" alt="{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}" class="w-full h-full object-contain drop-shadow-sm hover:scale-110 transition-transform duration-300">
        </div>
        
        <h1 class="text-4xl font-black text-gray-900 dark:text-white">{{ __('قسم') }} {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 p-5 md:p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 mb-8 flex flex-col lg:flex-row justify-between items-center gap-6">
        
        <div class="flex items-center gap-4 w-full lg:w-auto">
            <div class="w-12 h-12 bg-gray-50 dark:bg-gray-700/50 rounded-2xl flex items-center justify-center text-gray-500 dark:text-gray-400">
                <i class="fa-solid fa-sliders text-xl"></i>
            </div>
            <div>
                <h3 class="font-black text-gray-900 dark:text-white text-lg">{{ __('تصفية المنتجات') }}</h3>
                <p class="text-xs font-bold text-gray-500">{{ __('ابحث حسب نطاق السعر المناسب') }}</p>
            </div>
        </div>

        <form action="" method="GET" class="flex flex-col sm:flex-row flex-wrap items-center gap-4 w-full lg:w-auto">
            
            <div class="flex items-center gap-2 w-full sm:w-auto bg-gray-50 dark:bg-gray-900/50 p-1.5 rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="relative w-full sm:w-32 md:w-40">
                    <span class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} flex items-center text-gray-400 text-xs font-bold pointer-events-none">{{ __('من') }}</span>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full py-2.5 px-3 {{ app()->getLocale() == 'ar' ? 'pr-9 pl-3' : 'pl-9 pr-3' }} bg-white dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-sm font-bold text-center shadow-sm">
                </div>
                <span class="text-gray-300 dark:text-gray-600 font-bold">-</span>
                <div class="relative w-full sm:w-32 md:w-40">
                    <span class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} flex items-center text-gray-400 text-xs font-bold pointer-events-none">{{ __('إلى') }}</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="10000" class="w-full py-2.5 px-3 {{ app()->getLocale() == 'ar' ? 'pr-9 pl-3' : 'pl-9 pr-3' }} bg-white dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-sm font-bold text-center shadow-sm">
                </div>
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="flex-1 sm:flex-none bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-black transition shadow-[0_4px_15px_rgba(220,38,38,0.2)] hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-filter"></i> {{ __('تطبيق الفلتر') }}
                </button>
                
                @if(request()->filled('min_price') || request()->filled('max_price'))
                    <a href="{{ url()->current() }}" class="flex-none bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 w-11 h-11 rounded-2xl font-bold transition flex items-center justify-center" title="{{ __('مسح الفلتر') }}">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-[0_10px_30px_rgba(220,38,38,0.15)] transition-all duration-300 overflow-hidden border-2 border-gray-100 dark:border-gray-700 hover:border-red-500 dark:hover:border-red-500 relative flex flex-col h-full group">
                    
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

                    <a href="{{ route('product.show', $product->id) }}" class="flex flex-col flex-grow cursor-pointer">
                        <div class="h-56 w-full bg-gray-50 dark:bg-gray-900/80 flex items-center justify-center p-4 border-b border-gray-100 dark:border-gray-700 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-600">
                                    <i class="fa-solid fa-image text-4xl mb-2"></i>
                                    <span class="text-xs font-bold">{{ __('لا توجد صورة') }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6 pb-0 flex-grow">
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 mb-2">{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</span>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-red-600 transition-colors" title="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h3>
                        </div>
                    </a>
                    
                    <div class="p-6 pt-4 mt-auto">
                        <div class="flex flex-col mb-4">
                            @if($product->old_price && $product->old_price > $product->price)
                                <span class="text-sm text-gray-400 dark:text-gray-500 line-through font-bold mb-0.5">{{ number_format($product->old_price, 2) }} {{ __('ج.م') }}</span>
                            @endif
                            <span class="text-2xl font-black text-red-600">{{ number_format($product->price, 2) }} <span class="text-sm text-gray-500">{{ __('ج.م') }}</span></span>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart-form">
                            @csrf
                            <button type="submit" class="w-full bg-gray-100 border border-gray-200 dark:border-gray-600 text-gray-700 dark:bg-gray-700 dark:text-white hover:bg-red-600 hover:text-white hover:border-red-600 dark:hover:bg-red-600 font-bold py-3 px-4 rounded-xl transition-all flex justify-center items-center gap-2 shadow-sm">
                                <i class="fa-solid fa-cart-plus"></i> {{ __('أضف للسلة') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-10 flex justify-center">
            {{ $products->links() }}
        </div>
        
    @elseif(request()->filled('min_price') || request()->filled('max_price'))
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center">
            <div class="w-24 h-24 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-6 text-red-500">
                <i class="fa-solid fa-filter-circle-xmark text-5xl"></i>
            </div>
            <p class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ __('لا توجد نتائج مطابقة') }}</p>
            <p class="text-gray-500 font-bold mb-8">{{ __('لم نعثر على منتجات تطابق نطاق السعر الذي حددته.') }}</p>
            <a href="{{ url()->current() }}" class="inline-flex items-center gap-2 bg-gray-900 dark:bg-gray-600 hover:bg-gray-800 text-white px-8 py-3 rounded-xl font-bold transition shadow-md">
                <i class="fa-solid fa-rotate-left"></i> {{ __('مسح الفلتر') }}
            </a>
        </div>
        
    @else
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6 text-gray-300 dark:text-gray-500">
                <i class="fa-solid fa-box-open text-5xl"></i>
            </div>
            <p class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ __('القسم فارغ حالياً') }}</p>
            <p class="text-gray-500 font-bold mb-8">{{ __('نعمل على توفير أفضل المنتجات في هذا القسم قريباً.') }}</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg hover:shadow-red-500/30">
                <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-arrow-right' : 'fa-solid fa-arrow-left' }}"></i> {{ __('تصفح باقي الأقسام') }}
            </a>
        </div>
    @endif
</div>
@endsection