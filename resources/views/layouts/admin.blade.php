<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم - Xero Office')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
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
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300 flex h-screen overflow-hidden">

    <!-- الـ Sidebar الأساسي -->
    <aside class="w-64 bg-white dark:bg-gray-800 border-l border-gray-100 dark:border-gray-700 flex flex-col shadow-sm transition-colors z-20">
        <div class="h-20 flex items-center justify-center border-b border-gray-100 dark:border-gray-700">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2" dir="ltr">
                <img src="{{ asset('images/logo.png') }}" class="h-9 w-auto" alt="Logo">
                <div class="flex flex-col justify-center leading-none mt-1 text-left">
                    <span class="text-red-600 text-lg font-black tracking-tighter">XERO OFFICE</span>
                    <span class="text-gray-400 dark:text-gray-500 text-[10px] font-black tracking-[0.2em]">ADMIN</span>
                </div>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-500' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-white' }} rounded-xl font-bold transition-all">
                <i class="fa-solid fa-gauge-high w-5 text-center text-lg"></i> نظرة عامة
            </a>
            
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3.5 {{ request()->routeIs('products.*') ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-500' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-white' }} rounded-xl font-bold transition-all">
                <i class="fa-solid fa-boxes-stacked w-5 text-center text-lg"></i> المنتجات
            </a>
            
            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3.5 {{ request()->routeIs('categories.*') ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-500' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-white' }} rounded-xl font-bold transition-all">
                <i class="fa-solid fa-tags w-5 text-center text-lg"></i> الأقسام
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3.5 {{ request()->routeIs('admin.orders.*') ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-500' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-white' }} rounded-xl font-bold transition-all">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-lg"></i> الطلبات
            </a>

            <a href="{{ route('admin.customers') }}" class="flex items-center gap-3 px-4 py-3.5 {{ request()->routeIs('admin.customers') ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-500' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-white' }} rounded-xl font-bold transition-all">
                <i class="fa-solid fa-users w-5 text-center text-lg"></i> العملاء
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100 dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-3.5 text-gray-500 font-bold hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 rounded-xl transition-all">
                    <i class="fa-solid fa-power-off"></i> تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>

    <!-- المحتوى الرئيسي + الهيدر العلوي -->
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-50 dark:bg-gray-900/50 transition-colors relative">
        <header class="h-20 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-8 z-50 transition-colors">
            <h2 class="text-xl font-black text-gray-800 dark:text-white">@yield('title', 'لوحة التحكم')</h2>
            
            <div class="flex items-center gap-4">
                
                <!-- ============================================== -->
                <!-- جرس إشعارات نواقص المخزون -->
                <!-- ============================================== -->
                @php
                    // بنجيب المنتجات اللي الـ stock بتاعها أقل من 5
                    $lowStockProducts = \App\Models\Product::where('stock', '<', 5)->take(5)->get();
                    $lowStockCount = \App\Models\Product::where('stock', '<', 5)->count();
                @endphp

                <div class="relative group flex items-center h-full">
                    <a href="{{ route('admin.products.low_stock') }}" class="relative p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition cursor-pointer">
                        <i class="fa-solid fa-bell text-xl"></i>
                        
                        <!-- البادج الأحمر هيظهر بس لو فيه منتجات ناقصة -->
                        @if($lowStockCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-black leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 border-2 border-white dark:border-gray-800 rounded-full animate-bounce">
                                {{ $lowStockCount }}
                            </span>
                        @endif
                    </a>

                    <!-- دروب داون الإشعارات (بتظهر لما تعمل Hover) -->
                    @if($lowStockCount > 0)
                    <div class="absolute left-0 top-full mt-2 w-80 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
                        
                        <!-- رأس القائمة -->
                        <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex justify-between items-center">
                            <h4 class="font-black text-gray-900 dark:text-white text-sm flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation text-red-500"></i> تنبيهات المخزون
                            </h4>
                            <span class="bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-bold px-2 py-1 rounded-lg">{{ $lowStockCount }} منتج</span>
                        </div>
                        
                        <!-- المنتجات الناقصة -->
                        <div class="max-h-64 overflow-y-auto">
                            @foreach($lowStockProducts as $product)
                            <a href="{{ route('admin.products.low_stock') }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 flex items-center justify-center flex-shrink-0 shadow-inner">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200 line-clamp-1">{{ $product->name_ar }}</p>
                                    <p class="text-xs font-black text-red-600 mt-1">متبقي {{ $product->stock }} قطع فقط!</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        
                        <!-- زرار عرض كل النواقص -->
                        <a href="{{ route('admin.products.low_stock') }}" class="block p-3 text-center text-sm font-black text-blue-600 hover:bg-blue-50 dark:hover:bg-gray-700/50 transition bg-white dark:bg-gray-800">
                            عرض كل النواقص <i class="fa-solid fa-arrow-left ml-1 text-xs"></i>
                        </a>
                    </div>
                    @endif
                </div>
                <!-- ============================================== -->

                <!-- زرار الوضع الليلي -->
                <button onclick="toggleTheme()" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                    <i class="fa-solid fa-moon dark:hidden"></i>
                    <i class="fa-solid fa-sun hidden dark:inline"></i>
                </button>

                <!-- بروفايل المستخدم -->
                <div class="flex items-center gap-3 bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600">
                    <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span class="font-bold text-sm text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</span>
                </div>

            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8 z-0">
            @yield('content')
        </main>
    </div>
</body>
</html>