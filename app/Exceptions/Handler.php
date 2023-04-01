<?php
namespace App\Exceptions;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Auth;
class Handler extends ExceptionHandler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
    if ($request->expectsJson()) {
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
    if ($request->is('employer') || $request->is('employer/*')) {
        return redirect()->guest('/login/employer');
    }
    if ($request->is('employee') || $request->is('employee/*')) {
    return redirect()->guest('/login/employee');
    }
        return redirect()->guest(route('login'));
    }
}