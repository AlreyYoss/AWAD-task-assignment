<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
/*
|--------------------------------------------------------------------------
| Login Controller
|--------------------------------------------------------------------------
|
| This controller handles authenticating users for the application and
| redirecting them to your home screen. The controller uses a trait
| to conveniently provide its functionality to your applications.
|
*/
use AuthenticatesUsers;
/**
* Where to redirect users after login.
*
* @var string
*/
protected $redirectTo = '/home';
/**
* Create a new controller instance.
*
* @return void
*/
public function __construct()
{   
    $this->middleware('guest')->except('logout');
    $this->middleware('guest:employer')->except('logout');
    $this->middleware('guest:employee')->except('logout');
}

public function employerLoginForm()
{
    return view('auth.login', ['url' => 'employer']);
}
public function employerLogin(Request $request)
{
    $request->validate(['email' => 'required|email', 'password' => 'required|min:6']);
    if (Auth::guard('employer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
        $request->session()->put('employerEmail', $request->email);
        return redirect()->intended('/home/employer');
    }
    //dd($request->only('email', 'password','remember'));
    return back()->withInput($request->only('email', 'remember'));
}

public function employeeLoginForm()
{
    return view('auth.login', ['url' => 'employee']);
}
public function employeeLogin(Request $request)
{
    $request->validate(['email' => 'required|email', 'password' => 'required|min:6']);
    if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
        $request->session()->put('employeeEmail', $request->email);

        return redirect()->intended('/home/employee');
    }
    //dd($request->only('email', 'password','remember'));
    return back()->withInput($request->only('email', 'remember'));
}
}