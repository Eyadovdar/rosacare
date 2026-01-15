<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'country_code',
        'country_name',
        'city',
        'region',
        'user_agent',
        'url',
        'referer',
        'locale',
        'is_bot',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
    ];

    /**
     * Detect if the user agent is a bot
     */
    public static function isBot(string $userAgent): bool
    {
        $botPatterns = [
            'bot', 'crawl', 'spider', 'slurp', 'mediapartners',
            'facebookexternalhit', 'google', 'bing', 'yandex',
            'baiduspider', 'duckduckbot', 'sogou', 'exabot',
            'ia_archiver', 'msnbot', 'ahrefs', 'semrush',
        ];

        $userAgentLower = strtolower($userAgent);
        
        foreach ($botPatterns as $pattern) {
            if (str_contains($userAgentLower, $pattern)) {
                return true;
            }
        }

        return false;
    }
}
