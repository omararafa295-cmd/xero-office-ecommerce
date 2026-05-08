@extends('layouts.admin')
@section('title', 'إدارة الكوبونات')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-6 font-bold border border-green-200">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded-xl mb-6 font-bold border border-red-200">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- فورم الإضافة -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-black mb-6 dark:text-white text-red-600">إضافة كوبون جديد</h2>
                <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">كود الكوبون</label>
                        <input type="text" name="code" value="{{ old('code') }}" placeholder="مثال: SAVE20" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl outline-none focus:ring-2 focus:ring-red-500 dark:text-white transition-all uppercase">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">نوع الخصم</label>
                        <select name="type" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl outline-none focus:ring-2 focus:ring-red-500 dark:text-white transition-all cursor-pointer">
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>مبلغ ثابت (ج.م)</option>
                            <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">قيمة الخصم</label>
                        <input type="number" step="0.01" name="value" value="{{ old('value') }}" placeholder="10" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl outline-none focus:ring-2 focus:ring-red-500 dark:text-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">حد الاستخدام (مرات)</label>
                        <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="فارغ = بلا حدود" class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl outline-none focus:ring-2 focus:ring-red-500 dark:text-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">تاريخ الانتهاء</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at') }}" class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl outline-none focus:ring-2 focus:ring-red-500 dark:text-white transition-all">
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3 rounded-xl transition shadow-md">إضافة الكوبون</button>
                </form>
            </div>
        </div>

        <!-- قائمة الكوبونات -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-right">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="p-4 font-black">الكود</th>
                                <th class="p-4 font-black">قيمة الخصم</th>
                                <th class="p-4 font-black text-center">مرات الاستخدام</th>
                                <th class="p-4 font-black">تاريخ الانتهاء</th>
                                <th class="p-4 font-black text-center">العمليات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                            @foreach($coupons as $coupon)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="p-4">
                                        <span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-lg font-black uppercase text-sm border border-gray-200 dark:border-gray-600">{{ $coupon->code }}</span>
                                    </td>
                                    <td class="p-4 font-black text-red-600">
                                        {{ number_format($coupon->value, 2) }}{{ $coupon->type == 'percent' ? '%' : ' ج.م' }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex flex-col items-center">
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $coupon->used_count }}</span>
                                            @if($coupon->usage_limit)
                                                <span class="text-xs text-gray-500 font-bold">من {{ $coupon->usage_limit }}</span>
                                            @else
                                                <span class="text-xs text-green-500 font-bold">لا نهائي</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm font-bold text-gray-600 dark:text-gray-400">
                                        {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : 'لا يوجد' }}
                                    </td>
                                    <td class="p-4 flex justify-center gap-2">
                                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الكوبون؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($coupons->isEmpty())
                    <div class="p-10 text-center text-gray-400">لا يوجد كوبونات مضافة بعد.</div>
                @endif
                <div class="p-4 border-t dark:border-gray-700">
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection