<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = $request->user();
            if ($user->role == 1) {
                return $next($request);
            } else if ($user->role == 2) {
                return redirect('/admin');
            } else {
                return redirect('/');
            }
            // kiểm tra cho bay về router admin, xong thì xem router admin có check quyền auth admin hay ko thì chỗ này ko cần else if nữa
        }
    }
}
