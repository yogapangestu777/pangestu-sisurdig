<?php

namespace App\Repositories;

use App\Repositories\Contracts\RolePermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionRepository implements RolePermissionRepositoryInterface
{
    public function __construct(
        protected Role $roleModel,
        protected Permission $permissionModel
    ) {}

    public function getRoleWithPermissions(): Collection
    {
        return $this->roleModel->latest()->get();
    }

    public function getRoles(): Collection
    {
        return $this->roleModel->latest()->get();
    }

    public function getPermissions(): Collection
    {
        return $this->permissionModel->latest()->get();
    }

    public function create(array $data): void
    {
        $role = $this->roleModel->create($data);
        $permissionNames = $this->permissionModel
            ->whereIn('id', array_map('decryptId', $data['permissions']))
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissionNames);
    }

    public function findById(string $id): Role
    {
        return $this->roleModel->find($id);
    }

    public function update(Role $role, array $data): void
    {
        $role->update($data);
        $permissionNames = $this->permissionModel
            ->whereIn('id', array_map('decryptId', $data['permissions']))
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissionNames);
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }
}
