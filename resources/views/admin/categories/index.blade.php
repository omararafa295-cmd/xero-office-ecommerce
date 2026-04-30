@extends('layouts.admin')
@section('title', 'إدارة الأقسام ')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-8 transition-colors">إدارة الأقسام </h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 p-4 rounded-2xl mb-6 font-bold border border-green-200 dark:border-green-800 flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-xl"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 h-fit bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
            <h2 class="text-xl font-black mb-6 text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-folder-plus text-red-600"></i> إضافة قسم جديد
            </h2>
            
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">الاسم بالعربي</label>
                    <input type="text" name="name_ar" required placeholder="مثال: طابعات ليزر"
                        class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">الاسم بالإنجليزي (للرابط)</label>
                    <input type="text" name="name_en" required placeholder="مثال: laser-printers"
                        class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition-all text-left" dir="ltr">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">صورة القسم (3D Icon)</label>
                    <input type="file" name="image" accept="image/*" required
                        class="w-full p-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-red-500 text-gray-900 dark:text-white outline-none transition-all text-sm">
                </div>
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-2xl transition-all shadow-md hover:shadow-lg hover:-translate-y-1 mt-2 flex items-center justify-center gap-2">
                    حفظ القسم <i class="fa-solid fa-check"></i>
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center gap-2">
                <h3 class="text-xl font-black text-gray-900 dark:text-white"><i class="fa-solid fa-layer-group text-red-600"></i> الأقسام المسجلة</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-gray-50 dark:bg-gray-900/30 text-sm">
                        <tr>
                            <th class="p-5 text-gray-500 font-bold">الصورة</th>
                            <th class="p-5 text-gray-500 font-bold">الاسم بالعربي</th>
                            <th class="p-5 text-gray-500 font-bold text-left">الاسم بالإنجليزي</th>
                            <th class="p-5 text-gray-500 font-bold text-center">العمليات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="p-5">
                                <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/logo.png') }}" class="w-12 h-12 object-contain bg-gray-100 dark:bg-gray-900 rounded-xl p-1 border border-gray-200 dark:border-gray-700">
                            </td>
                            <td class="p-5 font-black text-gray-900 dark:text-white">{{ $category->name_ar }}</td>
                            <td class="p-5 text-gray-600 dark:text-gray-400 font-bold text-left" dir="ltr">{{ $category->name_en }}</td>
                            <td class="p-5 text-center">
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white dark:bg-red-900/30 dark:hover:bg-red-600 rounded-xl transition-all shadow-sm flex items-center justify-center" onclick="return confirm('متأكد إنك عايز تمسح القسم ده؟')" title="مسح">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-500 font-bold text-lg">لا توجد أقسام مضافة حالياً.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection