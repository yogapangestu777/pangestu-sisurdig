<?php

namespace App\Services;

use App\Models\IncomingLetter;
use App\Repositories\Contracts\IncomingLetterRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    public function findById(string $id): IncomingLetter
    {
        return $this->incomingLetterRepo->findById(decryptId($id));
    }

    public function transformData(IncomingLetter $incomingLetter): object
    {
        return (object) [
            'id' => encryptId($incomingLetter->id),
            'reference_number' => $incomingLetter->reference_number,
            'subject' => $incomingLetter->subject,
            'description' => $incomingLetter->description,
            'category_id' => encryptId($incomingLetter->category_id),
            'party_id' => encryptId($incomingLetter->party_id),
        ];
    }

    public function getAttachments(string $id): Collection
    {
        $incomingLetter = $this->incomingLetterRepo->findById(decryptId($id));
        $attachments = fetchAttachments($incomingLetter, 'incoming-letters');

        return $attachments;
    }

    public function prepareDownload(string $id): array
    {
        $incomingLetter = $this->incomingLetterRepo->findById(decryptId($id));
        $attachment = fetchAttachments($incomingLetter, 'incoming-letters');
        $firstAttachment = $attachment->first();

        $headers = [
            'Content-Type' => "application/{$firstAttachment->extension}",
            'Content-Disposition' => "attachment; filename={$incomingLetter->subject}.".$firstAttachment->extension,
        ];

        $prepareDownload = [
            Storage::get("incoming-letters/{$firstAttachment->formatted_attachment}"),
            Response::HTTP_OK,
            $headers,
        ];

        return $prepareDownload;
    }

    public function createIncomingLetter(array $data): bool
    {
        DB::beginTransaction();
        try {
            $incomingLetter = $this->incomingLetterRepo->create([
                'user_id' => auth()->id(),
                'reference_number' => $data['reference_number'],
                'subject' => $data['subject'],
                'description' => $data['description'],
                'category_id' => $data['category'],
                'party_id' => $data['party'],
            ]);

            updateAttachments($data['file'], $incomingLetter->id, IncomingLetter::class);

            DB::commit();

            notify()->success('Surat masuk berhasil ditambahkan.', 'Berhasil');

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            notify()->error('Surat masuk gagal ditambahkan.Silakan coba lagi dan jika masalah terus berlanjut,silakan hubungi pengembang.', 'Gagal');
            Log::error("Error: {$e->getMessage()}");

            return false;
        }
    }

    public function updateIncomingLetter(string $id, array $data): bool
    {
        $decrytedId = decryptId($id);
        $incomingLetter = $this->incomingLetterRepo->findById($decrytedId);

        DB::beginTransaction();
        try {
            $this->incomingLetterRepo->update($incomingLetter, [
                'reference_number' => $data['reference_number'],
                'subject' => $data['subject'],
                'description' => $data['description'],
                'category_id' => $data['category'],
                'party_id' => $data['party'],
            ]);

            updateAttachments($data['file'], $incomingLetter->id, IncomingLetter::class);

            DB::commit();

            notify()->success('Surat masuk berhasil diperbarui.', 'Berhasil');

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            notify()->error('Surat masuk gagal diperbarui.Silakan coba lagi dan jika masalah terus berlanjut,silakan hubungi pengembang.', 'Gagal');
            Log::error("Error: {$e->getMessage()}");

            return false;
        }
    }

    public function deleteIncomingLetter(string $id): void
    {
        $decrytedId = decryptId($id);
        $incomingLetter = $this->incomingLetterRepo->findById($decrytedId);

        $this->incomingLetterRepo->delete($incomingLetter);
    }

    public function countIncomingLetter(?array $dateRange = null): int
    {
        return $this->incomingLetterRepo->count($dateRange);
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
                $this->generateViewButton($incomingLetter),
                $this->generateDownloadButton($incomingLetter),
                $this->generateEditButton($incomingLetter),
                $this->generateDeleteButton($incomingLetter),
            ],
        ])->render();
    }

    private function generateViewButton(IncomingLetter $incomingLetter): array
    {
        return [
            'title' => 'Lihat',
            'url' => route('admin.manage.incomingLetters.show', encryptId($incomingLetter->id)),
            'icon' => 'eye',
        ];
    }

    private function generateDownloadButton(IncomingLetter $incomingLetter): array
    {
        return [
            'title' => 'Unduh',
            'url' => route('admin.manage.incomingLetters.download', encryptId($incomingLetter->id)),
            'icon' => 'download',
        ];
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
