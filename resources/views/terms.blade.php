@extends('layouts.store')
@section('title', __('الشروط والأحكام') . ' - Xero Office')

@section('content')

<div class="relative py-24 text-center overflow-hidden" style="background: linear-gradient(to right, #2d3748, #1a202c);">
    <div class="absolute -right-20 -top-20 w-80 h-80 bg-red-600/10 rounded-full blur-[80px]"></div>
    <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-blue-600/10 rounded-full blur-[80px]"></div>
    
    <div class="relative z-10">
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4">{{ __('الشروط والأحكام') }}</h1>
        <p class="text-gray-200 font-bold text-lg max-w-2xl mx-auto">{{ __('تعرف على سياسات الضمان، الشحن، والاسترجاع الخاصة بمتجر Xero Office لضمان تجربة تسوق آمنة ومريحة.') }}</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-16">
    
    <div class="grid grid-cols-1 gap-12">
        
        <div class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-lg transition-shadow">
            <div class="absolute top-0 right-0 w-2 h-full bg-red-500"></div>
            
            <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/30 text-red-600 flex items-center justify-center">
                    <i class="fa-solid fa-shield-halved text-2xl"></i>
                </div>
                {{ __('سياسة الضمان (الجديد والمستعمل)') }}
            </h2>
            
            <ul class="space-y-4 text-gray-600 dark:text-gray-300 font-bold leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                    <span>{{ __('ضمان الطابعات وماكينات التصوير الجديدة عام كامل من تاريخ الشراء.') }}</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                    <span>{{ __('ضمان الأحبار عام كامل، في حالة لم تفتح بشرط سلامة العبوة والتخزين الجيد، أو أسبوع من الاستخدام في حالة ظهور عيوب في الطباعة.') }}</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                    <span>{{ __('ضمان قطع الغيار الجديدة الاستلام والمعاينة قبل التركيب، ويمكن استبدالها في حالة كانت غير متوافقة أو بها تلفيات بسبب الشحن.') }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-lg transition-shadow">
            <div class="absolute top-0 right-0 w-2 h-full bg-blue-500"></div>
            
            <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-truck-fast text-2xl"></i>
                </div>
                {{ __('سياسة الشحن والتوصيل') }}
            </h2>
            
            <ul class="space-y-4 text-gray-600 dark:text-gray-300 font-bold leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-blue-500 mt-1.5"></i>
                    <span>{{ __('يتم شحن الطلبات وتوصيلها خلال 3 إلى 5 أيام عمل لجميع المحافظات.') }}</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-blue-500 mt-1.5"></i>
                    <span>{{ __('تكلفة الشحن يتم حسابها تلقائياً عند إتمام الطلب بناءً على الوزن والمنطقة الجغرافية.') }}</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-blue-500 mt-1.5"></i>
                    <span>{{ __('يرجى فحص المنتج جيداً أمام المندوب قبل الاستلام للتأكد من سلامته وعدم تعرضه للكسر أو التلف.') }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-lg transition-shadow">
            <div class="absolute top-0 right-0 w-2 h-full bg-yellow-500"></div>
            
            <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 flex items-center justify-center">
                    <i class="fa-solid fa-rotate-left text-2xl"></i>
                </div>
                {{ __('سياسة الاستبدال والاسترجاع') }}
            </h2>
            
            <ul class="space-y-4 text-gray-600 dark:text-gray-300 font-bold leading-relaxed list-none">
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-yellow-500 mt-1.5"></i>
                    <span>{{ __('يحق للعميل استبدال أو إرجاع المنتج خلال 14 يوماً من تاريخ الاستلام، بشرط أن يكون في حالته الأصلية ولم يتم فتحه أو استخدامه.') }}</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-yellow-500 mt-1.5"></i>
                    <span>{{ __('في حالة وجود عيب صناعة، يتم استبدال المنتج مجاناً وبدون أي مصاريف شحن إضافية بعد فحصه من قبل الدعم الفني.') }}</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-check text-yellow-500 mt-1.5"></i>
                    <span>{{ __('لا يمكن استرجاع الأحبار المفتوحة أو قطع الغيار التي تم تركيبها بطريقة خاطئة.') }}</span>
                </li>
            </ul>
        </div>

    </div>
</div>
@endsection