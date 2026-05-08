<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GovernorateController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ReviewController;

Route::middleware('customer')->group(function () {
    // 1. الصفحة الرئيسية
    Route::get('/', [StoreController::class, 'index'])->name('home');
    // صفحة تفاصيل المنتج
    Route::get('/product/{id}', [StoreController::class, 'show'])->name('product.show');
    // مسار البحث
    Route::get('/search', [StoreController::class, 'search'])->name('search');
    // صفحة الشروط والأحكام
    Route::get('/terms', [StoreController::class, 'terms'])->name('terms');
    // مسار اقتراحات البحث اللايف
    Route::get('/search-suggestions', [StoreController::class, 'searchSuggestions'])->name('search.suggestions');
    // مسار عرض منتجات قسم معين
    Route::get('/category/{slug}', [StoreController::class, 'category'])->name('category.show');

    // 2. مسارات السلة (متاحة لأي حد)
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/favorites', [ProductController::class, 'favorites'])->name('favorites.index');
    // صفحة تتبع الطلب (العرض)
    Route::get('/track-order', [OrderController::class, 'trackForm'])->name('order.track.form');
    // استقبال الداتا والبحث عن الطلب
    Route::post('/track-order', [OrderController::class, 'trackResult'])->name('order.track.result');
});
    // 3. مسارات تتطلب تسجيل الدخول (العميل العادي)
Route::middleware(['auth'])->group(function () { // هذا الجروب للمستخدمين المسجلين دخول
    Route::middleware(['customer', 'verified'])->group(function () { // هذا الجروب للعملاء الذين أكدوا بريدهم الإلكتروني
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
        
        Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        // تتبع الطلبات والمفضلة
        Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
        Route::post('/products/{id}/favorite', [ProductController::class, 'toggleFavorite'])->name('products.favorite');
        Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
        
        // مسارات الكوبونات (للعميل)
        Route::post('/coupon/apply', [\App\Http\Controllers\CouponController::class, 'apply'])->name('coupon.apply');
        Route::get('/coupon/remove', [\App\Http\Controllers\CouponController::class, 'remove'])->name('coupon.remove');
    });
});
    Route::get('lang/{locale}', function ($locale) {
    // التأكد إن اللغة المبعوتة هي عربي أو إنجليزي فقط
        if (in_array($locale, ['ar', 'en'])) {
        Session::put('locale', $locale); // حفظ اللغة في الجلسة (Session)
    }
        return redirect()->back(); // إرجاع العميل لنفس الصفحة اللي كان فيها
            })->name('lang.switch');

// 4. مسارات لوحة التحكم (تتطلب دخول + صلاحية أدمن)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // إضافة مسار العملاء
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    // عرض كل الطلبات
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders.index');
    // إدارة الطلبات
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::get('/orders/{id}/print', [AdminController::class, 'printInvoice'])->name('admin.orders.print');
    // مسار تحديث الحالة
    Route::put('/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.update_status');
    
    Route::get('/admin/products/low-stock', [App\Http\Controllers\AdminController::class, 'lowStock'])->name('admin.products.low_stock');
    // إدارة المنتجات
    Route::resource('products', ProductController::class);
    // إدارة الأقسام
    Route::resource('categories', CategoryController::class);
    // إدارة المحافظات وأسعار الشحن
    Route::resource('governorates', GovernorateController::class);
    // مسار تصدير الطلبات لإكسيل
    Route::get('/admin/orders/export', [App\Http\Controllers\AdminController::class, 'exportOrders'])->name('admin.orders.export');
    Route::get('/admin/coupons', [App\Http\Controllers\AdminController::class, 'coupons'])->name('admin.coupons');

    // مسارات إدارة الكوبونات (لوحة التحكم)
    Route::get('/coupons', [App\Http\Controllers\AdminController::class, 'coupons'])->name('admin.coupons');
    Route::post('/coupons', [App\Http\Controllers\AdminController::class, 'storeCoupon'])->name('admin.coupons.store');
    Route::delete('/coupons/{id}', [App\Http\Controllers\AdminController::class, 'destroyCoupon'])->name('admin.coupons.destroy');
    });

// توجيه العميل لجوجل
    Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
    })->name('google.login');

// استقبال بيانات العميل من جوجل بعد ما يوافق
    Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    
    // هل العميل ده متسجل قبل كده؟ لو لأ، اعمله حساب جديد
    $user = User::updateOrCreate(
        ['email' => $googleUser->email],
        [
            'name' => $googleUser->name,
            'google_id' => $googleUser->id,
            'password' => Hash::make(uniqid()) // بنعمل باسورد عشوائي عشان الداتا بيز
        ]
    );
    
    Auth::login($user);
    return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح!');
}); // تم نقل مسار reviews.store إلى جروب verified
    require __DIR__.'/auth.php';
