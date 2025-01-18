<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\RoleRequest;
use App\Services\RoleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService
    ) {}

    public function index(): View
    {
        return view('pages.admin.setting.roles', [
            'pageTitle' => 'Role',
            'pageDescription' => 'Halaman ini digunakan untuk mengatur role yang ada di dalam sistem. Role ini akan mempengaruhi hak akses yang dimiliki oleh pengguna.',
            'roles' => $this->roleService->getAll(),
        ]);
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->roleService->createRole($validatedData);
        notify()->success('Role berhasil ditambahkan.', 'Berhasil');

        return back();
    }

    public function update(string $id, RoleRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->roleService->updateRole($id, $validatedData);
        notify()->success('Role berhasil diperbarui.', 'Berhasil');

        return back();
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->roleService->deleteRole($id);
        notify()->success('Role berhasil dihapus.', 'Berhasil');

        return back();
    }
}
