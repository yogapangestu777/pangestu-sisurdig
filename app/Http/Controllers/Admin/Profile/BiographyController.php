<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\BiographyRequest;
use App\Services\ProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BiographyController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {}

    public function index(): View
    {
        return view('pages.admin.profile.biography', [
            'pageTitle' => 'Biodata',
            'pageDescription' => 'Silakan perbarui informasi pribadi Anda.',
            'biography' => auth()->user()->biography,
        ]);
    }

    public function update(string $id, BiographyRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->profileService->updateBiography($id, $validatedData);
        notify()->success('Biodata berhasil diperbarui.', 'Berhasil');

        return back();
    }
}
