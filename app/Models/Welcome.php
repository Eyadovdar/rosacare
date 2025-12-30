<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
class Welcome extends Model
{
    use Translatable;

    public $translationModel = WelcomeTranslation::class;

    public $translatedAttributes = [
        'title',
        'description',
        'button_text',
    ];

    protected $fillable = [
        'image',
        'button_url',
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'images');
    }

    public function welcomeDetails(): HasMany
    {
        return $this->hasMany(WelcomeDetail::class);
    }
}
