<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroTranslation extends Model
{
    protected $table = 'heroes_translations';

    public $timestamps = false;

    protected $fillable = [
        'hero_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];
}

