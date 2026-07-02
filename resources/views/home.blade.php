<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xero Office')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = { darkMode: 'class' }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        function updateThemeToggleIcon() {
            const moon = document.getElementById('themeIconMoon');
            const sun = document.getElementById('themeIconSun');
            if (!moon || !sun) return;
            if (document.documentElement.classList.contains('dark')) {
                moon.style.display = 'none';
                sun.style.display = 'inline';
            } else {
                moon.style.display = 'inline';
                sun.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateThemeToggleIcon();
        });

        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            updateThemeToggleIcon();
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
        #about, #categories { scroll-margin-top: 100px; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300 flex flex-col min-h-screen relative z-0">

    <div class="fixed inset-0 z-[-1] flex items-center justify-center opacity-[0.05] dark:opacity-[0.02] pointer-events-none">
        <img src="{{ asset('images/logo.png') }}" alt="Xero" class="w-1/2 max-w-2xl grayscale">
    </div>

    <nav class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50 transition-colors">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 flex justify-between items-center h-14 sm:h-20">
            
            <div class="flex items-center gap-1 sm:gap-6 lg:gap-8 shrink-0">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-600 dark:text-gray-300 hover:text-red-600 transition-colors text-lg p-2">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <a href="{{ route('home') }}" class="flex items-center gap-1 md:gap-2" dir="ltr">
                    <img src="{{ asset('images/logo.png') }}" class="h-6 sm:h-10 md:h-12 lg:h-14 w-auto object-contain" alt="Logo">
                    <div class="flex flex-col justify-center leading-none mt-1">
                        <span class="text-red-600 text-sm sm:text-xl md:text-2xl font-black tracking-tighter">XERO</span>
                        <span class="text-gray-900 dark:text-white text-[5px] sm:text-[8px] md:text-[10px] font-bold tracking-[0.2em]">OFFICE</span>
                    </div>
                </a>
                
                <div class="hidden md:flex gap-4 lg:gap-6 font-bold text-gray-600 dark:text-gray-300 text-sm lg:text-base">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-red-600' : '' }} hover:text-red-600 transition whitespace-nowrap">{{ __('الرئيسية') }}</a>
                    
                    <!-- Categories Dropdown (Desktop) -->
                    <div class="relative group">
                        <button class="hover:text-red-600 transition whitespace-nowrap flex items-center gap-1">
                            {{ __('الأقسام') }} <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute top-full {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} mt-5 w-48 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 py-2 before:absolute before:-top-5 before:left-0 before:w-full before:h-5 z-50">
                            @php
                                $nav_categories = \App\Models\Category::all();
                            @endphp
                            @forelse($nav_categories as $category)
                                <a href="{{ route('category.show', $category->slug ?? $category->name_en) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-red-50 hover:text-red-600 dark:hover:bg-gray-700 transition">
                                    {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                                </a>
                            @empty
                                <span class="block px-4 py-2 text-sm text-gray-500">{{ __('لا توجد أقسام حالياً') }}</span>
                            @endforelse
                        </div>
                    </div>
                    
                    <a href="{{ route('home') }}#about" class="hover:text-red-600 transition whitespace-nowrap">{{ __('من نحن') }}</a>
                </div>
            </div>

            <div class="flex items-center gap-1 sm:gap-5 shrink-0">
                <form action="{{ route('search') }}" method="GET" class="hidden lg:flex items-center relative group">
                    <input type="text" name="query" placeholder="{{ __('ابحث عن طابعة، حبر...') }}"
                        class="bg-gray-100 dark:bg-gray-700 border-none rounded-xl py-2 px-4 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-10' }} w-48 lg:w-64 focus:ring-2 focus:ring-red-600 transition-all outline-none dark:text-white text-sm">
                    <button type="submit" class="absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} text-gray-400 group-hover:text-red-600 transition-colors">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                
                <!-- Mobile Search Icon -->
                <button id="mobile-search-btn" class="lg:hidden text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors text-base sm:text-xl p-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <button onclick="toggleTheme()" aria-label="{{ __('تبديل الوضع') }}" class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-gray-100/90 dark:bg-gray-700/80 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 text-lg md:text-xl">
                    <i id="themeIconMoon" class="fa-solid fa-moon" style="display: inline"></i>
                    <i id="themeIconSun" class="fa-solid fa-sun" style="display: none"></i>
                </button>

                <a href="{{ route('cart.index') }}" class="relative text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors text-base sm:text-xl p-2">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-1 {{ app()->getLocale() == 'ar' ? '-left-1' : '-right-1' }} bg-red-600 text-white text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <div class="relative group">
                    <button class="flex items-center gap-2 font-bold text-gray-700 dark:text-gray-200 hover:text-red-600 transition text-base sm:text-xl p-2">
                        <i class="fa-regular fa-circle-user"></i>
                    </button>
                    <div class="absolute mt-5 w-48 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 origin-top {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} before:absolute before:-top-5 before:left-0 before:w-full before:h-5">
                        @guest
                            <a href="{{ route('login') }}" class="flex w-full items-center gap-3 px-4 py-3 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white rounded-t-2xl">
                                <i class="fa-solid fa-arrow-right-to-bracket w-5 text-center opacity-50"></i>
                                <span>{{ __('تسجيل الدخول') }}</span>
                            </a>
                            <a href="{{ route('register') }}" class="flex w-full items-center gap-3 px-4 py-3 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white rounded-b-2xl">
                                <i class="fa-solid fa-user-plus w-5 text-center opacity-50"></i>
                                <span>{{ __('إنشاء حساب') }}</span>
                            </a>
                        @else
                            <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('my.orders') }}" class="flex w-full items-center gap-3 px-4 py-3 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white border-b border-gray-100 dark:border-gray-700 rounded-t-2xl">
                                <i class="fa-solid fa-table-columns w-5 text-center opacity-50"></i>
                                <span>{{ auth()->user()->is_admin ? __('لوحة التحكم') : __('طلباتي') }}</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex w-full items-center gap-3 px-4 py-3 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white border-b border-gray-100 dark:border-gray-700">
                                <i class="fa-solid fa-user-gear w-5 text-center opacity-50"></i>
                                <span>{{ __('إعدادات الحساب') }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-gray-700 text-start rounded-b-2xl">
                                    <i class="fa-solid fa-power-off w-5 text-center"></i>
                                    <span>{{ __('تسجيل الخروج') }}</span>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
        
        <!-- Mobile Search Bar (Hidden by default) -->
        <div id="mobile-search-container" class="hidden lg:hidden absolute top-full left-0 w-full border-b border-gray-100 dark:border-gray-700 px-4 py-3 bg-white dark:bg-gray-800 shadow-md">
            <form action="{{ route('search') }}" method="GET" class="flex items-center relative w-full">
                <input type="text" name="query" placeholder="{{ __('ابحث عن طابعة، حبر...') }}"
                    class="bg-gray-100 dark:bg-gray-700 border-none rounded-xl py-2 px-4 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-10' }} w-full focus:ring-2 focus:ring-red-600 transition-all outline-none dark:text-white text-sm">
                <button type="submit" class="absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} text-gray-400 hover:text-red-600 transition-colors">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu-container" class="hidden md:hidden absolute top-full left-0 w-full border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 flex-col shadow-xl">
            <a href="{{ route('home') }}" class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 font-bold text-gray-700 dark:text-gray-200 hover:text-red-600 dark:hover:text-red-500">{{ __('الرئيسية') }}</a>
            
            <!-- Mobile Categories -->
            <div class="border-b border-gray-100 dark:border-gray-700">
                <button id="mobile-categories-btn" class="w-full px-4 py-3 flex justify-between items-center font-bold text-gray-700 dark:text-gray-200 hover:text-red-600 dark:hover:text-red-500">
                    <span>{{ __('الأقسام') }}</span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform" id="mobile-categories-icon"></i>
                </button>
                <div id="mobile-categories-list" class="hidden bg-gray-50 dark:bg-gray-900/50 flex-col">
                    @forelse($nav_categories ?? \App\Models\Category::all() as $category)
                        <a href="{{ route('category.show', $category->slug ?? $category->name_en) }}" class="px-8 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-500 block border-l-2 border-transparent hover:border-red-600">
                            {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                        </a>
                    @empty
                        <span class="px-8 py-2 text-sm text-gray-500">{{ __('لا توجد أقسام حالياً') }}</span>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('home') }}#about" class="px-4 py-3 font-bold text-gray-700 dark:text-gray-200 hover:text-red-600 dark:hover:text-red-500">{{ __('من نحن') }}</a>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-t dark:border-gray-700 text-center py-8 mt-20 transition-colors">
        <p class="font-bold text-gray-600 dark:text-gray-400">جميع الحقوق محفوظة &copy; {{ date('Y') }} - Xero Office</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Mobile toggles
            document.getElementById('mobile-search-btn')?.addEventListener('click', function() {
                const searchContainer = document.getElementById('mobile-search-container');
                searchContainer.classList.toggle('hidden');
            });

            document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
                const menuContainer = document.getElementById('mobile-menu-container');
                menuContainer.classList.toggle('hidden');
                menuContainer.classList.toggle('flex');
            });

            document.getElementById('mobile-categories-btn')?.addEventListener('click', function() {
                const categoriesList = document.getElementById('mobile-categories-list');
                const categoriesIcon = document.getElementById('mobile-categories-icon');
                
                categoriesList.classList.toggle('hidden');
                categoriesList.classList.toggle('flex');
                
                if(categoriesList.classList.contains('hidden')) {
                    categoriesIcon.style.transform = 'rotate(0deg)';
                } else {
                    categoriesIcon.style.transform = 'rotate(180deg)';
                }
            });

            // AJAX للمفضلة (إضافة / إزالة)
            document.querySelectorAll('.favorite-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let url = this.action;
                    let formData = new FormData(this);
                    let icon = this.querySelector('i');
                    let button = this.querySelector('button');
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    }).then(response => {
                        if(response.ok) {
                            // لو إحنا في صفحة "قائمة المفضلة"، نمسح كارت المنتج فوراً من الشاشة
                            if (this.classList.contains('remove-card-on-success')) {
                                this.closest('.group').remove();
                                return;
                            }
                            
                            // تبديل شكل الأيقونة لباقي الصفحات
                            if(icon && icon.classList.contains('fa-heart')) {
                                if(icon.classList.contains('fa-solid')) {
                                    icon.classList.remove('fa-solid', 'text-red-600');
                                    icon.classList.add('fa-regular');
                                } else {
                                    icon.classList.remove('fa-regular');
                                    icon.classList.add('fa-solid', 'text-red-600');
                                }
                            } else if (button && button.innerText) {
                                // لصفحة نتائج البحث اللي بتستخدم إيموجي
                                button.innerText = button.innerText.includes('❤️') ? button.innerText.replace('❤️', '🤍') : button.innerText.replace('🤍', '❤️');
                            }
                        } else if (response.status === 401) {
                            window.location.href = "{{ route('login') }}";
                        }
                    }).catch(error => console.error('Error:', error));
                });
            });

            // AJAX للإضافة للسلة
            document.querySelectorAll('.cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    // لو العميل ضغط "اشتري الآن"، نسيب الصفحة تحمل عشان تحوله لصفحة الدفع
                    if (e.submitter && e.submitter.name === 'buy_now') return;
                    
                    e.preventDefault();
                    let url = this.action;
                    let formData = new FormData(this);
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    }).then(response => response.json())
                      .then(data => {
                          if(data.success) {
                              // تحديث العداد في الهيدر
                              let cartLinks = document.querySelectorAll('a[href*="cart"]');
                              cartLinks.forEach(link => {
                                  let badge = link.querySelector('span.absolute');
                                  if (!badge) {
                                      badge = document.createElement('span');
                                      badge.className = 'absolute -top-1 ' + (document.documentElement.lang === 'ar' ? '-left-1' : '-right-1') + ' bg-red-600 text-white text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full';
                                      link.appendChild(badge);
                                  }
                                  badge.innerText = data.cart_count;
                              });

                              // إظهار رسالة Toast منبثقة أسفل الشاشة
                              let toast = document.createElement('div');
                              toast.className = 'fixed bottom-5 right-5 bg-gray-900 dark:bg-gray-800 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 flex items-center gap-3 animate-bounce border border-gray-700';
                              toast.innerHTML = '<i class="fa-solid fa-circle-check text-green-400 text-xl"></i> <span class="font-bold">' + data.message + '</span>';
                              document.body.appendChild(toast);
                              
                              setTimeout(() => {
                                  toast.style.opacity = '0';
                                  toast.style.transition = 'opacity 0.5s ease';
                                  setTimeout(() => toast.remove(), 500);
                              }, 3000);
                          }
                      }).catch(error => console.error('Error:', error));
                });

                document.querySelectorAll('a[href*="#"]').forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        const url = new URL(this.href, window.location.origin);
                        const currentPath = window.location.pathname.replace(/\/$/, '');
                        const linkPath = url.pathname.replace(/\/$/, '');
                        if (!url.hash) return;
                        if (linkPath === currentPath) {
                            const target = document.querySelector(url.hash);
                            if (target) {
                                event.preventDefault();
                                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                history.replaceState(null, '', url.hash);
                            }
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>