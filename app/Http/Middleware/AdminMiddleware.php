<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // لو المستخدم مسجل دخول، وحسابه "مدير" -> خليه يمر
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        // لو مش مدير، اطرده على الصفحة الرئيسية مع رسالة خطأ
        return redirect()->route('home')->with('error', 'عفواً، ليس لديك صلاحية للدخول لهذه الصفحة.');
    }
}