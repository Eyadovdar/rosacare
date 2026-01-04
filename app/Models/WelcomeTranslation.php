<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'welcome_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];
}

