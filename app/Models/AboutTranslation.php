<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutTranslation extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'about_id',
        'locale',
        'story_title',
        'story_content',
        'story_paragraphs',
        'vision_title',
        'vision_content',
        'mission_title',
        'mission_content',
        'heritage_title',
        'heritage_content',
        'heritage_subcontent',
        'why_rosacare_title',
        'benefits_title',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'story_paragraphs' => 'array',
    ];
}
