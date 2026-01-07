<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hero extends Model
{
    use HasFactory, Translatable;

    public $translationModel = HeroTranslation::class;

    public $translatedAttributes = [
        'title',
        'description',
        'button_text',
    ];

    protected $fillable = [
        'image',
        'button_url',
        'button_color',
        'button_text_color',
        'is_active',
    ];

    public function getUrlAttribute(): string
    {
        return url($this->button_url);
    }
}
