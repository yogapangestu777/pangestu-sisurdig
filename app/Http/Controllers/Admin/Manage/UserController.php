<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Manage\UserRequest;
use App\Services\RolePermissionService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected RolePermissionService $rolePermissionService
    ) {}

    public function index(): View
    {
        return view('pages.admin.manage.users.index', [
            'pageTitle' => 'Pengguna',
            'pageDescription' => 'Daftar pengguna yang terdaftar di aplikasi.',
            'users' => $this->userService->getUsers(),
        ]);
    }

    public function create(): View
    {
        return view('pages.admin.manage.users.create', [
            'pageTitle' => 'Tambah Pengguna',
            'pageDescription' => 'Tambah pengguna baru ke dalam aplikasi.',
            'roles' => $this->rolePermissionService->getRoles(),
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->userService->createUser($validatedData);

        return $result ? redirect()->route('admin.manage.users.index') : back();
    }

    public function edit(string $id): View
    {
        return view('pages.admin.manage.users.edit', [
            'pageTitle' => 'Edit Pengguna',
            'pageDescription' => 'Edit data pengguna yang terdaftar di aplikasi.',
            'user' => $this->userService->findById($id),
            'roles' => $this->rolePermissionService->getRoles(),
        ]);
    }

    public function update(string $id, UserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->userService->updateUser($id, $validatedData);

        return $result ? redirect()->route('admin.manage.users.index') : back();
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->userService->deleteUser($id);

        return back();
    }

    public function resetPassword(string $id): RedirectResponse
    {
        $this->userService->resetPassword($id);
        notify()->success('Kata sandi pengguna berhasil direset.', 'Berhasil');

        return back();
    }

    public function toggleStatus(string $id): RedirectResponse
    {
        $this->userService->toggleStatus($id);

        return back();
    }
}
