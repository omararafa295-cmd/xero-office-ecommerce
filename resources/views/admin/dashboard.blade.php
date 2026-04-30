@extends('layouts.admin')
@section('title', 'نظرة عامة')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-3xl p-8 text-white shadow-lg flex items-center justify-between overflow-hidden relative">
        <div class="relative z-10">
            <h1 class="text-3xl font-black mb-2">أهلاً بك يا {{ auth()->user()->name }}! </h1>
            <p class="text-red-100 font-bold">هذه نظرة سريعة على أداء متجر Xero Office.</p>
        </div>
        <i class="fa-solid fa-chart-line text-9xl absolute left-10 opacity-20 transform -rotate-12"></i>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors flex items-center gap-6">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-box-open"></i></div>
            <div><p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1">إجمالي المنتجات</p><h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $total_products ?? 0 }}</h3></div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors flex items-center gap-6">
            <div class="w-14 h-14 rounded-2xl bg-green-50 dark:bg-green-900/30 text-green-600 flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-cart-arrow-down"></i></div>
            <div><p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1">إجمالي الطلبات</p><h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $total_orders ?? 0 }}</h3></div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors flex items-center gap-6">
            <div class="w-14 h-14 rounded-2xl bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-users"></i></div>
            <div><p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1">العملاء المسجلين</p><h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $total_customers ?? 0 }}</h3></div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors flex items-center gap-6">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-wallet"></i></div>
            <div><p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1">المبيعات</p><h3 class="text-xl font-black text-gray-900 dark:text-white">{{ number_format($total_sales ?? 0, 2) }} <span class="text-xs">ج.م</span></h3></div>
        </div>
    </div>

    <!-- سكشن الرسم البياني + الفلتر جواه -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <h3 class="text-xl font-black text-gray-900 dark:text-white">مؤشر المبيعات</h3>
            
          
            <form action="{{ route('admin.dashboard') }}" method="GET">
                <div class="relative">
                    <i class="fa-solid fa-calendar-days absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <select name="filter" onchange="this.form.submit()" class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl py-2 pr-10 pl-4 font-bold focus:ring-2 focus:ring-red-600 outline-none transition cursor-pointer text-sm">
                        <option value="all" {{ ($filter ?? 'all') == 'all' ? 'selected' : '' }}>كل الأوقات</option>
                        <option value="today" {{ ($filter ?? '') == 'today' ? 'selected' : '' }}>اليوم</option>
                        <option value="week" {{ ($filter ?? '') == 'week' ? 'selected' : '' }}>هذا الأسبوع</option>
                        <option value="month" {{ ($filter ?? '') == 'month' ? 'selected' : '' }}>هذا الشهر</option>
                        <option value="year" {{ ($filter ?? '') == 'year' ? 'selected' : '' }}>هذا العام</option>
                    </select>
                </div>
            </form>
        </div>
        
        <div class="relative h-72 w-full">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- قسم الطلبات والأكثر مبيعاً  -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4 mb-8">
        
        <!-- كارت أحدث الطلبات -->
        <div class="lg:col-span-2 bg-white dark:bg-[#1e293b] rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700/60 overflow-hidden transition-colors">
            
            <!-- الهيدر -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700/60">
                <h3 class="text-xl font-black text-gray-900 dark:text-white">أحدث الطلبات</h3>
                <a href="{{ route('admin.orders.export') }}" class="text-green-600 dark:text-green-400 hover:text-green-700 font-bold text-sm flex items-center gap-1 transition">
                    <i class="fa-solid fa-file-excel"></i> تصدير للإكسيل
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <!-- رأس الجدول -->
                    <thead class="text-sm border-b border-gray-100 dark:border-gray-700/60">
                        <tr>
                            <th class="p-4 text-gray-400 dark:text-gray-400 font-bold">الطلب</th>
                            <th class="p-4 text-gray-400 dark:text-gray-400 font-bold">العميل</th>
                            <th class="p-4 text-gray-400 dark:text-gray-400 font-bold text-center">الإجمالي</th>
                            <th class="p-4 text-gray-400 dark:text-gray-400 font-bold text-center">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @forelse($recent_orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group">
                                <td class="p-4 font-black text-gray-900 dark:text-white">#{{ $order->id }}</td>
                                <td class="p-4 font-bold text-gray-700 dark:text-gray-300">
                                    {{ $order->customer_name }}
                                    <span class="block text-xs text-gray-400 dark:text-gray-500 mt-1" dir="ltr">{{ $order->customer_phone ?? optional($order->user)->phone }}</span>
                                </td>
                                <td class="p-4 font-black text-red-600 dark:text-red-400 text-center">{{ $order->total_amount }} ج</td>
                                <td class="p-4 text-center">
                                    @if($order->status == 'pending') <span class="px-3 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-lg text-xs font-bold border border-yellow-200 dark:border-yellow-800/50">قيد الانتظار</span>
                                    @elseif($order->status == 'delivered') <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-lg text-xs font-bold border border-green-200 dark:border-green-800/50">مكتمل</span>
                                    @else <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 rounded-lg text-xs font-bold border border-blue-200 dark:border-blue-800/50">جاري</span> @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-8 text-center text-gray-500 font-bold">لا توجد طلبات.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- كارت الأكثر مبيعاً -->
        <div class="lg:col-span-1 bg-white dark:bg-[#1e293b] rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700/60 h-fit overflow-hidden transition-colors">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700/60">
                <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-fire text-orange-500"></i> الأكثر مبيعاً
                </h3>
            </div>
            <div class="p-6 space-y-4">
                @foreach($best_sellers as $product)
    
                    <div class="flex items-center gap-4 p-2 rounded-2xl hover:bg-gray-50 dark:hover:bg-white/5 transition border border-transparent dark:hover:border-gray-700/50">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 rounded-xl object-cover shadow-sm bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/50">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm line-clamp-1">{{ $product->name_ar }}</h4>
                            <p class="text-red-600 dark:text-red-400 font-black mt-1">{{ $product->price }} ج.م</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const labels = {!! json_encode($chartDates ?? []) !!};
        const data = {!! json_encode($chartTotals ?? []) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'المبيعات (ج.م)',
                    data: data,
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.08)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#dc2626',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection