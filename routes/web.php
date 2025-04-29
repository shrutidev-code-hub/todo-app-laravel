<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;


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


// Auth Routes
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Task Routes
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('store');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('complete');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('destroy');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('update');
    Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('reorder');



});
Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');
