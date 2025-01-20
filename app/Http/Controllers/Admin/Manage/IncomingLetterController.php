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
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response as Download;

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

    public function show(string $id): View
    {
        return view('pages.admin.manage.incomingLetters.show', [
            'pageTitle' => 'Detail Surat Masuk',
            'pageDescription' => 'Detail surat masuk yang terdaftar di aplikasi.',
            'attachments' => $this->incomingLetterService->getAttachments($id),
        ]);
    }

    public function download(string $id): HttpResponse
    {
        $prepareDownload = $this->incomingLetterService->prepareDownload($id);

        return Download::make($prepareDownload[0], $prepareDownload[1], $prepareDownload[2]);
    }

    public function store(IncomingLetterRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->incomingLetterService->createIncomingLetter($validatedData);

        return $result ? redirect()->route('admin.manage.incomingLetters.index') : back()->withInput();
    }

    public function edit(string $id): View
    {
        $incomingLetter = $this->incomingLetterService->findById($id);
        $transformedData = $this->incomingLetterService->transFormData($incomingLetter);

        return view('pages.admin.manage.incomingLetters.edit', [
            'pageTitle' => 'Edit Surat Masuk',
            'pageDescription' => 'Edit data surat masuk yang terdaftar di aplikasi.',
            'categories' => $this->categoryService->getcategories(),
            'parties' => $this->partyService->getParties(),
            'incomingLetter' => $transformedData,
            'attachments' => $this->incomingLetterService->getAttachments($id),
        ]);
    }

    public function update(string $id, IncomingLetterRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->incomingLetterService->updateIncomingLetter($id, $validatedData);

        return $result ? redirect()->route('admin.manage.incomingLetters.index') : back()->withInput();
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->incomingLetterService->deleteIncomingLetter($id);
        notify()->success('Surat masuk berhasil dihapus.', 'Berhasil');

        return back();
    }
}
