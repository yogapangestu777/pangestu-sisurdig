<?php

namespace App\Services;

use App\Models\Biography;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepo,
        protected RolePermissionService $rolePermissionService
    ) {}

    public function findById(string $id): object
    {
        $decryptedId = decryptId($id);
        $user = $this->userRepo->findById($decryptedId);

        return (object) [
            // user model
            'id' => encryptId($user->id),
            'email' => $user->email,
            'username' => $user->username,

            // biography model
            'full_name' => $user->biography->full_name ?? '-unknown-',
            'phone_number' => $user->biography->phone_number ?? '-unknown-',
            'pob' => $user->biography->pob ?? '-unknown-',
            'dob' => $user->biography->dob ?? '-unknown-',
            'gender' => $user->biography->gender ?? '-unknown-',

            // role model
            'role' => encryptId($user->roles->first()->id),
        ];
    }

    public function updateAccount(User $user, array $data): void
    {
        $this->userRepo->updateAccount($user, $data);
    }

    public function updateBiography(Biography $biography, array $data): void
    {
        $this->userRepo->updateBiography($biography, $data);
    }

    public function findBiographyByUser(string $id): Biography
    {
        return $this->userRepo->findBiographyByUser($id);
    }

    public function updatePassword(User $user, array $data): void
    {
        $this->userRepo->updatePassword($user, $data);
    }

    public function getUsers(): Collection
    {
        return $this->userRepo->getAll()->map(function ($user) {
            return (object) [
                // user model
                'id' => encryptId($user->id),
                'email' => $user->email,
                'username' => $user->username,
                'is_active_badge' => $user->is_active ? '<span class="badge badge-dot bg-success">Aktif</span>' : '<span class="badge badge-dot bg-danger">Non-aktif</span>',
                'is_active' => $user->is_active,
                'created_at' => formatDateTime($user->created_at),

                // biography model
                'full_name' => $user->biography->full_name ?? '-unknown-',
                'phone_number' => $user->biography->phone_number ?? '-unknown-',
                'pob' => $user->biography->pob ?? '-unknown-',
                'dob' => formatDate($user->biography->dob) ?? '-unknown-',
                'gender' => ($user->biography->gender === '1' ? 'Laki-laki' : 'Perempuan') ?? '-unknown-',

                // role model
                'role' => $user->roles->first()->name,
            ];
        });
    }

    public function createUser(array $data): bool
    {
        $role = $this->rolePermissionService->findRoleById($data['role']);
        $createAttempt = $this->userRepo->create(
            [
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => env('DEFAULT_PASSWORD_USER'),
                'role' => $data['role'],
            ],
            [
                'full_name' => $data['full_name'],
                'phone_number' => $data['phone_number'],
                'pob' => $data['pob'],
                'dob' => $data['dob'],
                'gender' => $data['gender'],
            ],
            $role->name
        );

        if ($createAttempt) {
            notify()->success('Pengguna berhasil ditambahkan.', 'Berhasil');
        } else {
            notify()->error('Pengguna gagal ditambahkan.Silakan coba lagi dan jika masalah terus berlanjut,silakan hubungi pengembang.', 'Gagal');
        }

        return $createAttempt;
    }

    public function updateUser(string $id, array $data): bool
    {
        $role = $this->rolePermissionService->findRoleById($data['role']);
        $user = $this->userRepo->findById(decryptId($id));
        $updateAttemt = $this->userRepo->update(
            [
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => env('DEFAULT_PASSWORD_USER'),
                'role' => $data['role'],
            ],
            [
                'full_name' => $data['full_name'],
                'phone_number' => $data['phone_number'],
                'pob' => $data['pob'],
                'dob' => $data['dob'],
                'gender' => $data['gender'],
            ],
            $role->name,
            $user
        );

        if ($updateAttemt) {
            notify()->success('Pengguna berhasil diperbarui.', 'Berhasil');
        } else {
            notify()->error('Pengguna gagal diperbarui.Silakan coba lagi dan jika masalah terus berlanjut,silakan hubungi pengembang.', 'Gagal');
        }

        return $updateAttemt;
    }

    public function deleteUser(string $id): void
    {
        $decryptedId = decryptId($id);
        if (auth()->id() === $decryptedId) {
            notify()->error('Anda tidak dapat menghapus akun Anda sendiri.', 'Gagal');

            return;
        }
        $user = $this->userRepo->findById($decryptedId);
        $this->userRepo->delete($user);
        notify()->success('Pengguna berhasil dihapus.', 'Berhasil');
    }

    public function resetPassword(string $id): void
    {
        $decryptedId = decryptId($id);
        $user = $this->userRepo->findById($decryptedId);
        $this->userRepo->resetPassword($user);
    }

    public function toggleStatus(string $id): void
    {
        $decryptedId = decryptId($id);
        if (auth()->id() === $decryptedId) {
            notify()->error('Anda tidak dapat mengubah status akun Anda.', 'Gagal');

            return;
        }
        $user = $this->userRepo->findById($decryptedId);
        $this->userRepo->toggleStatus($user);
        notify()->success('Status pengguna berhasil diubah.', 'Berhasil');
    }

    public function countUser(?array $dateRange = null): int
    {
        return $this->userRepo->count($dateRange);
    }
}
