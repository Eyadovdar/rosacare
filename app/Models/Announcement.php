<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Announcement extends Model
{
    use Translatable;

    public $translationModel = AnnouncementTranslation::class;

    public $translatedAttributes = [
        'title',
        'description',
        'button_text',
    ];

    protected $fillable = [
        'button_url',
        'button_color',
        'button_text_color',
    ];
    public function translations(): HasMany
    {
        return $this->hasMany(AnnouncementTranslation::class);
    }
    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'images');
    }

    public function getUrlAttribute(): string
    {
        return url($this->button_url);
    }
}
