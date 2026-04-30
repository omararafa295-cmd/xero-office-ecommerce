<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLang($locale)
    {
        // نتأكد إن اللغة المبعوتة هي عربي أو إنجليزي فقط للحماية
        if (in_array($locale, ['ar', 'en'])) {
            session()->put('locale', $locale);
        }
        
        // نرجع العميل لنفس الصفحة اللي كان فيها
        return redirect()->back();
    }
}