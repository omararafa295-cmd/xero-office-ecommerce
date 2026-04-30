<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xero Office')</title>
    
    <meta name="description" content="@yield('meta_description', __('الوجهة الأولى لحلول الطباعة المتكاملة والأدوات المكتبية. نقدم أحدث التقنيات وأفضل خدمات الصيانة.'))">
    <meta name="keywords" content="طابعات, أحبار, صيانة طابعات, Xero Office, أدوات مكتبية, Xerox, HP, Canon">
    <meta name="author" content="Xero Office">

    <meta property="og:type" content="@yield('meta_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Xero Office')">
    <meta property="og:description" content="@yield('meta_description', __('الوجهة الأولى لحلول الطباعة المتكاملة والأدوات المكتبية.'))">
    <meta property="og:image" content="@yield('meta_image', asset('images/logo.png'))">
    <meta property="og:site_name" content="Xero Office">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Xero Office')">
    <meta name="twitter:description" content="@yield('meta_description', __('الوجهة الأولى لحلول الطباعة المتكاملة والأدوات المكتبية.'))">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/logo.png'))">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
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
        #about, #categories { scroll-margin-top: 100px; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300 flex flex-col min-h-screen relative z-0 overflow-x-hidden">

    <div class="fixed inset-0 z-[-1] flex items-center justify-center opacity-[0.05] dark:opacity-[0.02] pointer-events-none">
        <img src="{{ asset('images/logo.png') }}" alt="Xero" class="w-1/2 max-w-2xl grayscale">
    </div>

    <nav class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50 transition-colors">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-24">
            
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-1.5" dir="ltr">
                    <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto" alt="Logo">
                    <div class="flex flex-col justify-center leading-none text-left">
                        <span class="text-red-600 text-3xl font-black tracking-tighter">XERO</span>
                        <span class="text-gray-900 dark:text-white text-xs font-black tracking-[0.25em] mt-1">OFFICE</span>
                    </div>
                </a>
                
                <div class="hidden md:flex gap-6 font-bold text-gray-600 dark:text-gray-300">
                    <a href="{{ route('home') }}" class="hover:text-red-600 transition flex items-center gap-1.5"><i class="fa-solid fa-house text-sm"></i> {{ __('الرئيسية') }}</a>
                    <div class="relative group">
                        <a href="{{ route('home') }}#categories" class="hover:text-red-600 transition flex items-center gap-1.5 py-4 cursor-pointer">
                            <i class="fa-solid fa-layer-group text-sm"></i> {{ __('الأقسام') }} 
                            <i class="fa-solid fa-chevron-down text-[10px] mr-1 opacity-60 group-hover:rotate-180 transition-transform duration-300"></i>
                        </a>
                        
                        <div class="absolute right-0 top-14 w-56 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden z-50 transform origin-top scale-95 group-hover:scale-100">
                            @php
                                $nav_categories = \App\Models\Category::all();
                            @endphp
                            
                            @if($nav_categories->count() > 0)
                                <div class="py-2">
                                    @foreach($nav_categories as $nav_cat)
                                        <a href="{{ route('category.show', $nav_cat->name_en) }}" class="flex items-center gap-3 px-4 py-3 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors border-b border-gray-50 dark:border-gray-700/50 last:border-0 group/item">
                                            <i class="fa-solid fa-angle-left text-[10px] text-gray-400 group-hover/item:text-red-600 transition-colors"></i>
                                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300 group-hover/item:text-red-600">
                                                {{ app()->getLocale() == 'ar' ? $nav_cat->name_ar : $nav_cat->name_en }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-4 py-4 text-sm text-center text-gray-500 font-bold">{{ __('لا توجد أقسام حالياً') }}</div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('home') }}#about" class="hover:text-red-600 transition flex items-center gap-1.5"><i class="fa-solid fa-circle-info text-sm"></i> {{ __('من نحن') }}</a>
                    <a href="{{ route('terms') }}" class="hover:text-red-600 transition flex items-center gap-1.5"><i class="fa-solid fa-file-contract text-sm"></i> {{ __('الشروط والأحكام') }}</a>
                </div>
            </div>

            <div class="flex items-center gap-5">
                <form action="{{ route('search') }}" method="GET" class="hidden lg:flex items-center relative group w-64 z-50">
                    <input type="text" id="searchInput" name="query" autocomplete="off" placeholder="{{ __('ابحث عن طابعة، حبر...') }}" class="bg-gray-100 dark:bg-gray-700 border-none rounded-xl py-2 px-4 pr-10 w-full focus:ring-2 focus:ring-red-600 transition-all outline-none dark:text-white text-sm relative z-20">
                    <button type="submit" class="absolute right-4 text-gray-400 group-hover:text-red-600 transition-colors z-20">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    
                    <div id="searchSuggestions" class="absolute top-full mt-2 w-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-2xl hidden overflow-hidden z-50 max-h-80 overflow-y-auto">
                    </div>
                </form>
                
                <button onclick="toggleTheme()" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors text-xl">
                    <i class="fa-solid fa-moon dark:hidden"></i>
                    <i class="fa-solid fa-sun hidden dark:inline"></i>
                </button>

                <a href="{{ route('favorites.index') ?? '#' }}" class="relative text-gray-400 hover:text-red-600 transition-colors text-xl">
                    <i class="fa-solid fa-heart"></i>
                    @auth
                        @php $favCount = \App\Models\Favorite::where('user_id', auth()->id())->count(); @endphp
                        @if($favCount > 0)
                            <span class="absolute -top-2 -right-3 bg-red-600 text-white text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full shadow-sm">{{ $favCount }}</span>
                        @endif
                    @endauth
                </a>
                 <a href="{{ route('cart.index') }}" class="relative text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors text-xl ml-1">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-3 bg-gray-900 dark:bg-gray-600 text-white text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full shadow-sm">{{ count(session('cart')) }}</span>
                    @endif
                </a>
                <div class="flex items-center justify-center border-l border-gray-200 dark:border-gray-700 pl-3 ml-1">
                    @if(app()->getLocale() == 'ar')
                        <a href="{{ route('lang.switch', 'en') }}" class="font-black text-gray-500 hover:text-red-600 dark:text-gray-400 transition text-lg mt-1" title="English">
                            EN
                        </a>
                    @else
                        <a href="{{ route('lang.switch', 'ar') }}" class="font-black text-gray-500 hover:text-red-600 dark:text-gray-400 transition text-xl" title="عربي">
                            ع
                        </a>
                    @endif
                </div>

               

                <div class="relative group">
                    <button class="flex items-center gap-2 font-bold text-gray-700 dark:text-gray-200 hover:text-red-600 transition text-xl py-2">
                        <i class="fa-regular fa-circle-user"></i>
                    </button>
                    
                    <div class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden z-50">
                        @guest
                            <a href="{{ route('login') }}" class="block px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <i class="fa-solid fa-arrow-right-to-bracket ml-2 opacity-50"></i> {{ __('تسجيل الدخول') }}
                            </a>
                            <a href="{{ route('register') }}" class="block px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <i class="fa-solid fa-user-plus ml-2 opacity-50"></i> {{ __('إنشاء حساب') }}
                            </a>
                            <a href="{{ route('order.track.form') }}" class="block px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fa-solid fa-location-dot ml-2 opacity-50 text-red-500"></i> {{ __('تتبع طلبك') }}
                            </a>
                        @else
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                    <i class="fa-solid fa-table-columns ml-2 opacity-50"></i> {{ __('لوحة التحكم') }}
                                </a>
                            @endif
                            <a href="{{ route('my.orders') }}" class="block px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <i class="fa-solid fa-box ml-2 opacity-50"></i> {{ __('طلباتي') }}
                            </a>
                            <a href="{{ route('order.track.form') }}" class="block px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <i class="fa-solid fa-location-dot ml-2 opacity-50 text-red-500"></i> {{ __('تتبع طلبك') }}
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <i class="fa-solid fa-user-gear ml-2 opacity-50"></i> {{ __('إعدادات الحساب') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-right block px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-gray-700">
                                    <i class="fa-solid fa-power-off ml-2"></i> {{ __('تسجيل الخروج') }}
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow overflow-hidden">
        @yield('content')
    </main>

   <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 pt-16 pb-8 mt-20 transition-colors">
        <div class="max-w-7xl mx-auto px-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div>
                    <h4 class="text-lg font-black text-gray-900 dark:text-white mb-6">{{ __('عن الشركة') }}</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed font-bold">{{ __('الوجهة الأولى لحلول الطباعة المتكاملة والأدوات المكتبية. نقدم أحدث التقنيات وأفضل خدمات الصيانة لضمان استمرارية أعمالك بكفاءة عالية وبدون توقف.') }}</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-black text-gray-900 dark:text-white mb-6">{{ __('روابط سريعة') }}</h4>
                    <ul class="space-y-3 text-sm font-bold text-gray-500 dark:text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-red-600 transition flex items-center gap-2"><i class="fa-solid fa-angle-left text-xs"></i> {{ __('الرئيسية') }}</a></li>
                        <li><a href="{{ route('home') }}#categories" class="hover:text-red-600 transition flex items-center gap-2"><i class="fa-solid fa-angle-left text-xs"></i> {{ __('الأقسام والمنتجات') }}</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-red-600 transition flex items-center gap-2"><i class="fa-solid fa-angle-left text-xs"></i> {{ __('سلة المشتريات') }}</a></li>
                        <li><a href="{{ route('home') }}#about" class="hover:text-red-600 transition flex items-center gap-2"><i class="fa-solid fa-angle-left text-xs"></i> {{ __('من نحن') }}</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-black text-gray-900 dark:text-white mb-6">{{ __('تواصل معنا') }}</h4>
                    <ul class="space-y-4 text-sm font-bold text-gray-500 dark:text-gray-400">
                        <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot mt-1 text-red-600"></i><span>{{ __('الزقازيق، مصر') }}<br>{{ __('14 شارع جوده عاشور - امام سجل مدني مفارق المنصوره') }}</span></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-phone text-red-600"></i><span dir="ltr">+20 1223635861</span></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-red-600"></i><span>xerooffice@hotmail.com</span></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-black text-gray-900 dark:text-white mb-6">{{ __('تابعنا على') }}</h4>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/share/1HjnRQaap2/" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-blue-600 hover:text-white transition-all hover:scale-110"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://wa.me/201223635861" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-green-500 hover:text-white transition-all hover:scale-110"><i class="fa-brands fa-whatsapp text-lg"></i></a>
                        <a href="https://www.instagram.com/mounir_arafa?igsh=MWY1eG5pdXIzZDlsaQ==" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-red-500 hover:to-purple-500 hover:text-white transition-all hover:scale-110"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col items-center justify-center gap-6 text-sm font-bold text-gray-500 dark:text-gray-400">
                
                <a href="{{ route('home') }}" class="flex items-center gap-2 hover:scale-105 transition-transform" dir="ltr">
                    <img src="{{ asset('images/logo.png') }}" class="h-14 w-auto drop-shadow-sm" alt="Logo">
                    <div class="flex flex-col justify-center leading-none mt-1 text-left">
                        <span class="text-red-600 text-2xl font-black tracking-tighter">XERO</span>
                        <span class="text-gray-900 dark:text-white text-[10px] font-black tracking-[0.25em] mt-1">OFFICE</span>
                    </div>
                </a>

                <p class="text-center tracking-wide">{{ __('جميع الحقوق محفوظة') }} &copy; {{ date('Y') }} - Xero Office</p>
                
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800
        });
    </script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const searchSuggestions = document.getElementById('searchSuggestions');
        const currentLang = document.documentElement.lang; // بنجيب لغة الموقع الحالية

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                let query = this.value;
                if(query.length > 1) { 
                    fetch(`/search-suggestions?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        searchSuggestions.innerHTML = '';
                        if(data.length > 0) {
                            searchSuggestions.classList.remove('hidden');
                            data.forEach(product => {
                                // عرض اسم المنتج حسب اللغة
                                let productName = currentLang === 'ar' ? product.name_ar : (product.name_en || product.name_ar);
                                
                                searchSuggestions.innerHTML += `
                                    <a href="/product/${product.id}" class="flex items-center gap-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-50 dark:border-gray-700 last:border-0 transition-colors">
                                        <img src="/storage/${product.image}" class="w-10 h-10 rounded-lg object-contain bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-600">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">${productName}</h4>
                                            <span class="text-xs font-black text-red-600">${product.price} ج.م</span>
                                        </div>
                                    </a>
                                `;
                            });
                        } else {
                            searchSuggestions.innerHTML = `<div class="p-4 text-center text-sm font-bold text-gray-500">{{ __('لا توجد منتجات مطابقة 😔') }}</div>`;
                            searchSuggestions.classList.remove('hidden');
                        }
                    });
                } else {
                    searchSuggestions.classList.add('hidden');
                }
            });

            document.addEventListener('click', function(e) {
                if(!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                    searchSuggestions.classList.add('hidden');
                }
            });
        }
    </script>
    <a href="https://wa.me/201223635861" target="_blank" rel="noopener noreferrer" class="fixed bottom-8 left-8 z-50 flex items-center justify-center w-14 h-14 bg-green-500 text-white rounded-full shadow-[0_4px_14px_0_rgba(34,197,94,0.5)] hover:bg-green-600 hover:scale-110 hover:shadow-[0_6px_20px_rgba(34,197,94,0.4)] transition-all duration-300 group">
        <i class="fa-brands fa-whatsapp text-3xl z-10 relative"></i>
        
        <span class="absolute right-full mr-4 w-max bg-gray-900 dark:bg-gray-700 text-white text-xs font-bold py-2 px-3 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-md">
            {{ __('محتاج مساعدة؟ تواصل معنا') }}
            <span class="absolute top-1/2 -right-1 -mt-1 border-4 border-transparent border-l-gray-900 dark:border-l-gray-700"></span>
        </span>
        
        <span class="absolute inline-flex w-full h-full rounded-full bg-green-400 opacity-75 animate-ping -z-0"></span>
    </a>
</body>
</html>