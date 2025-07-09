<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'super admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai Super Admin');
    }
}