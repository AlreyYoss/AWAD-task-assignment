<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
    if ($guard == "employer" && Auth::guard($guard)->check()) {
        return redirect('/employer');
    }
    if ($guard == "employee" && Auth::guard($guard)->check()) {
        return redirect('/employee');
    }
    if (Auth::guard($guard)->check()) {
        return redirect('/home');
    }
        return $next($request);
    }
}