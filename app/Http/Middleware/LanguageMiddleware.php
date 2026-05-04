<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // تغيير لغة التطبيق لكي تتناسب مع القيمة الموجودة بالجلسة
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        
        return $next($request);
    }
}