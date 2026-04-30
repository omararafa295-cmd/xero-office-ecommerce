@extends('layouts.store')
@section('title', __('تأكيد البريد الإلكتروني') . ' - Xero Office')

@section('content')
<div class="max-w-md mx-auto px-4 py-20 min-h-[70vh] flex items-center justify-center">
    <div class="w-full bg-white dark:bg-gray-800 p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 text-center">
        
        <div class="w-20 h-20 bg-blue-50 dark:bg-blue-900/30 text-blue-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
            ✉️
        </div>

        <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-4">{{ __('تأكيد البريد الإلكتروني') }}</h1>
        
        <p class="text-gray-500 dark:text-gray-400 font-bold leading-relaxed mb-6">
            {{ __('شكراً لتسجيلك! قبل البدء، هل يمكنك تأكيد بريدك الإلكتروني بالضغط على الرابط الذي أرسلناه لك للتو؟ إذا لم يصلك الإيميل، سنرسل لك واحداً آخر.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 font-bold text-sm text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 p-4 rounded-xl border border-green-200 dark:border-green-800">
                ✅ {{ __('تم إرسال رابط تأكيد جديد إلى عنوان البريد الإلكتروني الذي قدمته أثناء التسجيل.') }}
            </div>
        @endif

        <div class="flex flex-col gap-4 mt-8">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition shadow-md">
                    {{ __('إرسال رابط التأكيد مرة أخرى') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-bold py-3 rounded-xl transition">
                    {{ __('تسجيل الخروج') }}
                </button>
            </form>
        </div>

    </div>
</div>
@endsection