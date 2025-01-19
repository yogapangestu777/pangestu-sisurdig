<?php

namespace App\Repositories;

use App\Models\Biography;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $userModel,
        protected Biography $biographyModel
    ) {}

    public function findById($id): ?User
    {
        return $this->userModel->with(['biography', 'roles'])->find($id);
    }

    public function updateAccount(User $user, array $data): void
    {
        $user->update($data);
    }

    public function updateBiography(Biography $biography, array $data): void
    {
        $biography->update($data);
    }

    public function findBiographyByUser(string $id): Biography
    {
        return $this->biographyModel->where('user_id', $id)->first();
    }

    public function updatePassword(User $user, array $data): void
    {
        $user->update([
            'password' => $data['new_password'],
        ]);
    }

    public function getAll(): Collection
    {
        return $this->userModel->with(['biography'])->latest()->get();
    }

    public function create(array $userData, array $biographyData, string $role): bool
    {
        DB::beginTransaction();
        try {
            $user = $this->userModel->create($userData);
            $user->biography()->create($biographyData);

            $user->assignRole($userData['role']);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error when creating user: {$e->getMessage()}");

            return false;
        }
    }

    public function update(array $userData, array $biographyData, string $role, User $user): bool
    {
        DB::beginTransaction();
        try {
            $user->update($userData);
            $user->biography()->update($biographyData);

            $user->syncRoles($role);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error when updating user: {$e->getMessage()}");

            return false;
        }
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function resetPassword(User $user): void
    {
        $user->update([
            'password' => env('DEFAULT_PASSWORD_USER'),
        ]);
    }

    public function toggleStatus(User $user): void
    {
        $user->update([
            'is_active' => $user->is_active === '1' ? '0' : '1',
        ]);
    }
}
