<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Tahoma, Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 20px; direction: rtl; text-align: right; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eeeeee; }
        .header { background-color: #111827; padding: 30px 20px; text-align: center; border-bottom: 4px solid #dc2626; }
        .header h1 { color: #ffffff; margin: 0; font-size: 28px; }
        .header h1 span { color: #dc2626; }
        .content { padding: 30px; color: #374151; line-height: 1.6; }
        .order-id { background-color: #fef2f2; color: #dc2626; padding: 10px 15px; border-radius: 8px; font-weight: bold; font-size: 18px; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f3f4f6; padding: 12px; text-align: right; font-size: 14px; color: #4b5563; }
        td { padding: 12px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .total-row { font-weight: bold; background-color: #f9fafb; }
        .total-price { color: #dc2626; font-size: 18px; }
        .footer { text-align: center; padding: 20px; background-color: #f9fafb; color: #6b7280; font-size: 12px; border-top: 1px solid #eeeeee; }
        .btn { display: inline-block; background-color: #dc2626; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>XERO <span>OFFICE</span></h1>
        </div>
        
        <div class="content">
            <h2>مرحباً {{ $order->customer_name }}،</h2>
            <p>شكراً لتسوقك من Xero Office. يسعدنا إبلاغك أنه تم استلام طلبك بنجاح وجاري العمل على تجهيزه!</p>
            
            <div class="order-id">
                رقم الطلب: #{{ $order->id }}
            </div>

            <h3>ملخص الطلب:</h3>
            <table>
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name_ar ?? $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 2) }} ج.م</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">الإجمالي المطلوب الدفع (عند الاستلام):</td>
                        <td class="total-price">{{ number_format($order->total_amount, 2) }} ج.م</td>
                    </tr>
                </tbody>
            </table>

            <div style="text-align: center;">
                <a href="{{ route('my.orders') }}" class="btn">متابعة حالة الطلب</a>
            </div>
        </div>

        <div class="footer">
            <p>هذه رسالة تلقائية من نظام Xero Office. يرجى عدم الرد على هذا البريد.</p>
            <p>الزقازيق، مصر - 14 شارع جوده عاشور</p>
        </div>
    </div>
</body>
</html>