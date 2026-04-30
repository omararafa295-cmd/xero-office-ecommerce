@extends('layouts.store')
@section('title', __('استعادة كلمة المرور') . ' - Xero Office')

@section('content')
<div class="max-w-md mx-auto px-4 py-20 min-h-[70vh] flex items-center justify-center">
    <div class="w-full bg-white dark:bg-gray-800 p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-4">{{ __('نسيت كلمة المرور؟') }} 🔐</h1>
            <p class="text-gray-500 dark:text-gray-400 leading-relaxed font-bold">
                {{ __('ولا يهمك! اكتب البريد الإلكتروني اللي سجلت بيه، وهنبعتلك رابط تقدر من خلاله تعمل كلمة مرور جديدة.') }}
            </p>
        </div>

        @if (session('status'))
            <div class="mb-6 font-bold text-sm text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 p-4 rounded-xl border border-green-200 dark:border-green-800">
                ✅ {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 text-sm font-bold border border-red-200 dark:border-red-800">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('البريد الإلكتروني') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-left" dir="ltr" 
                    placeholder="example@email.com">
            </div>

            <button type="submit" class="w-full bg-gray-900 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white font-bold text-lg py-4 rounded-xl transition shadow-md">
                {{ __('إرسال رابط الاستعادة') }}
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 font-bold transition flex items-center justify-center gap-2">
                <i class="{{ app()->getLocale() == 'ar' ? 'fa-solid fa-arrow-right' : 'fa-solid fa-arrow-left' }}"></i> {{ __('العودة لتسجيل الدخول') }}
            </a>
        </div>

    </div>
</div>
@endsection