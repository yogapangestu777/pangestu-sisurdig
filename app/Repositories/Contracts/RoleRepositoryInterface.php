<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function all(): Collection;

    public function create(array $data): void;

    public function findById(string $id): object;

    public function update(Role $role, array $data): void;

    public function delete(Role $role): void;
}
