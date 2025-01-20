<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Manage\OutgoingLetterRequest;
use App\Services\CategoryService;
use App\Services\OutgoingLetterService;
use App\Services\PartyService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response as Download;

class OutgoingLetterController extends Controller
{
    public function __construct(
        protected OutgoingLetterService $outgoingLetterService,
        protected CategoryService $categoryService,
        protected PartyService $partyService
    ) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $outgoingLetters = $this->outgoingLetterService->getOutgoingLettersQuery();

            return $this->outgoingLetterService->renderOutgoingLetterDataTable($outgoingLetters);
        }

        return view('pages.admin.manage.outgoingLetters.index', [
            'pageTitle' => 'Surat Keluar',
            'pageDescription' => 'Daftar surat keluar yang tersedia di aplikasi.',
        ]);
    }

    public function create(): View
    {
        return view('pages.admin.manage.outgoingLetters.create', [
            'pageTitle' => 'Tambah Surat Keluar',
            'pageDescription' => 'Tambah surat keluar baru ke dalam aplikasi.',
            'categories' => $this->categoryService->getcategories(),
            'parties' => $this->partyService->getParties(),
        ]);
    }

    public function show(string $id): View
    {
        return view('pages.admin.manage.outgoingLetters.show', [
            'pageTitle' => 'Detail Surat Keluar',
            'pageDescription' => 'Detail surat keluar yang terdaftar di aplikasi.',
            'attachments' => $this->outgoingLetterService->getAttachments($id),
        ]);
    }

    public function download(string $id): HttpResponse
    {
        $prepareDownload = $this->outgoingLetterService->prepareDownload($id);

        return Download::make($prepareDownload[0], $prepareDownload[1], $prepareDownload[2]);
    }

    public function store(OutgoingLetterRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->outgoingLetterService->createOutgoingLetter($validatedData);

        return $result ? redirect()->route('admin.manage.outgoingLetters.index') : back()->withInput();
    }

    public function edit(string $id): View
    {
        $outgoingLetter = $this->outgoingLetterService->findById($id);
        $transformedData = $this->outgoingLetterService->transFormData($outgoingLetter);

        return view('pages.admin.manage.outgoingLetters.edit', [
            'pageTitle' => 'Edit Surat Keluar',
            'pageDescription' => 'Edit data surat keluar yang terdaftar di aplikasi.',
            'categories' => $this->categoryService->getcategories(),
            'parties' => $this->partyService->getParties(),
            'outgoingLetter' => $transformedData,
            'attachments' => $this->outgoingLetterService->getAttachments($id),
        ]);
    }

    public function update(string $id, OutgoingLetterRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->outgoingLetterService->updateOutgoingLetter($id, $validatedData);

        return $result ? redirect()->route('admin.manage.outgoingLetters.index') : back()->withInput();
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->outgoingLetterService->deleteOutgoingLetter($id);
        notify()->success('Surat keluar berhasil dihapus.', 'Berhasil');

        return back();
    }
}
