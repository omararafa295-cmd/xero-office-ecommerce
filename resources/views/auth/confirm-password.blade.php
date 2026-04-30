@extends('layouts.store')
@section('title', __('تأكيد كلمة المرور') . ' - Xero Office')

@section('content')
<div class="max-w-md mx-auto px-4 py-20 min-h-[70vh] flex items-center justify-center">
    <div class="w-full bg-white dark:bg-gray-800 p-8 md:p-10 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 text-center">
        
        <div class="w-20 h-20 bg-yellow-50 dark:bg-yellow-900/30 text-yellow-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
            🔒
        </div>

        <p class="text-gray-500 dark:text-gray-400 font-bold leading-relaxed mb-8">
            {{ __('هذه منطقة آمنة. يرجى تأكيد كلمة المرور الخاصة بك قبل المتابعة.') }}
        </p>

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 text-sm font-bold border border-red-200 dark:border-red-800 text-right">
                <ul>
                    @foreach ($errors->get('password') as $error)
                        <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}" class="text-right space-y-6">
            @csrf
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('كلمة المرور') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 dark:text-white outline-none transition text-left" dir="ltr" 
                    placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl transition shadow-md">
                {{ __('تأكيد') }}
            </button>
        </form>
    </div>
</div>
@endsection