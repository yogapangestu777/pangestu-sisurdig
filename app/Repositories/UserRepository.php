<?php

namespace App\Repositories;

use App\Models\Biography;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $user,
        protected Biography $biography
    ) {}

    public function findById($id): ?User
    {
        return $this->user->find($id);
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
        return $this->biography->where('user_id', $id)->first();
    }

    public function updatePassword(User $user, array $data): void
    {
        $user->update([
            'password' => $data['new_password'],
        ]);
    }
}
