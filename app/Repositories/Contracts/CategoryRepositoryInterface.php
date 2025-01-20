<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(string $id): ?Category;

    public function create(array $data): void;

    public function update(Category $category, array $data): void;

    public function delete(Category $category): void;

    public function count(?array $dateRange = null): int;
}
