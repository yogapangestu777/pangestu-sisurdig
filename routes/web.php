<?php

use App\Http\Controllers\Admin\OverviewController;
use App\Http\Controllers\Admin\Profile\AccountController;
use App\Http\Controllers\Admin\Profile\BiographyController;
use App\Http\Controllers\Admin\Profile\PasswordController;
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

    Route::prefix('profile')->group(function () {
        Route::resource('account', AccountController::class)
            ->only(['index', 'update'])
            ->names([
                'index' => 'admin.profile.account.index',
                'update' => 'admin.profile.account.update',
            ]);
    });

    Route::prefix('profile')->group(function () {
        Route::resource('biography', BiographyController::class)
            ->only(['index', 'update'])
            ->names([
                'index' => 'admin.profile.biography.index',
                'update' => 'admin.profile.biography.update',
            ]);
    });

    Route::prefix('profile')->group(function () {
        Route::resource('password', PasswordController::class)
            ->only(['index', 'update'])
            ->names([
                'index' => 'admin.profile.password.index',
                'update' => 'admin.profile.password.update',
            ]);
    });
});
