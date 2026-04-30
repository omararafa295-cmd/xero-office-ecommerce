<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // عرض طلبات المستخدم الحالي
    public function myOrders()
    {
        // بنجيب الأوردرات الخاصة بإيميل اليوزر المسجل دخوله
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        $orders = Order::where('customer_email', $user->email)->latest()->get();
        return view('my_orders', compact('orders'));
    }
    public function trackForm() {
    return view('order-track');
}

public function trackResult(Request $request) {
    $request->validate([
        'order_id' => 'required',
        'phone' => 'required'
    ]);

    $order = \App\Models\Order::where('id', $request->order_id)
                 ->where('customer_phone', $request->phone) 
                 ->first();

    if (!$order) {
        return back()->with('error', 'عذراً، لم نجد طلب بهذه البيانات. تأكد من الأرقام المحفوظة.');
    }

    return view('order-track', compact('order'));
}
}