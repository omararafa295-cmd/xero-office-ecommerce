<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Mail\OrderShippedMail;
use App\Models\Coupon;

class AdminController extends Controller
{
   
public function index(Request $request)
{
    $filter = $request->filter ?? 'all';

    $startDate = match($filter) {
        'today' => Carbon::today(),
        'week' => Carbon::now()->startOfWeek(),
        'month' => Carbon::now()->startOfMonth(),
        'year' => Carbon::now()->startOfYear(),
        default => null,
    };

    // الإحصائيات العلوية
    $total_products = Product::count();
    $total_orders = Order::where('status', '!=', 'cancelled')
        ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
        ->count();
    $total_customers = User::where('is_admin', false)->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))->count();
    $total_sales = Order::whereIn('status', ['shipped', 'delivered'])
        ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
        ->sum('total_amount');

    $recent_orders = Order::where('status', '!=', 'cancelled')->latest()->take(5)->get();
    $best_sellers = Product::whereHas('orderItems')
        ->withCount(['orderItems as total_sold' => function($query) {
            $query->select(DB::raw('sum(quantity)'));
        }])
        ->orderByDesc('total_sold')
        ->take(4)
        ->get();

    // الشارت الديناميكي
    $chartDates = [];
    $chartTotals = [];

    if ($filter == 'year' || $filter == 'all') {
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            $chartDates[] = $date->format('M Y');
            $chartTotals[] = Order::whereMonth('created_at', $date->month)
                                  ->whereYear('created_at', $date->year)
                                  ->whereIn('status', ['shipped', 'delivered'])->sum('total_amount');
        }
    } elseif ($filter == 'month') {
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartDates[] = $date->format('d M');
            $chartTotals[] = Order::whereDate('created_at', $date->format('Y-m-d'))
                                  ->whereIn('status', ['shipped', 'delivered'])->sum('total_amount');
        }
    } elseif ($filter == 'today') {
        // لو اختار "اليوم": هنعرض المبيعات كل ساعتين
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subHours($i * 2); 
            $chartDates[] = $date->format('h A'); // مثلا 02 PM
            $start = $date->copy()->startOfHour();
            $end = $date->copy()->addHour()->endOfHour();
            $chartTotals[] = Order::whereBetween('created_at', [$start, $end])
                                  ->whereIn('status', ['shipped', 'delivered'])->sum('total_amount');
        }
    } else {
        // الأسبوع
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartDates[] = $date->format('d M');
            $chartTotals[] = Order::whereDate('created_at', $date->format('Y-m-d'))
                                  ->whereIn('status', ['shipped', 'delivered'])->sum('total_amount');
        }
    }

    return view('admin.dashboard', compact(
        'total_products', 'total_orders', 'total_customers', 'total_sales', 
        'filter', 'recent_orders', 'best_sellers', 'chartDates', 'chartTotals'
    ));
}
    // عرض قائمة العملاء
    public function customers()
    {
        // هنجيب كل المستخدمين اللي مش أدمن (يعني العملاء العاديين)
        $customers = User::where('is_admin', false)->latest()->paginate(20);
        
        return view('admin.customers', compact('customers'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function printInvoice($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);
        return view('admin.orders.invoice', compact('order'));
    }
    public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    
    $request->validate([
        'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
    ]);

    // حفظ الحالة القديمة عشان نعرف هي اتغيرت ولا لأ
    $oldStatus = $order->status;
    $newStatus = $request->status; // ('shipped' مثلاً)

    // تحديث الحالة في الداتا بيز
    $order->status = $newStatus;
    $order->save();

    
    if ($newStatus == 'shipped' && $oldStatus != 'shipped') {
        
        // جلب إيميل العميل (لو مسجله في الطلب، أو من حسابه)
        $customerEmail = $order->customer_email ?? optional($order->user)->email;
        
        if ($customerEmail) {
            $order->loadMissing(['items', 'user']);
            Mail::to($customerEmail)->send(new OrderShippedMail($order));
        }
    }

    return back()->with('success', 'تم تحديث حالة الطلب وإرسال الإشعار للعميل بنجاح!');
}
    // عرض صفحة كل الطلبات
    public function orders()
    {
        // هنجيب كل الطلبات ونرتبها من الأحدث للأقدم، كل 15 طلب في صفحة
        $orders = Order::latest()->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }
    public function exportOrders()
{
    // هينزل ملف إكسيل باسم orders_ بتاريخ النهاردة
    $fileName = 'orders_' . date('Y-m-d') . '.xlsx';
    return Excel::download(new OrdersExport, $fileName);
}
public function lowStock()
{
   
    $low_stock_products = \App\Models\Product::where('stock', '<', 5)->get();
    
    return view('admin.low_stock', compact('low_stock_products'));
}

    /**
     * Display a listing of the coupons.
     */
    public function coupons()
    {
        // Fetch all coupons, paginated for better performance
        $coupons = Coupon::paginate(10); // You can adjust the pagination limit as needed

        return view('admin.coupons', compact('coupons'));
    }
    /**
     * Store a newly created coupon in storage.
     */
    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after_or_equal:today',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code), // Convert code to uppercase for consistency
            'type' => $request->type,
            'value' => $request->value,
            'usage_limit' => $request->usage_limit,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->back()->with('success', 'تم إضافة الكوبون بنجاح! ✅');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroyCoupon(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('success', 'تم حذف الكوبون بنجاح! 🗑️');
    }
        
}

    




