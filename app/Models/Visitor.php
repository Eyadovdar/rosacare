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

    /**
     * Get device type from user agent
     */
    public function getDeviceAttribute(): ?string
    {
        if (!$this->user_agent) {
            return null;
        }

        $ua = strtolower($this->user_agent);

        // Mobile devices
        if (preg_match('/mobile|android|iphone|ipad|ipod|blackberry|iemobile|opera mini/i', $ua)) {
            if (preg_match('/iphone|ipod/i', $ua)) {
                return 'iPhone';
            }
            if (preg_match('/ipad/i', $ua)) {
                return 'iPad';
            }
            if (preg_match('/android/i', $ua)) {
                return 'Android';
            }
            if (preg_match('/blackberry/i', $ua)) {
                return 'BlackBerry';
            }
            return 'Mobile';
        }

        // Desktop devices
        if (preg_match('/windows/i', $ua)) {
            return 'Desktop (Windows)';
        }
        if (preg_match('/macintosh|mac os/i', $ua)) {
            return 'Desktop (Mac)';
        }
        if (preg_match('/linux/i', $ua)) {
            return 'Desktop (Linux)';
        }

        return 'Desktop';
    }

    /**
     * Get browser name from user agent
     */
    public function getBrowserAttribute(): ?string
    {
        if (!$this->user_agent) {
            return null;
        }

        $ua = strtolower($this->user_agent);

        // Chrome
        if (preg_match('/chrome/i', $ua) && !preg_match('/edg|opr|samsung/i', $ua)) {
            if (preg_match('/chromium/i', $ua)) {
                return 'Chromium';
            }
            return 'Chrome';
        }

        // Edge
        if (preg_match('/edg/i', $ua)) {
            return 'Edge';
        }

        // Safari
        if (preg_match('/safari/i', $ua) && !preg_match('/chrome|chromium/i', $ua)) {
            return 'Safari';
        }

        // Firefox
        if (preg_match('/firefox|fxios/i', $ua)) {
            return 'Firefox';
        }

        // Opera
        if (preg_match('/opr|opera/i', $ua)) {
            return 'Opera';
        }

        // Samsung Internet
        if (preg_match('/samsungbrowser/i', $ua)) {
            return 'Samsung Internet';
        }

        // Internet Explorer
        if (preg_match('/msie|trident/i', $ua)) {
            return 'Internet Explorer';
        }

        return 'Unknown';
    }

    /**
     * Get operating system from user agent
     */
    public function getOsAttribute(): ?string
    {
        if (!$this->user_agent) {
            return null;
        }

        $ua = strtolower($this->user_agent);

        // Windows
        if (preg_match('/windows nt 10.0/i', $ua)) {
            return 'Windows 10/11';
        }
        if (preg_match('/windows nt 6.3/i', $ua)) {
            return 'Windows 8.1';
        }
        if (preg_match('/windows nt 6.2/i', $ua)) {
            return 'Windows 8';
        }
        if (preg_match('/windows nt 6.1/i', $ua)) {
            return 'Windows 7';
        }
        if (preg_match('/windows/i', $ua)) {
            return 'Windows';
        }

        // macOS
        if (preg_match('/mac os x 10[._](\d+)/i', $ua, $matches)) {
            $version = (int)($matches[1] ?? 0);
            if ($version >= 15) {
                return 'macOS Big Sur+';
            }
            if ($version >= 12) {
                return 'macOS Sierra+';
            }
            return 'macOS';
        }
        if (preg_match('/macintosh|mac os/i', $ua)) {
            return 'macOS';
        }

        // iOS
        if (preg_match('/os (\d+)[._](\d+)/i', $ua, $matches) && preg_match('/iphone|ipad|ipod/i', $ua)) {
            $major = (int)($matches[1] ?? 0);
            return "iOS {$major}";
        }
        if (preg_match('/iphone|ipad|ipod/i', $ua)) {
            return 'iOS';
        }

        // Android
        if (preg_match('/android ([\d.]+)/i', $ua, $matches)) {
            return 'Android ' . $matches[1];
        }
        if (preg_match('/android/i', $ua)) {
            return 'Android';
        }

        // Linux
        if (preg_match('/linux/i', $ua)) {
            if (preg_match('/ubuntu/i', $ua)) {
                return 'Ubuntu';
            }
            if (preg_match('/debian/i', $ua)) {
                return 'Debian';
            }
            if (preg_match('/fedora/i', $ua)) {
                return 'Fedora';
            }
            return 'Linux';
        }

        return 'Unknown';
    }
}
