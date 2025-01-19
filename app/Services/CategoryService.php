<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepo
    ) {}

    public function getcategories(): Collection
    {
        return $this->categoryRepo->getAll()->map(function ($category) {
            return (object) [
                'id' => encryptId($category->id),
                'name' => $category->name,
                'created_at' => formatDateTime($category->created_at),
                'enhancer' => $category->user->biography->full_name ?? '-unknown-',
            ];
        });
    }

    public function createCategory(array $data): void
    {
        $this->categoryRepo->create([
            'user_id' => auth()->id(),
            'name' => $data['name'],
        ]);
    }

    public function updateCategory(string $id, array $data): void
    {
        $decrytedId = decryptId($id);
        $category = $this->categoryRepo->findById($decrytedId);

        $this->categoryRepo->update($category, $data);
    }

    public function deleteCategory(string $id): void
    {
        $decrytedId = decryptId($id);
        $category = $this->categoryRepo->findById($decrytedId);

        $this->categoryRepo->delete($category);
    }
}
