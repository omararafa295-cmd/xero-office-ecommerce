@extends('layouts.admin')
@section('title', 'إدارة المنتجات - Xero Office')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-black text-gray-900 dark:text-white transition-colors">المنتجات المعروضة</h1>
        
        <a href="{{ route('products.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-md transition flex items-center gap-2">
            <span class="text-xl leading-none">+</span> إضافة منتج
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 p-4 rounded-xl mb-6 font-bold border border-green-200 dark:border-green-800">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/50 text-sm">
                    <tr>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold">الصورة</th>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold">الاسم</th>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold">السعر</th>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold text-center">المخزون</th>
                        <th class="p-4 text-gray-600 dark:text-gray-400 font-bold text-center">العمليات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="p-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 object-cover rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                            @else
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-xs text-gray-500 font-bold border border-gray-200 dark:border-gray-600">لا صورة</div>
                            @endif
                        </td>
                        
                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $product->name_ar }}</td>
                        
                       <td class="p-4">
    <div class="flex flex-col">
        <span class="font-black text-red-600">{{ $product->price }} ج.م</span>
        @if($product->old_price)
            <span class="text-xs text-gray-400 line-through">{{ $product->old_price }} ج.م</span>
        @endif
    </div>
</td>
                        <td class="p-4 text-center font-bold {{ $product->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $product->stock }}
                        </td>
                        
                        <td class="p-4 text-center space-x-2 space-x-reverse">
                            <a href="{{ route('products.edit', $product->id) }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-yellow-900 px-4 py-1.5 rounded-lg font-bold text-sm transition shadow-sm">تعديل</a>
                            
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded-lg font-bold text-sm transition shadow-sm" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟ لا يمكن التراجع عن هذه الخطوة.')">مسح</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500 dark:text-gray-400 font-bold text-lg">
                            لا توجد منتجات مضافة حتى الآن. ابدأ بإضافة منتجك الأول!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-8">
        {{ $products->links() ?? '' }}
    </div>

</div>
@endsection