@extends('layouts.store')
@section('title', __('إتمام الطلب') . ' - Xero Office')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-black mb-8 text-gray-900 dark:text-white transition-colors">{{ __('إتمام الطلب') }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ __('بيانات التوصيل') }}</h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('أدخل بيانات الشحن واختر وسيلة الدفع المناسبة لإتمام طلبك.') }}</p>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                @csrf

                @if(session('error'))
                    <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 dark:border-red-900/40 dark:bg-red-900/20 dark:text-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('الاسم بالكامل') }}</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled class="w-full p-4 bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('رقم الهاتف') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="01xxxxxxxxx" class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('المحافظة') }} <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="governorate" id="governorateSelect" required class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition appearance-none cursor-pointer">
                            <option value="" disabled {{ old('governorate') ? '' : 'selected' }}>{{ __('اختر المحافظة لحساب تكلفة الشحن') }}</option>
                            @foreach($governorates as $gov)
                                <option value="{{ $gov->id }}" data-cost="{{ $gov->shipping_cost }}" {{ old('governorate') == $gov->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() == 'ar' ? $gov->name_ar : $gov->name_en }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute top-1/2 -translate-y-1/2 {{ app()->getLocale() == 'ar' ? 'left-4' : 'right-4' }} text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('عنوان التوصيل بالتفصيل') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="address" value="{{ old('address') }}" required placeholder="{{ __('المدينة، الشارع، رقم العمارة والدور') }}" class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">{{ __('طريقة الدفع') }} <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 gap-4 {{ $paymobCardEnabled && $paymobWalletEnabled ? 'md:grid-cols-3' : 'md:grid-cols-2' }}">
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="peer sr-only" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                            <div class="h-full rounded-2xl border border-gray-200 bg-gray-50 p-4 transition-all peer-checked:border-green-500 peer-checked:bg-green-50 dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:border-green-400 dark:peer-checked:bg-green-900/20">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fa-solid fa-money-bill-wave text-green-600"></i>
                                    <span class="font-black text-gray-900 dark:text-white">{{ __('الدفع عند الاستلام') }}</span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('ادفع قيمة الطلب عند وصوله إليك.') }}</p>
                            </div>
                        </label>

                        @if($paymobCardEnabled)
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="card" class="peer sr-only" {{ old('payment_method') === 'card' ? 'checked' : '' }}>
                                <div class="h-full rounded-2xl border border-gray-200 bg-gray-50 p-4 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:border-blue-400 dark:peer-checked:bg-blue-900/20">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fa-regular fa-credit-card text-blue-600"></i>
                                        <span class="font-black text-gray-900 dark:text-white">{{ __('بطاقة بنكية') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('دفع إلكتروني آمن باستخدام بطاقتك.') }}</p>
                                </div>
                            </label>
                        @endif

                        @if($paymobWalletEnabled)
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="wallet" class="peer sr-only" {{ old('payment_method') === 'wallet' ? 'checked' : '' }}>
                                <div class="h-full rounded-2xl border border-gray-200 bg-gray-50 p-4 transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:border-purple-400 dark:peer-checked:bg-purple-900/20">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fa-solid fa-mobile-screen-button text-purple-600"></i>
                                        <span class="font-black text-gray-900 dark:text-white">{{ __('محفظة إلكترونية') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('استخدم رقم محفظتك لإتمام الدفع الإلكتروني.') }}</p>
                                </div>
                            </label>
                        @endif
                    </div>
                </div>

                <div id="cardPreviewSection" class="{{ old('payment_method') === 'card' && $paymobCardEnabled ? '' : 'hidden' }}">
                    <div class="rounded-[2rem] border border-blue-100 bg-gradient-to-br from-slate-950 via-blue-950 to-cyan-800 p-6 text-white shadow-[0_20px_60px_rgba(15,23,42,0.25)]">
                        <div class="flex items-start justify-between mb-8">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-white/60 mb-2">{{ __('معاينة البطاقة') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black">VISA</p>
                                <p class="text-[10px] tracking-[0.35em] text-white/60">SECURE</p>
                            </div>
                        </div>

                        <div class="relative h-56 perspective-[1200px]">
                            <div id="cardPreviewInner" class="relative h-full w-full transition-transform duration-500 [transform-style:preserve-3d]">
                                <div class="absolute inset-0 rounded-[1.75rem] border border-white/15 bg-white/10 p-5 backdrop-blur-md [backface-visibility:hidden]">
                                    <div class="w-14 h-10 rounded-xl bg-gradient-to-br from-amber-200 to-yellow-500 mb-6"></div>
                                    <div id="cardPreviewNumber" class="text-2xl md:text-3xl font-black tracking-[0.18em] mb-5">•••• •••• •••• ••••</div>
                                    <div class="flex items-end justify-between gap-4">
                                        <div>
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-white/60 mb-1">{{ __('اسم حامل البطاقة') }}</p>
                                            <p id="cardPreviewName" class="font-black text-lg uppercase">YOUR NAME</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-white/60 mb-1">{{ __('تاريخ الانتهاء') }}</p>
                                            <p id="cardPreviewExpiry" class="font-black text-lg">MM/YY</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="absolute inset-0 rounded-[1.75rem] border border-white/15 bg-slate-950 p-5 [transform:rotateY(180deg)] [backface-visibility:hidden]">
                                    <div class="h-12 bg-black rounded-lg mt-4"></div>
                                    <div class="bg-white/90 rounded-lg mt-6 p-3 text-right text-slate-900">
                                        <p class="text-[10px] tracking-[0.25em] text-slate-500 mb-1">{{ __('رمز الأمان') }}</p>
                                        <p id="cardPreviewCvv" class="font-black text-xl tracking-[0.35em]">•••</p>
                                    </div>
                                    <p class="text-xs text-white/50 mt-6 leading-6">
                                        {{ __('هذه المعاينة مخصصة فقط لمساعدتك في مراجعة بيانات البطاقة بصريًا.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-black text-white/70 mb-2">{{ __('رقم البطاقة') }}</label>
                                <input type="text" id="cardUiNumber" inputmode="numeric" maxlength="19" placeholder="4242 4242 4242 4242" class="w-full rounded-2xl border border-white/15 bg-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:border-cyan-300">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-white/70 mb-2">{{ __('اسم حامل البطاقة') }}</label>
                                <input type="text" id="cardUiName" maxlength="24" placeholder="YOUR NAME" class="w-full rounded-2xl border border-white/15 bg-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:border-cyan-300">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-white/70 mb-2">MM/YY</label>
                                    <input type="text" id="cardUiExpiry" maxlength="5" placeholder="12/28" class="w-full rounded-2xl border border-white/15 bg-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:border-cyan-300">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-white/70 mb-2">CVV</label>
                                    <input type="text" id="cardUiCvv" inputmode="numeric" maxlength="4" placeholder="123" class="w-full rounded-2xl border border-white/15 bg-white/10 px-4 py-3 text-white placeholder:text-white/40 outline-none focus:border-cyan-300">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="walletNumberWrapper" class="{{ old('payment_method') === 'wallet' && $paymobWalletEnabled ? '' : 'hidden' }}">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('رقم المحفظة') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="wallet_number" id="walletNumberInput" value="{{ old('wallet_number') }}" placeholder="01xxxxxxxxx" class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition">
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('تأكد من إدخال الرقم المرتبط بالمحفظة المراد الدفع من خلالها.') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('ملاحظات إضافية') }} <span class="text-xs text-gray-400">{{ __('اختياري') }}</span></label>
                    <textarea name="notes" rows="3" placeholder="{{ __('أي ملاحظات للمندوب أو بخصوص الطلب') }}" class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold text-lg py-4 rounded-xl transition shadow-lg mt-4 flex justify-center items-center gap-2">
                    {{ __('تأكيد الطلب') }}
                </button>
            </form>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 h-fit transition-colors">
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-gray-200">{{ __('ملخص الطلب') }}</h2>

            <div class="mb-6 border-b dark:border-gray-700 pb-6">
                @if(session()->has('coupon'))
                    <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 p-4 rounded-xl flex justify-between items-center mb-2">
                        <div>
                            <span class="text-green-800 dark:text-green-400 font-bold text-sm">{{ __('كوبون مطبق:') }} {{ session('coupon')['code'] }}</span>
                        </div>
                        <a href="{{ route('coupon.remove') }}" class="text-red-500 hover:text-red-700 text-sm font-bold">{{ __('إزالة') }}</a>
                    </div>
                @else
                    <form action="{{ route('coupon.apply') }}" method="POST" class="flex gap-2 mb-2">
                        @csrf
                        <input type="text" name="coupon_code" placeholder="{{ __('أدخل كود الخصم') }}" required class="flex-1 p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-sm">
                        <button type="submit" class="bg-gray-900 dark:bg-gray-600 hover:bg-black text-white px-4 rounded-xl font-bold transition text-sm shadow-sm">
                            {{ __('تطبيق') }}
                        </button>
                    </form>
                @endif
            </div>

            <div class="space-y-4 mb-6">
                @foreach($cartItems as $item)
                    <div class="flex justify-between items-center text-sm border-b dark:border-gray-700 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? $item->product->name_ar : ($item->product->name_en ?? $item->product->name_ar) }}</span>
                            <span class="text-gray-500 dark:text-gray-400">x{{ $item->quantity }}</span>
                        </div>
                        <span class="font-bold text-red-600 dark:text-red-400">{{ number_format($item->price * $item->quantity, 2) }} {{ __('ج.م') }}</span>
                    </div>
                @endforeach

                <div class="flex justify-between items-center text-sm pt-2">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('تكلفة الشحن') }}</span>
                    <span id="shippingCostDisplay" class="font-bold text-gray-500 dark:text-gray-400">{{ __('يحدد حسب المحافظة') }}</span>
                </div>

                @if(isset($discount) && $discount > 0)
                    <div class="flex justify-between items-center text-sm pt-2 text-green-600">
                        <span class="font-bold">{{ __('الخصم') }}</span>
                        <span class="font-bold">-{{ number_format($discount, 2) }} {{ __('ج.م') }}</span>
                    </div>
                @endif
            </div>

            <div class="flex justify-between items-center pt-4 border-t dark:border-gray-700">
                <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('الإجمالي') }}</span>
                <span id="totalAmountDisplay" data-subtotal="{{ $total }}" data-discount="{{ $discount ?? 0 }}" class="text-3xl font-black text-red-600">{{ number_format(max(0, $total - ($discount ?? 0)), 2) }} {{ __('ج.م') }}</span>
            </div>

            <div id="paymentMethodHint" class="mt-6 bg-slate-50 dark:bg-slate-900/30 text-slate-700 dark:text-slate-300 p-4 rounded-xl text-sm flex items-center gap-2 border border-slate-200 dark:border-slate-800">
                <span class="text-base">•</span> {{ __('راجع بياناتك بعناية قبل إتمام الطلب.') }}
            </div>
        </div>
    </div>
</div>

<script>
    window.checkoutMessages = {
        cash: '{{ __('سيتم سداد قيمة الطلب عند الاستلام.') }}',
        card: '{{ __('سيتم استكمال الدفع الإلكتروني بشكل آمن بعد تأكيد الطلب.') }}',
        wallet: '{{ __('سيتم إرسال طلب الدفع إلى محفظتك بعد تأكيد الطلب.') }}',
        shippingDefault: '{{ __('يحدد حسب المحافظة') }}',
        currency: '{{ __('ج.م') }}',
    };
</script>
@vite(['resources/js/checkout.js'])
@endsection
