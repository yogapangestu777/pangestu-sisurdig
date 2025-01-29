<?php

use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\Manage\IncomingLetterController;
use App\Http\Controllers\Admin\Manage\OutgoingLetterController;
use App\Http\Controllers\Admin\Manage\UserController;
use App\Http\Controllers\Admin\Master\CategoryController;
use App\Http\Controllers\Admin\Master\PartyController;
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

Route::get('/', [OverviewController::class, 'index'])->name('admin.overview')->middleware(['auth', 'permission:overview.read']);

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth',
], function () {
    // Overview Routes
    Route::middleware('permission:overview.read')->group(function () {
        Route::get('overview', [OverviewController::class, 'index'])->name('admin.overview');
        Route::get('overview/get-data-by-{time}', [OverviewController::class, 'getDataByTime'])->name('admin.overview.getDataByTime');
    });

    // Attachment Upload
    Route::post('upload-attachment/{folder}', [AttachmentController::class, 'upload'])->name('admin.attachment.upload');

    // Profile Routes
    Route::prefix('profile')->group(function () {
        // Account Routes
        Route::get('account', [AccountController::class, 'index'])
            ->name('admin.profile.account.index')
            ->middleware('permission:account.read');

        Route::put('account', [AccountController::class, 'update'])
            ->name('admin.profile.account.update')
            ->middleware('permission:account.update');

        // Biography Routes
        Route::get('biography', [BiographyController::class, 'index'])
            ->name('admin.profile.biography.index')
            ->middleware('permission:biography.read');

        Route::put('biography', [BiographyController::class, 'update'])
            ->name('admin.profile.biography.update')
            ->middleware('permission:biography.update');

        // Password Routes
        Route::get('password', [PasswordController::class, 'index'])
            ->name('admin.profile.password.index')
            ->middleware('permission:password.read');

        Route::put('password', [PasswordController::class, 'update'])
            ->name('admin.profile.password.update')
            ->middleware('permission:password.update');
    });

    // Master Routes
    Route::prefix('master')->group(function () {
        // Categories Routes
        Route::get('categories', [CategoryController::class, 'index'])
            ->name('admin.master.categories.index')
            ->middleware('permission:categories.read');

        Route::post('categories', [CategoryController::class, 'store'])
            ->name('admin.master.categories.store')
            ->middleware('permission:categories.store');

        Route::put('categories/{category}', [CategoryController::class, 'update'])
            ->name('admin.master.categories.update')
            ->middleware('permission:categories.update');

        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
            ->name('admin.master.categories.destroy')
            ->middleware('permission:categories.delete');

        // Parties Routes
        Route::get('parties', [PartyController::class, 'index'])
            ->name('admin.master.parties.index')
            ->middleware('permission:parties.read');

        Route::post('parties', [PartyController::class, 'store'])
            ->name('admin.master.parties.store')
            ->middleware('permission:parties.store');

        Route::put('parties/{party}', [PartyController::class, 'update'])
            ->name('admin.master.parties.update')
            ->middleware('permission:parties.update');

        Route::delete('parties/{party}', [PartyController::class, 'destroy'])
            ->name('admin.master.parties.destroy')
            ->middleware('permission:parties.delete');
    });

    // Manage Routes
    Route::prefix('manage')->group(function () {
        // Users Routes
        Route::get('users', [UserController::class, 'index'])
            ->name('admin.manage.users.index')
            ->middleware('permission:users.read');

        Route::get('users/create', [UserController::class, 'create'])
            ->name('admin.manage.users.create')
            ->middleware('permission:users.create');

        Route::post('users', [UserController::class, 'store'])
            ->name('admin.manage.users.store')
            ->middleware('permission:users.create');

        Route::get('users/{user}/edit', [UserController::class, 'edit'])
            ->name('admin.manage.users.edit')
            ->middleware('permission:users.update');

        Route::put('users/{user}', [UserController::class, 'update'])
            ->name('admin.manage.users.update')
            ->middleware('permission:users.update');

        Route::delete('users/{user}', [UserController::class, 'destroy'])
            ->name('admin.manage.users.destroy')
            ->middleware('permission:users.delete');

        Route::put('users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('admin.manage.users.resetPassword')
            ->middleware('permission:users.resetPassword');

        Route::put('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('admin.manage.users.toggleStatus')
            ->middleware('permission:users.toggelStatus');

        // Incoming Letters Routes
        Route::get('incoming-letters', [IncomingLetterController::class, 'index'])
            ->name('admin.manage.incomingLetters.index')
            ->middleware('permission:incomingLetters.read');

        Route::get('incoming-letters/create', [IncomingLetterController::class, 'create'])
            ->name('admin.manage.incomingLetters.create')
            ->middleware('permission:incomingLetters.create');

        Route::post('incoming-letters', [IncomingLetterController::class, 'store'])
            ->name('admin.manage.incomingLetters.store')
            ->middleware('permission:incomingLetters.create');

        Route::get('incoming-letters/{incomingLetter}', [IncomingLetterController::class, 'show'])
            ->name('admin.manage.incomingLetters.show')
            ->middleware('permission:incomingLetters.show');

        Route::get('incoming-letters/{incomingLetter}/edit', [IncomingLetterController::class, 'edit'])
            ->name('admin.manage.incomingLetters.edit')
            ->middleware('permission:incomingLetters.update');

        Route::put('incoming-letters/{incomingLetter}', [IncomingLetterController::class, 'update'])
            ->name('admin.manage.incomingLetters.update')
            ->middleware('permission:incomingLetters.update');

        Route::delete('incoming-letters/{incomingLetter}', [IncomingLetterController::class, 'destroy'])
            ->name('admin.manage.incomingLetters.destroy')
            ->middleware('permission:incomingLetters.delete');

        Route::get('incoming-letters/{incomingLetter}/download', [IncomingLetterController::class, 'download'])
            ->name('admin.manage.incomingLetters.download')
            ->middleware('permission:incomingLetters.download');

        // Outgoing Letters Routes
        Route::get('outgoing-letters', [OutgoingLetterController::class, 'index'])
            ->name('admin.manage.outgoingLetters.index')
            ->middleware('permission:outgoingLetters.read');

        Route::get('outgoing-letters/create', [OutgoingLetterController::class, 'create'])
            ->name('admin.manage.outgoingLetters.create')
            ->middleware('permission:outgoingLetters.create');

        Route::post('outgoing-letters', [OutgoingLetterController::class, 'store'])
            ->name('admin.manage.outgoingLetters.store')
            ->middleware('permission:outgoingLetters.create');

        Route::get('outgoing-letters/{outgoingLetter}', [OutgoingLetterController::class, 'show'])
            ->name('admin.manage.outgoingLetters.show')
            ->middleware('permission:outgoingLetters.show');

        Route::get('outgoing-letters/{outgoingLetter}/edit', [OutgoingLetterController::class, 'edit'])
            ->name('admin.manage.outgoingLetters.edit')
            ->middleware('permission:outgoingLetters.update');

        Route::put('outgoing-letters/{outgoingLetter}', [OutgoingLetterController::class, 'update'])
            ->name('admin.manage.outgoingLetters.update')
            ->middleware('permission:outgoingLetters.update');

        Route::delete('outgoing-letters/{outgoingLetter}', [OutgoingLetterController::class, 'destroy'])
            ->name('admin.manage.outgoingLetters.destroy')
            ->middleware('permission:outgoingLetters.delete');

        Route::get('outgoing-letters/{outgoingLetter}/download', [OutgoingLetterController::class, 'download'])
            ->name('admin.manage.outgoingLetters.download')
            ->middleware('permission:outgoingLetters.download');
    });

    // Settings Routes
    Route::prefix('setting')->group(function () {
        Route::get('role-permissions', [RolePermissionController::class, 'index'])
            ->name('admin.setting.rolePermissions.index')
            ->middleware('role:Admin');

        Route::post('role-permissions', [RolePermissionController::class, 'store'])
            ->name('admin.setting.rolePermissions.store')
            ->middleware('role:Admin');

        Route::put('role-permissions/{rolePermission}', [RolePermissionController::class, 'update'])
            ->name('admin.setting.rolePermissions.update')
            ->middleware('role:Admin');

        Route::delete('role-permissions/{rolePermission}', [RolePermissionController::class, 'destroy'])
            ->name('admin.setting.rolePermissions.destroy')
            ->middleware('role:Admin');
    });
});
