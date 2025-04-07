<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PaintingController;
use App\Http\Controllers\Auth\AdminController;

Route::get('/', function () {
    return "200";
});

// Route login/register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

// Route đăng xuất (bảo vệ bằng auth middleware)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route admin/dashboard với middleware auth và admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');


// Route API với middleware auth cho predict
Route::match(['get', 'post'], '/predict', [PaintingController::class, 'predict'])->middleware('auth');
