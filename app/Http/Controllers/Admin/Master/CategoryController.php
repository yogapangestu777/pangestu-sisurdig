<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Master\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        return view('pages.admin.master.categories', [
            'pageTitle' => 'Kategori',
            'pageDescription' => 'Daftar kategori yang tersedia di aplikasi.',
            'categories' => $this->categoryService->getcategories(),
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->categoryService->createCategory($validatedData);
        notify()->success('Kategori berhasil ditambahkan.', 'Berhasil');

        return back();
    }

    public function update(string $id, CategoryRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->categoryService->updateCategory($id, $validatedData);
        notify()->success('Kategori berhasil diperbarui.', 'Berhasil');

        return back();
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->categoryService->deleteCategory($id);
        notify()->success('Kategori berhasil dihapus.', 'Berhasil');

        return back();
    }
}
