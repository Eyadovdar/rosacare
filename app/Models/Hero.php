<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Hero extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
        'button_text',
        'button_url',
        'button_color',
        'button_text_color',
    ];

    public function getUrlAttribute(): string
    {
        return url($this->button_url);
    }
    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'images');
    }
}
