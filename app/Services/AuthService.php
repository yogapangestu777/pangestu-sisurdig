<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function loginAttempt(array $credential): array
    {
        $identifier = filter_var($credential['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([
            $identifier => $credential['login'],
            'password' => $credential['password'],
        ])) {
            $user = auth()->user();
            if ($user->is_active === '1') {
                return [
                    'status' => true,
                    'message' => 'Selamat datang '.$user->biography->full_name,
                    'notifyType' => 'success',
                    'notifyTitle' => 'Berhasil',
                ];
            } else {
                Auth::logout();

                return [
                    'status' => false,
                    'message' => 'Akun Anda saat ini tidak aktif. Silakan hubungi administrator untuk informasi lebih lanjut.',
                    'notifyType' => 'info',
                    'notifyTitle' => 'Pemberitahuan',
                ];
            }
        }

        return [
            'status' => false,
            'message' => 'Email, nama pengguna atau kata sandi salah',
            'notifyType' => 'warning',
            'notifyTitle' => 'Peringatan',
        ];
    }
}
