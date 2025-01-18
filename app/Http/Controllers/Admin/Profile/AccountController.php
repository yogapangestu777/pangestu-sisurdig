<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\AccountRequest;
use App\Services\ProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AccountController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {}

    public function index(): View
    {
        return view('pages.admin.profile.account', [
            'pageTitle' => 'Akun',
            'pageDescription' => 'Silakan perbarui informasi akun Anda. Informasi ini digunakan sebagai kredensial untuk masuk ke dalam sistem.',
            'account' => auth()->user(),
        ]);
    }

    public function update(string $id, AccountRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->profileService->updateAccount($id, $validatedData);
        notify()->success('Akun berhasil diperbarui.', 'Berhasil');

        return back();
    }
}
