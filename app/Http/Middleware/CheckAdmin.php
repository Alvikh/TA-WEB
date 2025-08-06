<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
   public function handle($request, Closure $next)
{
    // Jika mencoba akses login, biarkan lewat
    if ($request->routeIs('login')) {
        return $next($request);
    }

    if (!Auth::check()) {
        return redirect()->route('login.page')->with('error', 'Silakan login terlebih dahulu');
    }

    $user = Auth::user();
    if (!in_array($user->role, ['admin', 'super_admin'])) {
        Auth::logout(); // Logout user yang tidak authorized
        return redirect()->route('login.page')->with('error', 'Anda tidak memiliki akses');
    }

    return $next($request);
}
}