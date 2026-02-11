<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = [
        'title',
        'locale',
        'content',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Return policy for frontend: title + single HTML content from Filament rich editor.
     */
    public function getPayloadForFrontend(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content ?? '',
        ];
    }
}
