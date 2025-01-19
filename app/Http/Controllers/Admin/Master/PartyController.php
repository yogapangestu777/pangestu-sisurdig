<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Master\PartyRequest;
use App\Services\PartyService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function __construct(
        protected PartyService $partyService
    ) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $parties = $this->partyService->getPartiesQuery();

            return $this->partyService->renderPartyDataTable($parties);
        }

        return view('pages.admin.master.parties', [
            'pageTitle' => 'Pihak Terkait',
            'pageDescription' => 'Daftar pihak terkait yang tersedia di aplikasi.',
        ]);
    }

    public function store(PartyRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->partyService->createParty($validatedData);
        notify()->success('Pihak terkait berhasil ditambahkan.', 'Berhasil');

        return back();
    }

    public function update(string $id, PartyRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->partyService->updateParty($id, $validatedData);
        notify()->success('Pihak terkait berhasil diperbarui.', 'Berhasil');

        return back();
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->partyService->deleteParty($id);
        notify()->success('Pihak terkait berhasil dihapus.', 'Berhasil');

        return back();
    }
}
