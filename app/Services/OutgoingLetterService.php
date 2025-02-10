<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\OutgoingLetter;
use App\Repositories\Contracts\OutgoingLetterRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class OutgoingLetterService
{
    public function __construct(
        protected OutgoingLetterRepositoryInterface $outgoingLetterRepo
    ) {}

    public function getOutgoingLettersQuery(): Builder
    {
        return $this->outgoingLetterRepo->outgoingLettersQuery();
    }

    public function findById(string $id): OutgoingLetter
    {
        return $this->outgoingLetterRepo->findById(decryptId($id));
    }

    public function transformData(OutgoingLetter $outgoingLetter): object
    {
        return (object) [
            'id' => encryptId($outgoingLetter->id),
            'reference_number' => $outgoingLetter->reference_number,
            'subject' => $outgoingLetter->subject,
            'content' => $outgoingLetter->content,
            'category_id' => encryptId($outgoingLetter->category_id),
            'party_id' => encryptId($outgoingLetter->party_id),
        ];
    }

    public function getAttachments(string $id): Collection
    {
        $outgoingLetter = $this->outgoingLetterRepo->findById(decryptId($id));

        $attachments = fetchAttachments($outgoingLetter, 'outgoing-letters');

        return $attachments;
    }

    public function prepareDownload(string $id): array
    {
        $outgoingLetter = $this->outgoingLetterRepo->findById(decryptId($id));
        $attachment = fetchAttachments($outgoingLetter, 'outgoing-letters');
        $firstAttachment = $attachment->first();

        $headers = [
            'Content-Type' => "application/{$firstAttachment->extension}",
            'Content-Disposition' => "attachment; filename={$outgoingLetter->subject}.".$firstAttachment->extension,
        ];

        $prepareDownload = [
            Storage::get("outgoing-letters/{$firstAttachment->formatted_attachment}"),
            Response::HTTP_OK,
            $headers,
        ];

        return $prepareDownload;
    }

    public function createOutgoingLetter(array $data): bool
    {
        if (! isset($data['file']) && ! $data['content']) {
            notify()->error('Silakan masukan file atau konten.', 'Gagal');

            return false;
        }

        DB::beginTransaction();
        try {
            $outgoingLetter = $this->outgoingLetterRepo->create([
                'user_id' => auth()->id(),
                'reference_number' => $data['reference_number'],
                'subject' => $data['subject'],
                'content' => $data['content'],
                'category_id' => $data['category'],
                'party_id' => $data['party'],
            ]);

            if (isset($data['file'])) {
                updateAttachments($data['file'], $outgoingLetter->id, OutgoingLetter::class);
            } else {
                $pdfDirectory = storage_path('app/public/outgoing-letters/'.now()->format('Y-m-d'));
                if (! file_exists($pdfDirectory)) {
                    mkdir($pdfDirectory, 0777, true);
                }

                $randName = Str::uuid();
                $pdfPath = 'outgoing-letters/'.now()->format('Y-m-d').'/'.$randName.'.pdf';
                $pdf = PDF::loadHTML($data['content']);
                $pdf->setOption('isHtml5ParserEnabled', true);
                $pdf->setOption('isPhpEnabled', true);
                $pdf->save(storage_path('app/public/'.$pdfPath));

                Attachment::create([
                    'attachmentable_id' => $outgoingLetter->id,
                    'attachmentable_type' => get_class($outgoingLetter),
                    'filename' => $randName,
                    'extension' => 'pdf',
                    'size' => filesize(storage_path('app/public/'.$pdfPath)),
                    'title' => 'outgoing-letters',
                ]);
            }

            DB::commit();

            notify()->success('Surat masuk berhasil ditambahkan.', 'Berhasil');

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            notify()->error('Surat masuk gagal ditambahkan. Silakan coba lagi dan jika masalah terus berlanjut, silakan hubungi pengembang.', 'Gagal');
            Log::error("Error: {$e->getMessage()}");

            return false;
        }
    }

    public function updateOutgoingLetter(string $id, array $data): bool
    {
        $decrytedId = decryptId($id);
        $outgoingLetter = $this->outgoingLetterRepo->findById($decrytedId);

        DB::beginTransaction();
        try {
            $this->outgoingLetterRepo->update($outgoingLetter, [
                'reference_number' => $data['reference_number'],
                'subject' => $data['subject'],
                'content' => $data['content'],
                'category_id' => $data['category'],
                'party_id' => $data['party'],
            ]);

            if (! isset($data['file'])) {
                updateAttachments($data['file'], $outgoingLetter->id, OutgoingLetter::class);
            } else {
                $pdfDirectory = storage_path('app/public/outgoing-letters/'.now()->format('Y-m-d'));
                if (! file_exists($pdfDirectory)) {
                    mkdir($pdfDirectory, 0777, true);
                }

                $randName = Str::uuid();
                $pdfPath = 'outgoing-letters/'.now()->format('Y-m-d').'/'.$randName.'.pdf';
                $pdf = PDF::loadHTML($data['content']);
                $pdf->setOption('isHtml5ParserEnabled', true);
                $pdf->setOption('isPhpEnabled', true);
                $pdf->save(storage_path('app/public/'.$pdfPath));

                Attachment::where('id', $decrytedId)
                    ->update([
                        'attachmentable_id' => $outgoingLetter->id,
                        'attachmentable_type' => get_class($outgoingLetter),
                        'filename' => $randName,
                        'extension' => 'pdf',
                        'size' => filesize(storage_path('app/public/'.$pdfPath)),
                        'title' => 'outgoing-letters',
                    ]);
            }

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

    public function deleteOutgoingLetter(string $id): void
    {
        $decrytedId = decryptId($id);
        $outgoingLetter = $this->outgoingLetterRepo->findById($decrytedId);

        $this->outgoingLetterRepo->delete($outgoingLetter);
    }

    public function countOutgoingLetter(): int
    {
        return $this->outgoingLetterRepo->count();
    }

    public function getMostFrequentLetterParty(?array $dateRange = null): Collection
    {
        return $this->outgoingLetterRepo->getMostFrequentLetterParty(5, $dateRange)
            ->map(function ($item) {
                return (object) [
                    'id' => encryptId($item->party_id),
                    'name' => $item->party->name ?? '-unknown-',
                    'amount' => $item->amount,
                ];
            });
    }

    public function renderOutgoingLetterDataTable(Builder $parties): JsonResponse
    {
        return DataTables::eloquent($parties)
            ->addIndexColumn()
            ->editColumn('created_at', fn ($outgoingLetter) => formatDateTime($outgoingLetter->created_at))
            ->addColumn('enhancer', fn ($outgoingLetter) => $outgoingLetter->user->biography->full_name ?? '-unknown-')
            ->addColumn('actions', fn ($outgoingLetter) => $this->renderActionsColumn($outgoingLetter))
            ->rawColumns(['actions'])
            ->make();
    }

    private function renderActionsColumn(OutgoingLetter $outgoingLetter): string
    {
        return view('partials.admin.datatable._actions', [
            'buttons' => [
                $this->generateViewButton($outgoingLetter),
                $this->generateDownloadButton($outgoingLetter),
                $this->generateEditButton($outgoingLetter),
                $this->generateDeleteButton($outgoingLetter),
            ],
        ])->render();
    }

    private function generateViewButton(OutgoingLetter $outgoingLetter): array
    {
        return [
            'title' => 'Lihat',
            'url' => route('admin.manage.outgoingLetters.show', encryptId($outgoingLetter->id)),
            'icon' => 'eye',
        ];
    }

    private function generateDownloadButton(OutgoingLetter $outgoingLetter): array
    {
        return [
            'title' => 'Unduh',
            'url' => route('admin.manage.outgoingLetters.download', encryptId($outgoingLetter->id)),
            'icon' => 'download',
        ];
    }

    private function generateEditButton(OutgoingLetter $outgoingLetter): array
    {
        return [
            'title' => 'Edit',
            'url' => route('admin.manage.outgoingLetters.edit', encryptId($outgoingLetter->id)),
            'icon' => 'edit',
        ];
    }

    private function generateDeleteButton(OutgoingLetter $outgoingLetter): array
    {
        return [
            'title' => 'Hapus',
            'url' => route('admin.manage.outgoingLetters.destroy', encryptId($outgoingLetter->id)),
            'icon' => 'trash',
            'class' => 'delete',
            'need-confirmation' => true,
            'method' => 'delete',
        ];
    }
}
