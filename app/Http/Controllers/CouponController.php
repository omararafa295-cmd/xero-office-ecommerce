<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->with('error', 'كود الخصم غير صالح أو منتهي الصلاحية.');
        }

        // حفظ الكوبون في الـ Session لاستخدامه لاحقاً في الـ Checkout
        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);

        return back()->with('success', 'تم تطبيق كود الخصم بنجاح!');
    }

    public function remove()
    {
        session()->forget('coupon');
        return back()->with('success', 'تم إزالة كود الخصم.');
    }
}
