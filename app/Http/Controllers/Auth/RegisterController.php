<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Employer;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
/*
UECS3294 ADVANCED WEB APPLICATION DEVELOPMENT
|--------------------------------------------------------------------------
| Register Controller
|--------------------------------------------------------------------------
|
| This controller handles the registration of new users as well as their
| validation and creation. By default this controller uses a trait to
| provide this functionality without requiring any additional code.
|
*/
use RegistersUsers;
/**
* Where to redirect users after registration.
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
    $this->middleware('guest');
    $this->middleware('guest:employer');
    $this->middleware('guest:employee');
}
/**
* Get a validator for an incoming registration request.
*
* @param array $data
* @return \Illuminate\Contracts\Validation\Validator
*/
protected function validator(array $data)
{
return Validator::make($data, [
'name' => ['required', 'string', 'max:50'],
'email' => ['required', 'string', 'email', 'max:30', 'unique:users'],
'password' => ['required', 'string', 'min:6', 'confirmed'],
]);
}
/**
* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
*/
public function employerRegisterForm()
{
    return view('auth.register', ['url' => 'employer']);
}

/**
* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
*/

public function employeeRegisterForm()
{
return view('auth.register', ['url' => 'employee']);
}

/**
* @param array $data
*
* @return mixed
*/
protected function create(array $data)
{
    return User::create([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => Hash::make($data['password']),
    ]);
}
/**
* @param Request $request
*
* @return \Illuminate\Http\RedirectResponse
*/
protected function createEmployer(Request $request)
{
    $this->validator($request->all())->validate();
    $employer = new Employer;
    $employer -> name = $request -> name;
    $employer -> email = $request -> email;
    $employer -> password = Hash::make($request -> password);
    $employer -> role = "employer";
    $employer->save();


    return redirect()->intended('login/employer');
}
/**
* @param Request $request
*
* @return \Illuminate\Http\RedirectResponse
*/
protected function createEmployee(Request $request)
{
    $this->validator($request->all())->validate();
    $employee = new Employee;
    $employee -> name = $request -> name;
    $employee -> email = $request -> email;
    $employee -> password = Hash::make($request -> password);
    $employee -> role = "employee";
    $employee->save();
    
    return redirect()->intended('login/employee');
}
}