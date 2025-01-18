<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function index(): View
    {
        return view('pages.auth.login', [
            'pageTitle' => 'Masuk Akun',
        ]);
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $loginAttempt = $this->authService->loginAttempt($validatedData);
        notify()->{$loginAttempt['notifyType']}($loginAttempt['message'], $loginAttempt['notifyTitle']);

        if ($loginAttempt['status']) {
            return redirect()->route('admin.overview');
        }

        return redirect()->route('login');
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logout();
        notify()->success('Anda telah keluar dari akun.', 'Berhasil');

        return redirect()->route('login');
    }
}
