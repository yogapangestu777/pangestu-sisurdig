<?php

namespace App\Services;

use App\Repositories\Contracts\RolePermissionRepositoryInterface;
use Illuminate\Support\Collection;

class RolePermissionService
{
    public function __construct(
        protected RolePermissionRepositoryInterface $rolePermissionRepo
    ) {}

    public function getRoleWithPermissions(): Collection
    {
        return $this->rolePermissionRepo->getRoleWithPermissions()->map(function ($role) {
            return (object) [
                'id' => encryptId($role->id),
                'name' => $role->name,
                'permissions' => $role->permissions->implode('name', ', '),
                'permissionIds' => $role->permissions->map(fn ($permission) => encryptId($permission->id)),
                'created_at' => formatDateTime($role->created_at),
            ];
        });
    }

    public function getPermissions(): Collection
    {
        return $this->rolePermissionRepo->getPermissions()->map(function ($permission) {
            return (object) [
                'id' => encryptId($permission->id),
                'name' => $permission->name,
            ];
        });
    }

    public function createRole(array $data): void
    {
        $this->rolePermissionRepo->create($data);
    }

    public function updateRole(string $id, array $data): void
    {
        $decrytedId = decryptId($id);
        $role = $this->rolePermissionRepo->findById($decrytedId);
        $this->rolePermissionRepo->update($role, $data);
    }

    public function deleteRole(string $id): void
    {
        $decrytedId = decryptId($id);
        $role = $this->rolePermissionRepo->findById($decrytedId);
        $this->rolePermissionRepo->delete($role);
    }
}
