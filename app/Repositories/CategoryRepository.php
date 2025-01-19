<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        protected Category $categoryModel,
        protected Permission $permissionModel
    ) {}

    public function getAll(): Collection
    {
        return $this->categoryModel->with(['user', 'user.biography'])->latest()->get();
    }

    public function findById(string $id): ?Category
    {
        return $this->categoryModel->find($id);
    }

    public function create(array $data): void
    {
        $this->categoryModel->create($data);
    }

    public function update(Category $category, array $data): void
    {
        $category->update($data);
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
