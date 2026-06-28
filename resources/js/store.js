const setupSearch = (input, suggestionsContainer) => {
    if (!input || !suggestionsContainer) {
        return;
    }

    const currentLang = document.documentElement.lang;

    input.addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length <= 1) {
            suggestionsContainer.classList.add('hidden');
            return;
        }

        fetch(`/search-suggestions?query=${encodeURIComponent(query)}`)
            .then((response) => response.json())
            .then((data) => {
                suggestionsContainer.innerHTML = '';

                if (!Array.isArray(data) || data.length === 0) {
                    suggestionsContainer.innerHTML = `<div class="p-4 text-center text-sm font-bold text-gray-500">${currentLang === 'ar' ? 'لا توجد منتجات مطابقة 😔' : 'No matching products 😔'}</div>`;
                    suggestionsContainer.classList.remove('hidden');
                    return;
                }

                suggestionsContainer.classList.remove('hidden');
                data.forEach((product) => {
                    const productName = currentLang === 'ar' ? product.name_ar : product.name_en || product.name_ar;
                    suggestionsContainer.innerHTML += `
                        <a href="/product/${product.id}" class="flex items-center gap-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-50 dark:border-gray-700 last:border-0 transition-colors">
                            <img src="/storage/${product.image}" class="w-10 h-10 rounded-lg object-contain bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-600" alt="${productName}">
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">${productName}</h4>
                                <span class="text-xs font-black text-red-600">${product.price} ج.م</span>
                            </div>
                        </a>
                    `;
                });
            })
            .catch(() => {
                suggestionsContainer.classList.add('hidden');
            });
    });
};

document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const closeSidebarBtn = document.getElementById('closeSidebarBtn');
    const mobileSearchBtn = document.getElementById('mobileSearchBtn');
    const mobileSearchContainer = document.getElementById('mobileSearchContainer');
    const mobileCatToggle = document.getElementById('mobileCatToggle');
    const mobileCatMenu = document.getElementById('mobileCatMenu');
    const mobileCatIcon = document.getElementById('mobileCatIcon');

    const isRtl = document.documentElement.dir === 'rtl';

    const toggleSidebar = () => {
        if (!sidebarBackdrop || !mobileSidebar) {
            return;
        }

        sidebarBackdrop.classList.toggle('hidden');
        setTimeout(() => sidebarBackdrop.classList.toggle('opacity-0'), 10);

        if (isRtl) {
            mobileSidebar.classList.toggle('translate-x-full');
        } else {
            mobileSidebar.classList.toggle('-translate-x-full');
        }

        document.body.classList.toggle('overflow-hidden');
    };

    mobileMenuBtn?.addEventListener('click', toggleSidebar);
    closeSidebarBtn?.addEventListener('click', toggleSidebar);
    sidebarBackdrop?.addEventListener('click', toggleSidebar);

    mobileSearchBtn?.addEventListener('click', () => {
        if (!mobileSearchContainer) {
            return;
        }

        mobileSearchContainer.classList.toggle('hidden');
        if (!mobileSearchContainer.classList.contains('hidden')) {
            document.getElementById('mobileSearchInput')?.focus();
        }
    });

    mobileCatToggle?.addEventListener('click', () => {
        if (!mobileCatMenu || !mobileCatIcon) {
            return;
        }
        mobileCatMenu.classList.toggle('hidden');
        mobileCatMenu.classList.toggle('flex');
        mobileCatIcon.classList.toggle('rotate-180');
    });

    setupSearch(document.getElementById('searchInput'), document.getElementById('searchSuggestions'));
    setupSearch(document.getElementById('mobileSearchInput'), document.getElementById('mobileSearchSuggestions'));

    document.addEventListener('click', function (event) {
        const searchInput = document.getElementById('searchInput');
        const searchSuggestions = document.getElementById('searchSuggestions');
        const mobileSearchInput = document.getElementById('mobileSearchInput');
        const mobileSearchSuggestions = document.getElementById('mobileSearchSuggestions');

        if (searchInput && searchSuggestions && !searchInput.contains(event.target) && !searchSuggestions.contains(event.target)) {
            searchSuggestions.classList.add('hidden');
        }

        if (mobileSearchInput && mobileSearchSuggestions && !mobileSearchInput.contains(event.target) && !mobileSearchSuggestions.contains(event.target)) {
            mobileSearchSuggestions.classList.add('hidden');
        }
    });
});
