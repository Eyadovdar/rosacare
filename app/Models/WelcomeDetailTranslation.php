<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeDetailTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'welcome_detail_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];
}

