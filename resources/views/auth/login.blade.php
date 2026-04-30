@extends('layouts.store')
@section('title', __('تسجيل الدخول') . ' - Xero Office')

@section('content')
<div class="max-w-md mx-auto px-4 py-20 min-h-[70vh] flex items-center justify-center">
    <div class="w-full bg-white dark:bg-gray-800 p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">{{ __('مرحباً بعودتك!') }} </h1>
            <p class="text-gray-500 dark:text-gray-400">{{ __('سجل دخولك لمتابعة طلباتك') }}</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 text-sm font-bold border border-red-200 dark:border-red-800">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('البريد الإلكتروني') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-left" dir="ltr" 
                    placeholder="example@email.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('كلمة المرور') }}</label>
                <input id="password" type="password" name="password" required 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-left" dir="ltr" 
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-sm font-bold">
                <label class="flex items-center gap-2 cursor-pointer text-gray-600 dark:text-gray-400">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    {{ __('تذكرني') }}
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-red-600 hover:text-red-700 transition">{{ __('نسيت كلمة المرور؟') }}</a>
                @endif
            </div>

            <button type="submit" class="w-full bg-gray-900 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white font-bold text-lg py-4 rounded-xl transition shadow-md">
                {{ __('تسجيل الدخول') }}
            </button>
            <div class="relative my-6">
    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200 dark:border-gray-700"></div></div>
    <div class="relative flex justify-center text-sm"><span class="px-2 bg-white dark:bg-gray-800 text-gray-500">{{ __('أو') }}</span></div>
</div>

<a href="{{ route('google.login') }}" class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-white font-bold text-lg py-3.5 rounded-xl flex items-center justify-center gap-3 hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-sm">
    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-6 h-6" alt="Google">
    {{ __('تسجيل الدخول بواسطة جوجل') }}
</a>
        </form>

        <p class="mt-8 text-center text-gray-600 dark:text-gray-400 font-bold">
            {{ __('ليس لديك حساب؟') }} 
            <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 transition">{{ __('إنشاء حساب جديد') }}</a>
        </p>
    </div>
</div>
@endsection