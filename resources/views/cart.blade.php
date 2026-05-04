@extends('layouts.store')
@section('title', __('سلة المشتريات') . ' - Xero Office')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-xl flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-cart-shopping text-2xl"></i>
        </div>
        <h1 class="text-3xl font-black text-gray-900 dark:text-white">{{ __('سلة المشتريات') }}</h1>
    </div>

    @if(count($cartItems) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="p-5 font-bold">{{ __('المنتج') }}</th>
                            <th class="p-5 font-bold">{{ __('السعر') }}</th>
                            <th class="p-5 font-bold text-center">{{ __('الكمية') }}</th>
                            <th class="p-5 font-bold">{{ __('الإجمالي') }}</th>
                            <th class="p-5 font-bold text-center">{{ __('حذف') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700 dark:text-white"> {{-- $total is passed from controller --}}
                        @foreach($cartItems as $item)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="p-5 font-black text-gray-900 dark:text-white">
                                    {{ app()->getLocale() == 'ar' ? $item->product->name_ar : ($item->product->name_en ?? $item->product->name_ar) }}
                                </td>
                                <td class="p-5 font-bold text-gray-600 dark:text-gray-300">{{ number_format($item->price, 2) }} {{ __('ج.م') }}</td>
                                <td class="p-5 text-center font-black">{{ $item->quantity }}</td>
                                <td class="p-5 text-red-600 font-black">{{ number_format($item->price * $item->quantity, 2) }} {{ __('ج.م') }}</td>
                                <td class="p-5 text-center">
                                    <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-all p-3 rounded-xl hover:bg-red-50 dark:hover:bg-gray-700" title="{{ __('حذف من السلة') }}">
                                            <i class="fa-regular fa-trash-can text-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 md:p-8 bg-gray-50 dark:bg-gray-900/50 flex flex-col sm:flex-row justify-between items-center gap-6 border-t border-gray-100 dark:border-gray-700">
                <div class="text-lg text-gray-700 dark:text-gray-300 font-bold flex items-center gap-3">
                    {{ __('الإجمالي الكلي:') }} <span class="font-black text-red-600 text-3xl mx-2">{{ number_format($total, 2) }} <span class="text-sm text-gray-500">{{ __('ج.م') }}</span></span>
                </div>
                <a href="{{ route('checkout.index') }}" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-10 py-4 rounded-xl font-black text-lg shadow-[0_8px_20px_rgba(34,197,94,0.3)] hover:-translate-y-1 transition-all text-center flex items-center justify-center gap-3">
                    <i class="fa-solid fa-credit-card"></i> {{ __('إتمام الشراء') }}
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center">
            <div class="w-28 h-28 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-6 text-gray-300 dark:text-gray-600">
                <i class="fa-solid fa-cart-arrow-down text-6xl"></i>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white mb-3">{{ __('سلتك فارغة حالياً') }}</p>
            <p class="text-gray-500 font-bold mb-8 text-lg">{{ __('لم تقم بإضافة أي منتجات إلى سلة المشتريات حتى الآن.') }}</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-lg hover:shadow-red-500/30 hover:-translate-y-1">
                <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-arrow-right' : 'fa-solid fa-arrow-left' }}"></i> {{ __('تصفح المنتجات') }}
            </a>
        </div>
    @endif
</div>
@endsection