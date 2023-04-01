<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Login 
Auth::routes();
Route::redirect('/login','/login/employee');
Route::redirect('/','/login/employee');
Route::redirect('/register','/register/employee');
Route::get('/login/employer', [LoginController::class, 'employerLoginForm']);
Route::get('/login/employee', [LoginController::class,'employeeLoginForm']);
Route::get('/register/employer', [RegisterController::class,'employerRegisterForm']);
Route::get('/register/employee', [RegisterController::class,'employeeRegisterForm']);
Route::post('/login/employer', [LoginController::class,'employerLogin']);
Route::post('/login/employee', [LoginController::class,'employeeLogin']);
Route::post('/register/employer', [RegisterController::class,'createEmployer']);
Route::post('/register/employee', [RegisterController::class,'createEmployee']);
Route::get('logout', [LoginController::class,'logout']);





// home
Route::group(['middleware' => 'auth:employer'], function () {
    Route::get('upload/{id}', [TaskController::class, 'upload']);
    Route::post('upload/{id}', [TaskController::class, 'store']);
    Route::get('download/{id}', [TaskController::class, 'download']);

    Route::get('employer', [TaskController::class, 'home']);

    Route::view('create','createTask');
    Route::post('create/task',[TaskController::class,'createTask']);
    Route::get('edit/task/{id}',[TaskController::class,'editTask']);
    Route::post('save/task/{id}',[TaskController::class,'saveTask']);
    Route::get('delete/task/{id}',[TaskController::class,'deleteTask']);
});

Route::group(['middleware'=>'auth:employee'], function(){
    Route::get('employee', [TaskController::class, 'viewTask']);
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
