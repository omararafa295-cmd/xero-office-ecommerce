<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xero Office')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // تفعيل النايت مود حسب اختيار اليوزر
        tailwind.config = { darkMode: 'class' }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">

    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-20">
            
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-2xl font-black text-red-600 flex items-center gap-2">
                    <span class="text-3xl">🖨️</span> Xero Office
                </a>
                <div class="hidden md:flex gap-6 font-bold text-gray-600 dark:text-gray-300">
                    <a href="{{ route('home') }}" class="hover:text-red-600 transition">الرئيسية</a>
                    <a href="#categories" class="hover:text-red-600 transition">الأقسام</a>
                    <a href="#about" class="hover:text-red-600 transition">من نحن</a>
                </div>
            </div>

            <div class="flex items-center gap-4 md:gap-6">
                <button onclick="toggleTheme()" class="text-2xl hover:scale-110 transition focus:outline-none" title="تغيير المظهر">
                    🌓
                </button>

                <a href="#" title="المفضلة" class="text-2xl hover:scale-110 transition">❤️</a>

                <a href="{{ route('cart.index') }}" class="relative text-2xl hover:scale-110 transition" title="سلة المشتريات">
                    🛒
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-3 inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-white bg-red-600 rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <div class="relative group">
                    <button class="flex items-center gap-2 text-gray-700 dark:text-gray-300 hover:text-red-600 font-bold focus:outline-none">
                        <span class="text-2xl">👤</span>
                        @auth <span class="hidden md:inline">{{ auth()->user()->name }}</span> @endauth
                    </button>
                    
                    <div class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
                        @guest
                            <a href="{{ route('login') }}" class="block px-4 py-3 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-600 border-b dark:border-gray-700">تسجيل الدخول</a>
                            <a href="{{ route('register') }}" class="block px-4 py-3 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-600">إنشاء حساب</a>
                        @else
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-600 border-b dark:border-gray-700">لوحة التحكم</a>
                            @else
                                <a href="{{ route('my.orders') }}" class="block px-4 py-3 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-600 border-b dark:border-gray-700">طلباتي السابقة</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-right block px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-gray-700">تسجيل الخروج</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-gray-900 dark:bg-black text-white text-center py-6 mt-10 transition-colors duration-300">
        <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} - Xero Office</p>
    </footer>
</body>
</html>