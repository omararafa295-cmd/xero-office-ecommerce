@extends('layouts.admin')
@section('title', 'إدارة الشحن')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-6 font-bold border border-green-200">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- فورم الإضافة -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-black mb-6 dark:text-white text-red-600">إضافة محافظة جديدة</h2>
                <form action="{{ route('governorates.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">اسم المحافظة (بالعربي)</label>
                        <input type="text" name="name_ar" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl outline-none focus:ring-2 focus:ring-red-500 dark:text-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">اسم المحافظة (EN)</label>
                        <input type="text" name="name_en" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl outline-none focus:ring-2 focus:ring-red-500 dark:text-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">سعر الشحن (ج.م)</label>
                        <input type="number" step="0.01" name="shipping_cost" required class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl outline-none focus:ring-2 focus:ring-red-500 dark:text-white transition-all">
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3 rounded-xl transition shadow-md">إضافة المحافظة</button>
                </form>
            </div>
        </div>

        <!-- قائمة المحافظات -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <table class="w-full text-right">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="p-4 font-black">المحافظة</th>
                            <th class="p-4 font-black">سعر الشحن</th>
                            <th class="p-4 font-black text-center">العمليات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @foreach($governorates as $gov)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="p-4">
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $gov->name_ar }}</p>
                                    <p class="text-xs text-gray-400 font-bold uppercase">{{ $gov->name_en }}</p>
                                </td>
                                <td class="p-4 font-black text-red-600">{{ number_format($gov->shipping_cost, 2) }} ج.م</td>
                                <td class="p-4 flex justify-center gap-2">
                                    <a href="{{ route('governorates.edit', $gov->id) }}" class="p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('governorates.destroy', $gov->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
                @if($governorates->isEmpty())
                    <div class="p-10 text-center text-gray-400">لا يوجد محافظات مضافة بعد.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
