<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WelcomeDetail extends Model
{
    use Translatable;

    public $translationModel = WelcomeDetailTranslation::class;

    public $translatedAttributes = [
        'title',
        'description',
        'button_text',
    ];

    protected $fillable = [
        'welcome_id',
        'image',
        'button_url',
        'button_color',
        'button_text_color',
        'is_active',
    ];

    public function welcome(): BelongsTo
    {
        return $this->belongsTo(Welcome::class);
    }
}
