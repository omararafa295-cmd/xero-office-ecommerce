<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('فاتورة رقم') }} #{{ $order->id }} - Xero Office</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap');

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #e5e7eb;
        }

        .a4-invoice-page {
            width: 210mm;
            min-height: 297mm;
            margin: 40px auto;
            background-color: #ffffff;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            padding: 20mm;
            position: relative;
            overflow: hidden;
        }

        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4 portrait;
                margin: 0mm;
            }

            .a4-invoice-page {
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
                width: 210mm !important;
                min-height: 297mm !important;
                padding: 15mm !important;
            }
        }
    </style>
</head>
<body class="text-gray-900">
    @php
        $subtotal = $order->items->sum(fn ($item) => $item->price * $item->quantity);
        $discountAmount = (float) ($order->discount_amount ?? 0);
        $shippingAmount = max(0, (float) $order->total_amount - max(0, $subtotal - $discountAmount));
    @endphp

    <div class="w-[210mm] mx-auto mt-8 mb-2 flex justify-end no-print">
        <button onclick="window.print()" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-black shadow-lg transition transform hover:-translate-y-0.5 flex items-center gap-2">
            طباعة الفاتورة الرسمية
        </button>
    </div>

    <div class="a4-invoice-page">
        <div class="flex flex-col md:flex-row justify-between items-start border-b-2 border-gray-900 pb-10 mb-10">
            <div>
                <img src="{{ asset('images/logo.png') }}" class="h-20 w-auto mb-4" alt="Xero Office Logo">
                <h2 class="text-2xl font-black tracking-tighter text-red-600">XERO OFFICE</h2>
                <p class="text-gray-500 font-bold text-sm mt-1">حلول الطباعة المتكاملة والأدوات المكتبية</p>
                <p class="text-gray-400 text-xs font-bold mt-2">الزقازيق، الشرقية - 14 شارع جوده عاشور</p>
            </div>

            <div class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }} mt-6 md:mt-0">
                <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter mb-4">{{ __('فاتورة بيع') }}</h1>
                <div class="space-y-1 text-sm font-bold">
                    <p><span class="text-gray-400">{{ __('رقم الفاتورة:') }}</span> #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p><span class="text-gray-400">{{ __('تاريخ الطلب:') }}</span> {{ $order->created_at->format('Y/m/d') }}</p>
                    <p><span class="text-gray-400">{{ __('طريقة الدفع:') }}</span> {{ $order->payment_method_label }}</p>
                    @if($order->wallet_number)
                        <p><span class="text-gray-400">{{ __('رقم المحفظة:') }}</span> {{ $order->wallet_number }}</p>
                    @endif
                    @if($order->coupon_code)
                        <p><span class="text-gray-400">{{ __('الكوبون المستخدم:') }}</span> <span class="text-green-600">{{ $order->coupon_code }}</span></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-10 mb-12">
            <div>
                <h3 class="text-xs font-black text-red-600 uppercase tracking-widest mb-3">{{ __('العميل') }}</h3>
                <p class="text-xl font-black text-gray-900">{{ $order->customer_name }}</p>
                <p class="text-gray-600 font-bold mt-1" dir="ltr">{{ $order->customer_phone }}</p>
                @if($order->customer_email)
                    <p class="text-gray-500 text-sm mt-1" dir="ltr">{{ $order->customer_email }}</p>
                @endif
            </div>
            <div class="{{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                <h3 class="text-xs font-black text-red-600 uppercase tracking-widest mb-3">{{ __('عنوان الشحن') }}</h3>
                <p class="text-gray-700 font-bold leading-relaxed max-w-xs {{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }}">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <div class="mb-12">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-gray-100 text-gray-400 text-xs font-black uppercase tracking-widest">
                        <th class="py-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">{{ __('المنتج') }}</th>
                        <th class="py-4 text-center">{{ __('السعر') }}</th>
                        <th class="py-4 text-center">{{ __('الكمية') }}</th>
                        <th class="py-4 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">{{ __('الإجمالي') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-6 font-black text-gray-900 text-lg">{{ $item->product_name }}</td>
                            <td class="py-6 text-center font-bold text-gray-600">{{ number_format($item->price, 2) }}</td>
                            <td class="py-6 text-center font-black text-gray-900">{{ $item->quantity }}</td>
                            <td class="py-6 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }} font-black text-gray-900 text-lg">
                                {{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end border-t-2 border-gray-900 pt-8">
            <div class="w-72 space-y-4">
                <div class="flex justify-between text-gray-500 font-bold">
                    <span>{{ __('المجموع الفرعي') }}</span>
                    <span>{{ number_format($subtotal, 2) }}</span>
                </div>

                @if($order->coupon_code)
                    <div class="flex justify-between text-gray-500 font-bold">
                        <span>{{ __('الكوبون') }}</span>
                        <span class="text-green-600">{{ $order->coupon_code }}</span>
                    </div>
                @endif

                @if($discountAmount > 0)
                    <div class="flex justify-between text-green-600 font-bold">
                        <span>{{ __('الخصم') }}</span>
                        <span>-{{ number_format($discountAmount, 2) }}</span>
                    </div>
                @endif

                <div class="flex justify-between text-gray-500 font-bold border-b border-gray-100 pb-4">
                    <span>{{ __('مصاريف الشحن') }}</span>
                    <span>{{ number_format($shippingAmount, 2) }}</span>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <span class="text-sm font-black uppercase tracking-widest text-red-600">{{ __('الإجمالي الكلي') }}</span>
                    <span class="text-3xl font-black text-gray-900">{{ number_format($order->total_amount, 2) }} <span class="text-sm">{{ __('ج.م') }}</span></span>
                </div>
            </div>
        </div>

        <div class="absolute bottom-[20mm] left-0 w-full px-[20mm]">
            <div class="pt-8 border-t border-gray-100 text-center relative">
                <div class="absolute -top-px left-1/2 -translate-x-1/2 w-20 h-1 bg-red-600"></div>
                <p class="text-gray-900 font-black text-sm mb-2">{{ __('شكراً لثقتكم في Xero Office') }}</p>
                <p class="text-gray-400 text-[10px] font-bold leading-relaxed max-w-md mx-auto">
                    هذه الفاتورة صدرت إلكترونياً وهي وثيقة رسمية. يرجى الاحتفاظ بها للرجوع إليها عند الحاجة.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
