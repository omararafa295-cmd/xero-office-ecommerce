@extends('layouts.store')
@section('title', 'إعدادات الحساب - Xero Office')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-black mb-8 text-gray-900 dark:text-white transition-colors">إعدادات الحساب </h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 p-4 rounded-xl mb-6 font-bold border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 p-4 rounded-xl mb-6 font-bold border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 text-sm font-bold border border-red-200 dark:border-red-800">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 transition-colors">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b dark:border-gray-700 pb-8">
                <div class="md:col-span-2 text-lg font-bold text-red-600 mb-2">المعلومات الشخصية</div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">الاسم</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <div class="md:col-span-2 text-lg font-bold text-red-600 mb-2">تغيير كلمة المرور (اختياري)</div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">كلمة المرور الحالية</label>
                    <input type="password" name="current_password" placeholder="اكتبها فقط إذا كنت تريد التغيير"
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">كلمة المرور الجديدة</label>
                    <input type="password" name="new_password" 
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">تأكيد الكلمة الجديدة</label>
                    <input type="password" name="new_password_confirmation"
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full md:w-1/3 bg-gray-900 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white font-bold py-4 rounded-xl transition shadow-md">
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection