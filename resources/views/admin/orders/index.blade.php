@extends('layouts.admin')
@section('title', 'إدارة الطلبات ')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-black text-gray-900 dark:text-white transition-colors">إدارة الطلبات</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/30 text-sm">
                    <tr>
                        <th class="p-5 text-gray-500 font-bold">رقم الطلب</th>
                        <th class="p-5 text-gray-500 font-bold">تاريخ الطلب</th>
                        <th class="p-5 text-gray-500 font-bold">اسم العميل</th>
                        <th class="p-5 text-gray-500 font-bold text-center">الإجمالي</th>
                        <th class="p-5 text-gray-500 font-bold text-center">الحالة</th>
                        <th class="p-5 text-gray-500 font-bold text-center">العمليات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="p-5 font-black text-gray-900 dark:text-white">#{{ $order->id }}</td>
                        <td class="p-5 text-gray-600 dark:text-gray-400 font-bold">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="p-5 font-bold text-gray-700 dark:text-gray-300">{{ $order->customer_name }}</td>
                        <td class="p-5 font-black text-red-600 text-center">{{ $order->total_amount }} ج.م</td>
                        <td class="p-5 text-center">
                            @if($order->status == 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-bold border border-yellow-200">قيد الانتظار</span>
                            @elseif($order->status == 'processing')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-bold border border-blue-200">جاري التجهيز</span>
                            @elseif($order->status == 'shipped')
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-lg text-xs font-bold border border-purple-200">تم الشحن</span>
                            @elseif($order->status == 'delivered')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-bold border border-green-200">مكتمل</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-bold border border-red-200">ملغي</span>
                            @endif
                        </td>
                        <td class="p-5 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-red-600 hover:text-white rounded-xl transition-all shadow-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-500 font-bold text-lg">لا توجد طلبات حتى الآن.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection