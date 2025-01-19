<?php

namespace App\Services;

use App\Models\Party;
use App\Repositories\Contracts\PartyRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class PartyService
{
    public function __construct(
        protected PartyRepositoryInterface $partyRepo
    ) {}

    public function getPartiesQuery(): Builder
    {
        return $this->partyRepo->partiesQuery();
    }

    public function createParty(array $data): void
    {
        $this->partyRepo->create(array_merge($data, [
            'user_id' => auth()->id(),
        ]));
    }

    public function updateParty(string $id, array $data): void
    {
        $decrytedId = decryptId($id);
        $party = $this->partyRepo->findById($decrytedId);

        $this->partyRepo->update($party, $data);
    }

    public function deleteParty(string $id): void
    {
        $decrytedId = decryptId($id);
        $party = $this->partyRepo->findById($decrytedId);

        $this->partyRepo->delete($party);
    }

    public function renderPartyDataTable(Builder $parties): JsonResponse
    {
        return DataTables::eloquent($parties)
            ->addIndexColumn()
            ->editColumn('created_at', fn ($party) => formatDateTime($party->created_at))
            ->addColumn('enhancer', fn ($party) => $party->user->biography->full_name ?? '-unknown-')
            ->editColumn('type', fn ($party) => $this->renderTypeColumn($party))
            ->addColumn('actions', fn ($party) => $this->renderActionsColumn($party))
            ->rawColumns(['actions', 'type'])
            ->make();
    }

    private function renderTypeColumn(Party $party): string
    {
        $type = match ($party->type) {
            '1' => 'Individu',
            '2' => 'Organisasi/Agensi',
            default => '-unknown-',
        };

        return $type;
    }

    private function renderActionsColumn(Party $party): string
    {
        return view('partials.admin.datatable._actions', [
            'buttons' => [
                $this->generateEditButton($party),
                $this->generateDeleteButton($party),
            ],
        ])->render();
    }

    private function generateEditButton(Party $party): array
    {
        return [
            'title' => 'Edit',
            'url' => route('admin.master.parties.update', encryptId($party->id)),
            'icon' => 'edit',
            'isModal' => [
                'attr' => [
                    'name' => $party->name,
                    'type' => $party->type,
                    'email' => $party->email,
                    'phone-number' => $party->phone_number,
                    'address' => $party->address,
                ],
            ],
        ];
    }

    private function generateDeleteButton(Party $party): array
    {
        return [
            'title' => 'Hapus',
            'url' => route('admin.master.parties.destroy', encryptId($party->id)),
            'icon' => 'trash',
            'class' => 'delete',
            'need-confirmation' => true,
            'method' => 'delete',
        ];
    }
}
