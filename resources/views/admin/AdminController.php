<?php

namespace App\Http\Controllers;

use App\Models\Coupon; // Assuming you have a Coupon model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the coupons.
     */
    public function coupons()
    {
        // Fetch all coupons, paginated for better performance
        $coupons = Coupon::paginate(10); // You can adjust the pagination limit as needed

        return view('admin.coupons', compact('coupons'));
    }
}