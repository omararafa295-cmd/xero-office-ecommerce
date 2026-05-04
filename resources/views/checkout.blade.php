@extends('layouts.store')
@section('title', __('إتمام الطلب') . ' - Xero Office')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-black mb-8 text-gray-900 dark:text-white transition-colors">{{ __('إتمام الطلب') }} 🛒</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-gray-200">{{ __('بيانات التوصيل') }} 📍</h2>
            
            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('الاسم بالكامل (مسجل مسبقاً)') }}</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled 
                            class="w-full p-4 bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-500 cursor-not-allowed">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('رقم الهاتف') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" required placeholder="01xxxxxxxxx"
                            class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('المحافظة') }} <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="governorate" id="governorateSelect" required class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition appearance-none cursor-pointer">
                            <option value="" disabled selected>{{ __('اختر المحافظة لحساب تكلفة الشحن...') }}</option>
                            <option value="الشرقية" data-cost="40">{{ __('الشرقية') }}</option>
                            <option value="القاهرة" data-cost="50">{{ __('القاهرة') }}</option>
                            <option value="الجيزة" data-cost="50">{{ __('الجيزة') }}</option>
                            <option value="الإسكندرية" data-cost="60">{{ __('الإسكندرية') }}</option>
                            <option value="الدقهلية" data-cost="60">{{ __('الدقهلية') }}</option>
                            <option value="القليوبية" data-cost="60">{{ __('القليوبية') }}</option>
                            <option value="المنوفية" data-cost="60">{{ __('المنوفية') }}</option>
                            <option value="الغربية" data-cost="60">{{ __('الغربية') }}</option>
                            <option value="باقي المحافظات" data-cost="80">{{ __('محافظات أخرى') }}</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute top-1/2 transform -translate-y-1/2 {{ app()->getLocale() == 'ar' ? 'left-4' : 'right-4' }} text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('عنوان التوصيل بالتفصيل') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="address" required placeholder="{{ __('المدينة، الشارع، رقم العمارة والدور') }}"
                        class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('ملاحظات إضافية (اختياري)') }}</label>
                    <textarea name="notes" rows="3" placeholder="{{ __('أي ملاحظات للمندوب أو بخصوص الطلب...') }}"
                        class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition"></textarea>
                </div>

                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold text-xl py-4 rounded-xl transition shadow-lg mt-4 flex justify-center items-center gap-2">
                    ✅ {{ __('تأكيد الطلب') }}
                </button>
            </form>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 h-fit transition-colors">
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-gray-200">{{ __('ملخص الطلب') }} 🧾</h2>
            
            <div class="space-y-4 mb-6">
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity']; @endphp
                    <div class="flex justify-between items-center text-sm border-b dark:border-gray-700 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? $details['name_ar'] : ($details['name_en'] ?? $details['name_ar']) }}</span>
                            <span class="text-gray-500 dark:text-gray-400">x{{ $details['quantity'] }}</span>
                        </div>
                        <span class="font-bold text-red-600 dark:text-red-400">{{ number_format($details['price'] * $details['quantity'], 2) }} {{ __('ج.م') }}</span>
                    </div>
                @endforeach
                
                <div class="flex justify-between items-center text-sm pt-2">
                    <span class="font-bold text-gray-900 dark:text-white">{{ __('تكلفة الشحن') }}</span>
                    <span id="shippingCostDisplay" class="font-bold text-gray-500 dark:text-gray-400">{{ __('يحدد حسب المحافظة') }}</span>
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t dark:border-gray-700">
                <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('الإجمالي الكلي:') }}</span>
                <span id="totalAmountDisplay" data-subtotal="{{ $total }}" class="text-3xl font-black text-red-600">{{ number_format($total, 2) }} {{ __('ج.م') }}</span>
            </div>
            
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 p-4 rounded-xl text-sm font-bold flex items-center gap-2 border border-blue-100 dark:border-blue-800">
                <span>🚚</span> {{ __('الدفع نقداً عند الاستلام') }}
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const governorateSelect = document.getElementById('governorateSelect');
        const shippingCostDisplay = document.getElementById('shippingCostDisplay');
        const totalAmountDisplay = document.getElementById('totalAmountDisplay');
        
        const subtotal = parseFloat(totalAmountDisplay.getAttribute('data-subtotal'));

        governorateSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const shippingCost = parseFloat(selectedOption.getAttribute('data-cost') || 0);
            
            if (shippingCost > 0) {
                shippingCostDisplay.innerHTML = `<span class="text-red-600 font-black">${shippingCost.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span> {{ __('ج.م') }}`;
                const newTotal = subtotal + shippingCost;
                totalAmountDisplay.innerHTML = `${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} {{ __('ج.م') }}`;
            }
        });
    });
</script>
@endsection