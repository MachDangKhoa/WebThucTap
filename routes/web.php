<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PaintingController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\ApiUsageController;
use App\Http\Controllers\Auth\AccountsController;


// Route login/register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

// Route đăng xuất (bảo vệ bằng auth middleware)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route admin/dashboard với middleware auth và admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

// // Route cho API Usage
Route::get('/admin/api', [ApiUsageController::class, 'showApiUsage'])->name('api');
Route::get('/admin/api_statistics', [ApiUsageController::class, 'getApiUsage'])->name('api_statistics');
Route::get('/admin/top-users', [ApiUsageController::class, 'getTopUsers'])->name('api.top-users');

// Route để hiển thị danh sách tài khoản
Route::get('/admin/accounts', [AccountsController::class, 'index'])->name('accounts.index');

// Route để sửa tài khoản
Route::get('/admin/accounts/edit/{id}', [AccountsController::class, 'edit'])->name('accounts.edit');
Route::put('/admin/accounts/{id}', [AccountsController::class, 'update'])->name('accounts.update');

// Route để xóa tài khoản
Route::delete('/admin/accounts/{id}', [AccountsController::class, 'destroy'])->name('accounts.destroy');

// Route API với middleware auth cho predict
Route::match(['get', 'post'], '/predict', [PaintingController::class, 'predict'])->middleware('auth');
