<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    public function index()
    {
        $governorates = Governorate::latest()->paginate(10); // تم التعديل هنا لاستخدام paginate
        return view('admin.governorates.index', compact('governorates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        Governorate::create($request->all());

        return redirect()->back()->with('success', 'تم إضافة المحافظة بنجاح! ✅');
    }

    public function edit(Governorate $governorate)
    {
        return view('admin.governorates.edit', compact('governorate'));
    }

    public function update(Request $request, Governorate $governorate)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $governorate->update($request->all());

        return redirect()->route('governorates.index')->with('success', 'تم تحديث البيانات بنجاح! ✅');
    }

    public function destroy(Governorate $governorate)
    {
        $governorate->delete();
        return redirect()->back()->with('success', 'تم حذف المحافظة بنجاح! 🗑️');
    }
}