@extends('layouts.store')

@section('title', app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en)
@section('meta_description', \Illuminate\Support\Str::limit(app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en, 150))
@section('meta_image', $product->image ? asset('storage/' . $product->image) : asset('images/logo.png'))
@section('meta_type', 'product')
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
            
 <div class="flex items-center gap-3 mb-6 bg-gray-50 dark:bg-gray-800/50 w-fit px-4 py-2 rounded-full border border-gray-100 dark:border-gray-700">
    <div class="flex text-yellow-400 text-xs gap-0.5">
        @php $avgRating = round($product->averageRating()); @endphp
        @for($i = 1; $i <= 5; $i++)
            <i class="fa-{{ $i <= $avgRating ? 'solid' : 'regular' }} fa-star"></i>
        @endfor
    </div>
    <span class="text-xs font-black text-gray-500 dark:text-gray-400 pt-0.5">{{ number_format($product->averageRating(), 1) }} / 5</span>
    <span class="text-gray-300 dark:text-gray-600">|</span>
    <a href="#reviews-section" class="text-xs font-bold text-red-600 hover:underline">{{ $product->reviews->count() }} {{ __('تقييم') }}</a>
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
            <div class="mt-12 bg-gray-50 dark:bg-gray-900/50 p-8 rounded-3xl border border-gray-100 dark:border-gray-700">

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

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto flex flex-col gap-4 cart-form">
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
<!-- ========================================== -->
    <!-- بداية سكشن التقييمات-->
    <!-- ========================================== -->
    <div class="mt-20 pt-12 border-t border-gray-200 dark:border-gray-800">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- العمود الأول: فورم إضافة التقييم -->
            <div class="lg:col-span-1">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ __('أضف تقييمك') }}</h3>
                <p class="text-gray-500 font-bold mb-6 text-sm">{{ __('رأيك يهمنا ويساعد العملاء الآخرين.') }}</p>

                @auth
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-3xl border border-gray-100 dark:border-gray-700">
                        @csrf
                        
                        <!-- النجوم التفاعلية -->
                        <div class="mb-6">
                            <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-3">{{ __('تقييمك للمنتج') }}</label>
                            <div class="star-rating flex flex-row-reverse justify-end gap-1">
                                <input type="radio" id="star5" name="rating" value="5" required />
                                <label for="star5" title="5 نجوم"><i class="fa-solid fa-star"></i></label>
                                
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="4 نجوم"><i class="fa-solid fa-star"></i></label>
                                
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="3 نجوم"><i class="fa-solid fa-star"></i></label>
                                
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="نجمتين"><i class="fa-solid fa-star"></i></label>
                                
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="نجمة واحدة"><i class="fa-solid fa-star"></i></label>
                            </div>
                        </div>

                        <!-- التعليق -->
                        <div class="mb-6">
                            <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2">{{ __('تعليقك (اختياري)') }}</label>
                            <textarea name="comment" rows="4" class="w-full p-4 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-600 rounded-2xl outline-none focus:ring-2 focus:ring-red-600 transition-all text-sm font-bold resize-none" placeholder="{{ __('كيف كانت تجربتك مع هذا المنتج؟') }}"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3.5 rounded-2xl transition-all shadow-md">
                            {{ __('إرسال التقييم') }}
                        </button>
                    </form>
                @else
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-8 rounded-3xl text-center border border-dashed border-gray-300 dark:border-gray-600">
                        <div class="w-16 h-16 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class="fa-solid fa-lock text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 font-bold mb-5">{{ __('يجب تسجيل الدخول لتتمكن من إضافة تقييم') }}</p>
                        <a href="{{ route('login') }}" class="inline-block bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-8 py-3 rounded-xl font-black text-sm transition shadow-sm">{{ __('تسجيل الدخول') }}</a>
                    </div>
                @endauth
            </div>

            <!-- العمود الثاني: عرض التقييمات السابقة -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ __('مراجعات العملاء') }}</h3>
                    <span class="bg-red-50 dark:bg-red-900/30 text-red-600 font-bold px-4 py-1.5 rounded-full text-sm">
                        {{ $product->reviews->count() }} {{ __('تقييم') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($product->reviews as $review)
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm transition hover:shadow-md">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-tr from-red-600 to-red-400 text-white rounded-full flex items-center justify-center font-black text-lg shadow-sm">
                                        {{ mb_substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-gray-900 dark:text-white text-sm">{{ $review->user->name }}</h4>
                                        <p class="text-xs text-gray-400 font-bold mt-0.5">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex text-yellow-400 text-xs gap-0.5 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-lg">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-gray-600 dark:text-gray-300 text-sm font-bold leading-relaxed bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl">
                                    "{{ $review->comment }}"
                                </p>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 text-center py-16 bg-gray-50 dark:bg-gray-800/30 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
                            <i class="fa-regular fa-comments text-4xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                            <p class="text-gray-500 font-black text-lg">{{ __('لا توجد تقييمات لهذا المنتج بعد') }}</p>
                            <p class="text-gray-400 font-bold text-sm mt-2">{{ __('كن أول من يشاركنا رأيه!') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>

    <style>
        .star-rating input { display: none; }
        .star-rating label { color: #d1d5db; cursor: pointer; font-size: 1.5rem; padding: 0 0.1rem; transition: color 0.2s ease-in-out; }
        /* خدعة الـ CSS لتلوين النجوم عند تمرير الماوس أو الاختيار */
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label { color: #facc15; }
    </style>
</div>
@endsection