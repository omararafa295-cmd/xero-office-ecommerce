<!DOCTYPE html>
@php
    // قراءة اللغة من الجلسة التي يحددها LanguageController
    $locale = session('locale', 'ar');
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
@endphp
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Xero Office') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,600,700|figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-xero-dark text-gray-900 dark:text-white transition-colors duration-300 font-sans">
    
    <!-- استدعاء النافبار المخصص -->
    @include('components.navbar')

    <!-- محتوى الصفحة -->
    <main class="pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
        @yield('content')
    </main>
</body>
</html>