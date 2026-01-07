<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeDetailTranslation extends Model
{
    protected $table = 'welcome_details_translations';

    public $timestamps = false;

    protected $fillable = [
        'welcome_detail_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];
}

