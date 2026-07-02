<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PaintingController;

Route::post('/login', [LoginController::class, 'apiLogin']);
Route::post('/register', [LoginController::class, 'apiRegister']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'apiLogout']);
    Route::post('/predict', [PaintingController::class, 'apiPredict']);
    Route::get('/predictions', [PaintingController::class, 'apiGetPredictions']);
    Route::get('/predictions/redirect-detail', [PaintingController::class, 'apiRedirectToDetail']);
    Route::get('/predictions/detail/{type}/{id}', [PaintingController::class, 'apiViewDetail']);
});
