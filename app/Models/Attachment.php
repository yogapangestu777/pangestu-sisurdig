<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'filename',
        'extension',
        'size',
        'title',
    ];

    public function getFormattedAttachmentAttribute(): string
    {
        return $this->created_at->format('Y-m-d').'/'.$this->filename.'.'.$this->extension;
    }

    public function attachmentable(): MorphTo
    {
        return $this->morphTo();
    }
}
