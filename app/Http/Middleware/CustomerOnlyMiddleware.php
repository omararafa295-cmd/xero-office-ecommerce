<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerOnlyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->is_admin) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'تم تحويلك إلى لوحة التحكم لأن هذا القسم مخصص للعملاء فقط.');
        }

        return $next($request);
    }
}
