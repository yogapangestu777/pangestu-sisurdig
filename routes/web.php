<?php

use App\Http\Controllers\Admin\OverviewController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'index'])->name('login');
        Route::post('login', [LoginController::class, 'authenticate'])->name('login.post');
    });
    Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth',
], function () {
    Route::get('overview', [OverviewController::class, 'index'])->name('admin.overview');
});
