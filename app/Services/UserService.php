<?php

namespace App\Services;

use App\Models\Biography;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepo
    ) {}

    public function findById(string $id): ?User
    {
        return $this->userRepo->findById($id);
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
}
