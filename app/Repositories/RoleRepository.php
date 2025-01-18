<?php

namespace App\Repositories;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function __construct(
        protected Role $roleModel
    ) {}

    public function all(): Collection
    {
        return $this->roleModel->latest()->get();
    }

    public function create(array $data): void
    {
        $this->roleModel->create($data);
    }

    public function findById(string $id): Role
    {
        return $this->roleModel->find($id);
    }

    public function update(Role $role, array $data): void
    {
        $role->update($data);
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }
}
