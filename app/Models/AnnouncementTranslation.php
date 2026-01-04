<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'announcement_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];
}

