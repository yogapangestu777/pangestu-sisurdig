<?php

namespace App\Services;

use App\Models\IncomingLetter;
use App\Repositories\Contracts\IncomingLetterRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class IncomingLetterService
{
    public function __construct(
        protected IncomingLetterRepositoryInterface $incomingLetterRepo
    ) {}

    public function getIncomingLettersQuery(): Builder
    {
        return $this->incomingLetterRepo->incomingLettersQuery();
    }

    public function findById(string $id): object
    {
        $incomingLetter = $this->incomingLetterRepo->findById(decryptId($id));

        return (object) [
            'id' => encryptId($incomingLetter->id),
            'reference_number' => $incomingLetter->reference_number,
            'subject' => $incomingLetter->subject,
            'description' => $incomingLetter->description,
            'category_id' => encryptId($incomingLetter->category_id),
            'party_id' => encryptId($incomingLetter->party_id),
        ];
    }

    public function createIncomingLetter(array $data): void
    {
        $this->incomingLetterRepo->create([
            'user_id' => auth()->id(),
            'reference_number' => $data['reference_number'],
            'subject' => $data['subject'],
            'description' => $data['description'],
            'category_id' => $data['category'],
            'party_id' => $data['party'],
        ]);
    }

    public function updateIncomingLetter(string $id, array $data): void
    {
        $decrytedId = decryptId($id);
        $incomingLetter = $this->incomingLetterRepo->findById($decrytedId);

        $this->incomingLetterRepo->update($incomingLetter, [
            'reference_number' => $data['reference_number'],
            'subject' => $data['subject'],
            'description' => $data['description'],
            'category_id' => $data['category'],
            'party_id' => $data['party'],
        ]);
    }

    public function deleteIncomingLetter(string $id): void
    {
        $decrytedId = decryptId($id);
        $incomingLetter = $this->incomingLetterRepo->findById($decrytedId);

        $this->incomingLetterRepo->delete($incomingLetter);
    }

    public function renderIncomingLetterDataTable(Builder $parties): JsonResponse
    {
        return DataTables::eloquent($parties)
            ->addIndexColumn()
            ->editColumn('created_at', fn ($incomingLetter) => formatDateTime($incomingLetter->created_at))
            ->addColumn('enhancer', fn ($incomingLetter) => $incomingLetter->user->biography->full_name ?? '-unknown-')
            ->addColumn('actions', fn ($incomingLetter) => $this->renderActionsColumn($incomingLetter))
            ->rawColumns(['actions'])
            ->make();
    }

    private function renderActionsColumn(IncomingLetter $incomingLetter): string
    {
        return view('partials.admin.datatable._actions', [
            'buttons' => [
                $this->generateEditButton($incomingLetter),
                $this->generateDeleteButton($incomingLetter),
            ],
        ])->render();
    }

    private function generateEditButton(IncomingLetter $incomingLetter): array
    {
        return [
            'title' => 'Edit',
            'url' => route('admin.manage.incomingLetters.edit', encryptId($incomingLetter->id)),
            'icon' => 'edit',
        ];
    }

    private function generateDeleteButton(IncomingLetter $incomingLetter): array
    {
        return [
            'title' => 'Hapus',
            'url' => route('admin.manage.incomingLetters.destroy', encryptId($incomingLetter->id)),
            'icon' => 'trash',
            'class' => 'delete',
            'need-confirmation' => true,
            'method' => 'delete',
        ];
    }
}
