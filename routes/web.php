<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PaintingController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\ApiUsageController;
use App\Http\Controllers\Auth\AccountsController;
use App\Http\Controllers\Auth\PaintController;
use App\Http\Controllers\Auth\DashboardController;

// Route login/register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/edit/{id}', [AccountsController::class, 'edit'])->name('account.edit')->middleware('auth');;
Route::put('/dashboard/{id}', [AccountsController::class, 'update'])->name('account.update')->middleware('auth');;

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

// Route đăng xuất (bảo vệ bằng auth middleware)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route admin/dashboard với middleware auth và admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');;

// // Route cho API Usage
Route::get('/admin/api', [ApiUsageController::class, 'showApiUsage'])->name('api');

Route::get('/admin/api/edit_api/{id}', [ApiUsageController::class, 'edit_api'])->name('api.edit_api');
Route::put('/admin/api/update_api/{id}', [ApiUsageController::class, 'update_api'])->name('api.update_api');

Route::delete('/admin/api/{id}', [ApiUsageController::class, 'destroy_api'])->name('api.destroy_api');

Route::get('/admin/api_statistics', [ApiUsageController::class, 'getApiUsage'])->name('api_statistics');
Route::get('/admin/top-users', [ApiUsageController::class, 'getTopUsers'])->name('api.top-users');

// Route để hiển thị danh sách tài khoản
Route::get('/admin/accounts', [AccountsController::class, 'index'])->name('accounts.index');

// Route để sửa tài khoản
Route::get('/admin/accounts/edit/{id}', [AccountsController::class, 'edit'])->name('accounts.edit');
Route::put('/admin/accounts/{id}', [AccountsController::class, 'update'])->name('accounts.update');

// Route để xóa tài khoản
Route::delete('/admin/accounts/{id}', [AccountsController::class, 'destroy'])->name('accounts.destroy');

Route::get('/paintings', [PaintController::class, 'index'])->name('paintings.index');

Route::get('/paintings/edit_db/{id}', [PaintController::class, 'edit_db'])->name('painting.edit_db');
Route::put('/paintings/update_db/{id}', [PaintController::class, 'update_db'])->name('painting_db.update');
Route::delete('/paintings/destroy_db/{id}', [PaintController::class, 'destroy_db'])->name('painting.destroy_db');

Route::get('/paintings/edit_gg/{id}', [PaintController::class, 'edit_google'])->name('painting.edit_gg');
Route::put('/paintinggoogle/update_gg/{id}', [PaintController::class, 'update_google'])->name('painting_gg.update');
Route::delete('/paintings/destroy_gg/{id}', [PaintController::class, 'destroy_google'])->name('painting.destroy_gg');

// Route API với middleware auth cho predict
Route::match(['get', 'post'], '/predict', [PaintingController::class, 'predict'])->middleware('auth')->name('predict');

Route::get('/paintings/redirect-detail', [PaintingController::class, 'redirectToDetail'])->name('paintings.view_detail_redirect');

Route::get('/paintings/select', [PaintingController::class, 'showSelectionForm'])->name('paintings.select');

Route::get('/paintings/detail/{type}/{id}', [PaintingController::class, 'viewDetail'])->name('paintings.view_detail');


