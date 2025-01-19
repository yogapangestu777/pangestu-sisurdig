<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\RolePermissionRequest;
use App\Services\RolePermissionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RolePermissionController extends Controller
{
    public function __construct(
        protected RolePermissionService $rolePermissionService,
    ) {}

    public function index(): View
    {
        return view('pages.admin.setting.role-permissions', [
            'pageTitle' => 'Role & Hak Akses',
            'pageDescription' => 'Halaman ini digunakan untuk mengatur role dan hak akses yang ada di dalam sistem.',
            'roles' => $this->rolePermissionService->getRoleWithPermissions(),
            'permissions' => $this->rolePermissionService->getPermissions(),
        ]);
    }

    public function store(RolePermissionRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->rolePermissionService->createRole($validatedData);
        notify()->success('Role berhasil ditambahkan.', 'Berhasil');

        return back();
    }

    public function update(string $id, RolePermissionRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->rolePermissionService->updateRole($id, $validatedData);
        notify()->success('Role berhasil diperbarui.', 'Berhasil');

        return back();
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->rolePermissionService->deleteRole($id);
        notify()->success('Role berhasil dihapus.', 'Berhasil');

        return back();
    }
}
