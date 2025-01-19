<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Manage\IncomingLetterRequest;
use App\Services\CategoryService;
use App\Services\IncomingLetterService;
use App\Services\PartyService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IncomingLetterController extends Controller
{
    public function __construct(
        protected IncomingLetterService $incomingLetterService,
        protected CategoryService $categoryService,
        protected PartyService $partyService
    ) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $incomingLetters = $this->incomingLetterService->getIncomingLettersQuery();

            return $this->incomingLetterService->renderIncomingLetterDataTable($incomingLetters);
        }

        return view('pages.admin.manage.incomingLetters.index', [
            'pageTitle' => 'Surat Masuk',
            'pageDescription' => 'Daftar surat masuk yang tersedia di aplikasi.',
        ]);
    }

    public function create(): View
    {
        return view('pages.admin.manage.incomingLetters.create', [
            'pageTitle' => 'Tambah Surat Masuk',
            'pageDescription' => 'Tambah surat masuk baru ke dalam aplikasi.',
            'categories' => $this->categoryService->getcategories(),
            'parties' => $this->partyService->getParties(),
        ]);
    }

    public function store(IncomingLetterRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->incomingLetterService->createIncomingLetter($validatedData);
        notify()->success('Surat masuk berhasil ditambahkan.', 'Berhasil');

        return redirect()->route('admin.manage.incomingLetters.index');
    }

    public function edit(string $id): View
    {
        return view('pages.admin.manage.incomingLetters.edit', [
            'pageTitle' => 'Edit Surat Masuk',
            'pageDescription' => 'Edit data surat masuk yang terdaftar di aplikasi.',
            'categories' => $this->categoryService->getcategories(),
            'parties' => $this->partyService->getParties(),
            'incomingLetter' => $this->incomingLetterService->findById($id),
        ]);
    }

    public function update(string $id, IncomingLetterRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->incomingLetterService->updateIncomingLetter($id, $validatedData);
        notify()->success('Surat masuk berhasil diperbarui.', 'Berhasil');

        return redirect()->route('admin.manage.incomingLetters.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->incomingLetterService->deleteIncomingLetter($id);
        notify()->success('Surat masuk berhasil dihapus.', 'Berhasil');

        return back();
    }
}
