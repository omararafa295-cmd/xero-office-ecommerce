@extends('layouts.store')
@section('title', __('تعيين كلمة مرور جديدة') . ' - Xero Office')

@section('content')
<div class="max-w-md mx-auto px-4 py-20 min-h-[70vh] flex items-center justify-center">
    <div class="w-full bg-white dark:bg-gray-800 p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">{{ __('تعيين كلمة مرور جديدة') }} 🔄</h1>
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

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('البريد الإلكتروني') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus 
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-left" dir="ltr">
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
                {{ __('تحديث كلمة المرور') }}
            </button>
        </form>
    </div>
</div>
@endsection