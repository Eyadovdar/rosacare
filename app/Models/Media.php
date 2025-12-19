<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'collection_name',
        'file_name',
        'mime_type',
        'size',
        'disk',
        'path',
        'sort_order',
        'custom_properties',
    ];

    protected $casts = [
        'custom_properties' => 'array',
        'sort_order' => 'integer',
        'size' => 'integer',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path . '/' . $this->file_name);
    }
}
