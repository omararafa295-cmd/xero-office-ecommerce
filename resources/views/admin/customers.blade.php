@extends('layouts.admin')
@section('title', 'إدارة العملاء ')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-8 transition-colors">قاعدة بيانات العملاء</h1>

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/30 text-sm">
                    <tr>
                        <th class="p-5 text-gray-500 font-bold">#</th>
                        <th class="p-5 text-gray-500 font-bold">اسم العميل</th>
                        <th class="p-5 text-gray-500 font-bold">البريد الإلكتروني</th>
                        <th class="p-5 text-gray-500 font-bold text-center">تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="p-5 font-bold text-gray-500">{{ $loop->iteration }}</td>
                        <td class="p-5 font-black text-gray-900 dark:text-white flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center font-bold">
                                {{ mb_substr($customer->name, 0, 1) }}
                            </div>
                            {{ $customer->name }}
                        </td>
                        <td class="p-5 text-gray-600 dark:text-gray-400 font-bold" dir="ltr">{{ $customer->email }}</td>
                        <td class="p-5 text-center text-gray-500 dark:text-gray-400 font-bold">
                            {{ $customer->created_at->format('Y-m-d') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-gray-500 font-bold text-lg">لا يوجد عملاء مسجلين حتى الآن.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection