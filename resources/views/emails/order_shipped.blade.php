<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Tahoma', Arial, sans-serif; background-color: #f9fafb; padding: 20px; }
        .email-container { max-w-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #dc2626; padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; }
        .content { padding: 30px; color: #374151; line-height: 1.6; }
        .order-box { background-color: #f3f4f6; border-radius: 8px; padding: 15px; margin: 20px 0; text-align: center; }
        .order-box h2 { margin: 0; color: #dc2626; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #9ca3af; }
        .btn { display: inline-block; background-color: #111827; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="public/images/logo.png" alt="Xero Office" style="max-height: 50px; margin-bottom: 15px;">
            <h1>طلبك في الطريق إليك! 🚚</h1>
        </div>

        <div class="content">
            <p>أهلاً بك يا <strong>{{ $order->customer_name ?? optional($order->user)->name }}</strong>،</p>
            <p>خبر سعيد! لقد تم تسليم طلبك إلى شركة الشحن، وهو الآن في طريقه إليك. يرجى إبقاء هاتفك المحمول متاحاً ليتواصل معك المندوب قريباً.</p>
            
            <div class="order-box">
                <p>رقم الطلب</p>
                <h2>#{{ $order->id }}</h2>
                <p style="margin-top: 10px;">الإجمالي: <strong>{{ $order->total_amount }} ج.م</strong></p>
            </div>

            <p>شكراً لتسوقك من <strong>Xero Office</strong>، نتمنى لك تجربة استخدام رائعة لمنتجاتنا!</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="btn">زيارة المتجر</a>
            </div>
        </div>

        <div class="footer">
            <p>هذه رسالة تلقائية، يرجى عدم الرد عليها.</p>
            <p>© 2026 Xero Office. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</body>
</html>