<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'setting_id',
        'locale',
        'site_name',
        'slogan',
        'footer_description',
        'default_meta_title',
        'default_meta_description',
        'default_meta_keywords',
        'contact_page_info_title',
        'contact_page_form_title',
        'google_map_title',
        'footer_copyright',
    ];
}

