@extends('layouts.store')
@section('title', __('نتائج البحث عن:') . ' ' . $query)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-black mb-8 dark:text-white">
        {{ __('نتائج البحث عن:') }} <span class="text-red-600">"{{ $query }}"</span>
    </h1>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-lg transition-shadow overflow-hidden border border-gray-100 dark:border-gray-700 relative flex flex-col h-full">
                    
                    <div class="absolute top-3 right-3 z-10">
                        <form action="{{ route('products.favorite', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 bg-white/90 dark:bg-gray-900/80 backdrop-blur-sm rounded-full shadow hover:scale-110 transition">
                                @if(auth()->check() && auth()->user()->favorites->contains('product_id', $product->id)) ❤️ @else 🤍 @endif
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('product.show', $product->id) }}" class="flex flex-col flex-grow group block cursor-pointer">
                        <div class="h-56 w-full bg-gray-100 dark:bg-gray-700 flex-shrink-0 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500 text-sm">{{ __('لا توجد صورة') }}</div>
                            @endif
                        </div>
                        
                        <div class="p-5 pb-0 flex-grow">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-red-600 transition-colors" title="{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}">
                                {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                            </h3>
                        </div>
                    </a>
                    
                    <div class="p-5 pt-4 mt-auto">
                        <p class="text-red-600 font-black text-2xl mb-4">{{ number_format($product->price, 2) }} <span class="text-sm text-gray-500">{{ __('ج.م') }}</span></p>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-gray-900 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition flex justify-center items-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i> {{ __('أضف للسلة') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <span class="text-6xl block mb-4">🔍</span>
            <p class="text-2xl font-bold text-gray-500 dark:text-gray-400">{{ __('للأسف، لم نجد نتائج تطابق بحثك.') }}</p>
            <a href="{{ route('home') }}" class="inline-block mt-6 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-md">{{ __('العودة للرئيسية') }}</a>
        </div>
    @endif
</div>
@endsection