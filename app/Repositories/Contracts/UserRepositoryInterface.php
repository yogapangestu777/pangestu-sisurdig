<?php

namespace App\Repositories\Contracts;

use App\Models\Biography;
use App\Models\User;

interface UserRepositoryInterface
{
    public function findById($id): ?User;

    public function updateAccount(User $user, array $data): void;

    public function updateBiography(Biography $biography, array $data): void;

    public function findBiographyByUser(string $id): Biography;

    public function updatePassword(User $user, array $data): void;
}
