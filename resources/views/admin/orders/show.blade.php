@extends('layouts.admin')
@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition flex items-center mb-2">
                &larr; عودة للوحة التحكم
            </a>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white transition-colors">
                تفاصيل الطلب <span class="text-red-600">#{{ $order->id }}</span> 
            </h1>
        </div>
        
        <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="bg-gray-900 hover:bg-black text-white px-6 py-2 rounded-xl font-bold flex items-center gap-2">
    <i class="fa-solid fa-print"></i>  الفاتورة 
</a>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-8 flex flex-col md:flex-row items-center justify-between gap-6 transition-colors">
        <div class="flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
            <span class="font-black text-lg text-gray-800 dark:text-white">حالة الطلب الحالية:</span>
            <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="flex gap-3 w-full md:w-auto">
                @csrf
                @method('PUT')
                <select name="status" class="p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none font-bold transition-colors cursor-pointer appearance-none text-center">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ جاري التجهيز</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 تم الشحن</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ تم التوصيل</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ ملغي</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-sm">
                    تحديث
                </button>
            </form>
        </div>
        
        <div class="text-sm text-gray-500 dark:text-gray-400 font-bold bg-gray-50 dark:bg-gray-900 px-4 py-2 rounded-lg border dark:border-gray-700">
            🕒 تاريخ الطلب: {{ $order->created_at->format('Y-m-d h:i A') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        
        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
            <h2 class="text-xl font-black text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">بيانات العميل 👤</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b border-dashed dark:border-gray-700 pb-3">
                    <span class="text-gray-500 dark:text-gray-400 font-bold">الاسم:</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $order->customer_name }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-dashed dark:border-gray-700 pb-3">
                    <span class="text-gray-500 dark:text-gray-400 font-bold">التليفون:</span>
                    <span class="font-black text-red-600 dark:text-red-400" dir="ltr">{{ $order->customer_phone }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-dashed dark:border-gray-700 pb-3">
                    <span class="text-gray-500 dark:text-gray-400 font-bold">الإيميل:</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $order->customer_email ?? 'غير متوفر' }}</span>
                </div>
                <div class="flex flex-col gap-2 pt-2">
                    <span class="text-gray-500 dark:text-gray-400 font-bold">عنوان الشحن:</span>
                    <span class="font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 p-3 rounded-lg border dark:border-gray-700 leading-relaxed">
                        {{ $order->shipping_address }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors flex flex-col">
            <h2 class="text-xl font-black text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">ملخص الحساب 💳</h2>
            <div class="space-y-4 flex-grow">
                <div class="flex justify-between items-center border-b border-dashed dark:border-gray-700 pb-3">
                    <span class="text-gray-500 dark:text-gray-400 font-bold">طريقة الدفع:</span>
                    <span class="font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 px-3 py-1 rounded-full text-sm border border-green-200 dark:border-green-800">
                        {{ $order->payment_method == 'cash' ? '💵 نقداً عند الاستلام' : $order->payment_method }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center border-b border-dashed dark:border-gray-700 pb-3">
                    <span class="text-gray-500 dark:text-gray-400 font-bold">مصاريف الشحن:</span>
                    <span class="font-bold text-gray-900 dark:text-white">مجاناً</span>
                </div>
            </div>
            
            <div class="mt-auto bg-gray-50 dark:bg-gray-900 p-6 rounded-xl border dark:border-gray-700 flex justify-between items-center">
                <span class="text-xl font-black text-gray-900 dark:text-white">الإجمالي الكلي:</span>
                <span class="text-3xl font-black text-red-600">{{ $order->total_amount }} <span class="text-sm text-gray-500">ج.م</span></span>
            </div>
        </div>

    </div>

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors mb-8">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
            <h2 class="text-xl font-black text-gray-900 dark:text-white">المنتجات المطلوبة 🛒</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/50 text-sm">
                    <tr>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold">اسم المنتج</th>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold text-center">الكمية</th>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold text-center">سعر الوحدة</th>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold text-left">الإجمالي</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($order->items ?? [] as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $item->product_name }}</td>
                        <td class="p-4 font-black text-red-600 text-center text-lg">x{{ $item->quantity }}</td>
                        <td class="p-4 font-bold text-gray-700 dark:text-gray-300 text-center">{{ $item->price }} ج.م</td>
                        <td class="p-4 font-black text-gray-900 dark:text-white text-left">{{ $item->price * $item->quantity }} ج.م</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500 font-bold">لم يتم جلب المنتجات (تأكد من العلاقة في الموديل)</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .max-w-6xl, .max-w-6xl * { visibility: visible; }
        .max-w-6xl { position: absolute; left: 0; top: 0; width: 100%; }
        button, a, form { display: none !important; }
    }
</style>
@endsection