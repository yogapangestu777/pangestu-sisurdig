<?php

namespace App\Repositories\Contracts;

use App\Models\Biography;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findById($id): ?User;

    public function updateAccount(User $user, array $data): void;

    public function updateBiography(Biography $biography, array $data): void;

    public function findBiographyByUser(string $id): Biography;

    public function updatePassword(User $user, array $data): void;

    public function getAll(): Collection;

    public function create(array $userData, array $biographyData, string $role): bool;

    public function update(array $userData, array $biographyData, string $role, User $user): bool;

    public function delete(User $user): void;

    public function resetPassword(User $user): void;

    public function toggleStatus(User $user): void;

    public function count(?array $dateRange = null): int;
}
