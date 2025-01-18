<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\PasswordRequest;
use App\Services\ProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PasswordController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {}

    public function index(): View
    {
        return view('pages.admin.profile.password', [
            'pageTitle' => 'Kata Sandi',
            'pageDescription' => 'Silakan perbarui kata sandi Anda. Informasi ini digunakan sebagai kredensial untuk masuk ke dalam sistem.',
        ]);
    }

    public function update(string $id, PasswordRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->profileService->updatePassword($id, $validatedData);
        notify()->success('Kata sandi berhasil diperbarui.Silakan masuk kembali.', 'Berhasil');

        return redirect()->route('login');
    }
}
