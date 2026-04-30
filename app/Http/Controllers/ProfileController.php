<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // عرض صفحة التعديل
    public function edit()
    {
        return view('profile');
    }

    // حفظ التعديلات
    public function update(Request $request)
    {
        $user = auth()->user();

        // 1. التحقق من البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // 2. تحديث الاسم والإيميل
        $user->name = $request->name;
        $user->email = $request->email;

        // 3. تحديث الباسورد لو العميل كتب واحد جديد
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->back()->with('success', 'تم تحديث بيانات حسابك بنجاح! ✅');
    }
}