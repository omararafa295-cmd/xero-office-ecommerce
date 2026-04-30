@extends('layouts.store')
@section('title', __('إنشاء حساب') . ' - Xero Office')

@section('content')
<div class="max-w-md mx-auto px-4 py-20 min-h-[70vh] flex items-center justify-center">
    <div class="w-full bg-white dark:bg-gray-800 p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">{{ __('حساب جديد') }} </h1>
            <p class="text-gray-500 dark:text-gray-400">{{ __('انضم إلينا واستمتع بتجربة تسوق مميزة') }}</p>
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

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('الاسم بالكامل') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition" 
                    placeholder="{{ __('مثال: أحمد محمد') }}">
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('البريد الإلكتروني') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-left" dir="ltr" 
                    placeholder="example@email.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('كلمة المرور') }}</label>
                <input id="password" type="password" name="password" required 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-left" dir="ltr" 
                    placeholder="••••••••">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('تأكيد كلمة المرور') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-left" dir="ltr" 
                    placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-gray-900 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white font-bold text-lg py-4 rounded-xl transition shadow-md mt-4">
                {{ __('إنشاء حساب') }}
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
            {{ __('لديك حساب بالفعل؟') }} 
            <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 transition">{{ __('تسجيل الدخول') }}</a>
        </p>
    </div>
</div>
@endsection