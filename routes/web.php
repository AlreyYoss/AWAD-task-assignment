<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('home', [TaskController::class, 'home']);
Route::view('create','createTask');
Route::post('create/task',[TaskController::class,'createTask']);
Route::get('edit/task/{id}',[TaskController::class,'editTask']);
Route::post('save/task/{id}',[TaskController::class,'saveTask']);
Route::get('delete/task/{id}',[TaskController::class,'deleteTask']);