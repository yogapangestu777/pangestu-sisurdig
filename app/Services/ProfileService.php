<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserService $userService
    ) {}

    public function updateAccount(string $id, array $data): void
    {
        $decryptId = decryptId($id);
        $user = $this->userService->findById($decryptId);
        $this->userService->updateAccount($user, $data);
    }

    public function updateBiography(string $id, array $data): void
    {
        $decryptId = decryptId($id);
        $biography = $this->userService->findBiographyByUser($decryptId);
        $this->userService->updateBiography($biography, $data);
    }

    public function updatePassword(string $id, array $data): void
    {
        $decryptId = decryptId($id);
        $user = $this->userService->findById($decryptId);

        Auth::logoutOtherDevices($data['current_password']);

        $this->userService->updatePassword($user, $data);

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
