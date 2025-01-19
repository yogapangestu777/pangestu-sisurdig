<?php

use App\Http\Controllers\Admin\Manage\UserController;
use App\Http\Controllers\Admin\Master\CategoryController;
use App\Http\Controllers\Admin\OverviewController;
use App\Http\Controllers\Admin\Profile\AccountController;
use App\Http\Controllers\Admin\Profile\BiographyController;
use App\Http\Controllers\Admin\Profile\PasswordController;
use App\Http\Controllers\Admin\Setting\RolePermissionController;
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

        Route::resource('biography', BiographyController::class)
            ->only(['index', 'update'])
            ->names([
                'index' => 'admin.profile.biography.index',
                'update' => 'admin.profile.biography.update',
            ]);

        Route::resource('password', PasswordController::class)
            ->only(['index', 'update'])
            ->names([
                'index' => 'admin.profile.password.index',
                'update' => 'admin.profile.password.update',
            ]);
    });

    Route::prefix('master')->group(function () {
        Route::resource('categories', CategoryController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'admin.master.categories.index',
                'store' => 'admin.master.categories.store',
                'update' => 'admin.master.categories.update',
                'destroy' => 'admin.master.categories.destroy',
            ]);
    });

    Route::prefix('manage')->group(function () {
        Route::resource('users', UserController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.manage.users.index',
                'create' => 'admin.manage.users.create',
                'store' => 'admin.manage.users.store',
                'edit' => 'admin.manage.users.edit',
                'update' => 'admin.manage.users.update',
                'destroy' => 'admin.manage.users.destroy',
            ]);
        Route::put('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.manage.users.resetPassword');
        Route::put('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.manage.users.toggleStatus');
    });

    Route::prefix('setting')->group(function () {
        Route::resource('role-permissions', RolePermissionController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'admin.setting.rolePermissions.index',
                'store' => 'admin.setting.rolePermissions.store',
                'update' => 'admin.setting.rolePermissions.update',
                'destroy' => 'admin.setting.rolePermissions.destroy',
            ]);
    });
});
