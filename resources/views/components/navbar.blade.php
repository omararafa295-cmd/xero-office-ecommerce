<!-- Navbar Container -->
<nav class="fixed top-0 start-0 w-full z-40 bg-white/70 dark:bg-xero-gray/70 backdrop-blur-lg border-b border-gray-200 dark:border-gray-800 transition-colors duration-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      
      <!-- Start Edge: Logo -->
      <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30">
          X
        </div>
        <span class="font-bold text-xl text-gray-900 dark:text-white tracking-wide">{{ config('app.name', 'Xero Office') }}</span>
      </div>

      <!-- Center: Navigation Links -->
      <div class="hidden md:flex items-center gap-8">
        <a href="{{ url('/') }}" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('الرئيسية') }}</a>
        
        <!-- Categories Dropdown (Logical positioning: start-0) -->
        <div class="relative group">
          <button class="flex items-center gap-1 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors focus:outline-none py-4">
            {{ __('الأقسام') }}
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          
          <div class="absolute top-full start-0 mt-1 w-56 bg-white dark:bg-xero-dark rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-50 overflow-hidden">
            <div class="py-2">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-xero-gray hover:text-blue-600 dark:hover:text-blue-400">طابعات (Printers)</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-xero-gray hover:text-blue-600 dark:hover:text-blue-400">أحبار (Ink & Toner)</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-xero-gray hover:text-blue-600 dark:hover:text-blue-400">قطع غيار (Spare Parts)</a>
            </div>
          </div>
        </div>

        <a href="#" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('من نحن') }}</a>
      </div>

      <!-- End Edge: Icons & Mobile Toggle -->
      <div class="flex items-center gap-3 sm:gap-4">
        
        <!-- Language Switcher (يستخدم مسار LanguageController) -->
        @php
            $currentLocale = session('locale', 'ar');
        @endphp
        <div class="relative group">
          <button class="flex items-center gap-1 text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors focus:outline-none py-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="uppercase ms-1">{{ $currentLocale === 'ar' ? 'AR' : 'EN' }}</span>
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          
          <div class="absolute top-full end-0 mt-1 w-32 bg-white dark:bg-xero-dark rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-50 overflow-hidden">
            <div class="py-2">
              <a href="{{ url('lang/ar') }}" class="block px-4 py-2 text-sm font-bold {{ $currentLocale === 'ar' ? 'text-blue-600 bg-blue-50 dark:bg-xero-gray' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-xero-gray hover:text-blue-600 dark:hover:text-blue-400' }}">العربية</a>
              <a href="{{ url('lang/en') }}" class="block px-4 py-2 text-sm font-bold {{ $currentLocale === 'en' ? 'text-blue-600 bg-blue-50 dark:bg-xero-gray' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-xero-gray hover:text-blue-600 dark:hover:text-blue-400' }}">English</a>
            </div>
          </div>
        </div>

        <!-- Theme Toggle (يعتمد على darkMode: 'class' الموجود في tailwind.config.js) -->
        <button id="theme-toggle" aria-label="Toggle Theme" class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-xero-gray rounded-full transition-colors">
          <svg id="theme-icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
          <svg id="theme-icon-moon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
        </button>

        <!-- Cart Button (تم ربطها بسلة التسوق الخاصة بـ CheckoutController) -->
        <a href="{{ url('/checkout') }}" aria-label="Cart" class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-xero-gray rounded-full transition-colors relative">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
          @if($cartCount > 0)
              <!-- استخدام اللون المخصص لك (bg-xero-red) -->
              <span class="absolute top-0 end-0 bg-xero-red text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center transform translate-x-1 -translate-y-1">
                  {{ $cartCount }}
              </span>
          @endif
        </a>

        <!-- Mobile Menu Toggle -->
        <button id="mobile-menu-btn" aria-label="Open Menu" class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-xero-gray rounded-full transition-colors ms-1">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

      </div>
    </div>
  </div>
</nav>

<!-- Off-Canvas Sidebar Backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Off-Canvas Sidebar (Drawer) -->
<aside id="mobile-sidebar" class="fixed top-0 start-0 w-80 max-w-[85vw] h-full z-50 bg-white/95 dark:bg-xero-dark/95 backdrop-blur-xl shadow-2xl border-e border-gray-200 dark:border-gray-800 transform ltr:-translate-x-full rtl:translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
  <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
    <span class="font-bold text-lg text-gray-900 dark:text-white">القائمة</span>
    <button id="close-sidebar-btn" class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-xero-gray rounded-full transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
  </div>
  <div class="flex-1 overflow-y-auto py-4 px-4 custom-scrollbar">
    <nav class="flex flex-col gap-2">
      <a href="{{ url('/') }}" class="px-4 py-3 text-gray-800 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl font-medium transition-colors">الرئيسية</a>
      <div class="flex flex-col">
        <button id="accordion-btn" class="flex justify-between items-center px-4 py-3 text-gray-800 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl font-medium transition-colors w-full text-start">
          الأقسام
          <svg id="accordion-icon" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div id="accordion-content" class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-in-out">
          <div class="overflow-hidden">
            <div class="flex flex-col gap-1 py-2 ps-6 pe-4 border-s-2 border-gray-100 dark:border-gray-800 ms-4 mt-1">
              <a href="#" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-xero-gray transition-colors">الطابعات</a>
              <a href="#" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-xero-gray transition-colors">الأحبار</a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const closeSidebarBtn = document.getElementById('close-sidebar-btn');
    const sidebar = document.getElementById('mobile-sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');
    
    const accordionBtn = document.getElementById('accordion-btn');
    const accordionContent = document.getElementById('accordion-content');
    const accordionIcon = document.getElementById('accordion-icon');
    
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIconSun = document.getElementById('theme-icon-sun');
    const themeIconMoon = document.getElementById('theme-icon-moon');

    const openSidebar = () => {
        sidebarBackdrop.classList.remove('opacity-0', 'pointer-events-none');
        sidebarBackdrop.classList.add('opacity-100', 'pointer-events-auto');
        sidebar.classList.remove('ltr:-translate-x-full', 'rtl:translate-x-full');
        sidebar.classList.add('translate-x-0');
        document.body.style.overflow = 'hidden';
    };

    const closeSidebar = () => {
        sidebarBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
        sidebarBackdrop.classList.add('opacity-0', 'pointer-events-none');
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('ltr:-translate-x-full', 'rtl:translate-x-full');
        document.body.style.overflow = '';
    };

    mobileMenuBtn.addEventListener('click', openSidebar);
    closeSidebarBtn.addEventListener('click', closeSidebar);
    sidebarBackdrop.addEventListener('click', closeSidebar);

    accordionBtn.addEventListener('click', () => {
        const isExpanded = accordionContent.classList.contains('grid-rows-[1fr]');
        if (isExpanded) {
            accordionContent.classList.replace('grid-rows-[1fr]', 'grid-rows-[0fr]');
            accordionIcon.classList.remove('rotate-180');
        } else {
            accordionContent.classList.replace('grid-rows-[0fr]', 'grid-rows-[1fr]');
            accordionIcon.classList.add('rotate-180');
        }
    });

    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const currentTheme = localStorage.getItem('theme') || (prefersDark ? 'dark' : 'light');

    const updateThemeUI = (theme) => {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            themeIconSun.classList.remove('hidden');
            themeIconMoon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            themeIconSun.classList.add('hidden');
            themeIconMoon.classList.remove('hidden');
        }
    };

    updateThemeUI(currentTheme);

    themeToggleBtn.addEventListener('click', () => {
        const isDark = document.documentElement.classList.contains('dark');
        const newTheme = isDark ? 'light' : 'dark';
        localStorage.setItem('theme', newTheme);
        updateThemeUI(newTheme);
    });
});
</script>