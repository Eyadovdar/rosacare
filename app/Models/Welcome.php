<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'is_active',
    ];

    public function welcomeDetails(): HasMany
    {
        return $this->hasMany(WelcomeDetail::class);
    }
}
