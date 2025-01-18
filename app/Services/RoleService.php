<?php

namespace App\Services;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Collection;

class RoleService
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepo
    ) {}

    public function getAll(): Collection
    {
        return $this->roleRepo->all()->map(function ($role) {
            return (object) [
                'id' => encryptId($role->id),
                'name' => $role->name,
                'created_at' => formatDateTime($role->created_at),
            ];
        });
    }

    public function createRole(array $data): void
    {
        $this->roleRepo->create($data);
    }

    public function updateRole(string $id, array $data): void
    {
        $decrytedId = decryptId($id);
        $role = $this->roleRepo->findById($decrytedId);
        $this->roleRepo->update($role, $data);
    }

    public function deleteRole(string $id): void
    {
        $decrytedId = decryptId($id);
        $role = $this->roleRepo->findById($decrytedId);
        $this->roleRepo->delete($role);
    }
}
