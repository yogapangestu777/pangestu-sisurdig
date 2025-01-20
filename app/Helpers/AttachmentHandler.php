<?php

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

if (! function_exists('fetchAttachments')) {
    function fetchAttachments(Model $model, string $path): SupportCollection
    {
        return Attachment::whereHas('attachmentable', function ($query) use ($model) {
            $query->where('attachmentable_type', get_class($model))
                ->where('attachmentable_id', $model->id);
        })
            ->latest()
            ->get()
            ->map(function ($attachment) use ($path) {
                if (! isset($attachment->filename) || ! isset($attachment->extension)) {
                    return null;
                }

                $attachment->storageUrl = Storage::url("{$path}/{$attachment->formatted_attachment}");

                return $attachment;
            });
    }
}

if (! function_exists('updateAttachments')) {
    function updateAttachments(array|string $attachment, string $featureId, string $model): void
    {
        $attachmentIds = is_string($attachment) ? [$attachment] : $attachment;

        Attachment::whereIn('id', $attachmentIds)
            ->update([
                'attachmentable_id' => $featureId,
                'attachmentable_type' => $model,
            ]);
    }
}

if (! function_exists('syncAttachments')) {
    function syncAttachments(Model $model, array|string $attachmentIds, string $relationName = 'attachment'): void
    {
        $attachmentIds = is_string($attachmentIds) ? [$attachmentIds] : $attachmentIds;

        $currentAttachmentIds = $model->$relationName()->pluck('id')->toArray();

        $attachmentIdsToDelete = array_diff($currentAttachmentIds, $attachmentIds);

        DB::transaction(function () use ($attachmentIdsToDelete, $attachmentIds, $model) {
            Attachment::whereIn('id', $attachmentIdsToDelete)->delete();

            Attachment::whereIn('id', $attachmentIds)
                ->update([
                    'attachmentable_id' => $model->id,
                    'attachmentable_type' => get_class($model),
                ]);
        });
    }
}
