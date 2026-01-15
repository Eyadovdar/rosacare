<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for admin panel and API routes
        if ($request->is('admin/*') || $request->is('api/*') || $request->is('filament/*')) {
            return $next($request);
        }

        // Skip tracking for bots (optional, can be enabled)
        $userAgent = $request->userAgent() ?? '';
        $isBot = Visitor::isBot($userAgent);
        
        // You can uncomment this to skip bot tracking
        // if ($isBot) {
        //     return $next($request);
        // }

        // Track visitor asynchronously to avoid slowing down the request
        $this->trackVisitor($request, $isBot);

        return $next($request);
    }

    /**
     * Track visitor information
     */
    protected function trackVisitor(Request $request, bool $isBot): void
    {
        try {
            $ipAddress = $this->getClientIp($request);
            $userAgent = $request->userAgent() ?? '';
            $url = $request->fullUrl();
            $referer = $request->header('Referer');
            $locale = App::getLocale() ?? session('locale', 'ar');

            // Get country information from IP
            $geoData = $this->getGeoData($ipAddress);

            Visitor::create([
                'ip_address' => $ipAddress,
                'country_code' => $geoData['country_code'] ?? null,
                'country_name' => $geoData['country_name'] ?? null,
                'city' => $geoData['city'] ?? null,
                'region' => $geoData['region'] ?? null,
                'user_agent' => strlen($userAgent) > 500 ? substr($userAgent, 0, 500) : $userAgent,
                'url' => strlen($url) > 500 ? substr($url, 0, 500) : $url,
                'referer' => $referer ? (strlen($referer) > 500 ? substr($referer, 0, 500) : $referer) : null,
                'locale' => $locale,
                'is_bot' => $isBot,
            ]);
        } catch (\Exception $e) {
            // Log error but don't break the request
            Log::error('Failed to track visitor', [
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);
        }
    }

    /**
     * Get client IP address
     */
    protected function getClientIp(Request $request): string
    {
        $ipAddress = $request->header('CF-Connecting-IP') // Cloudflare
            ?? $request->header('X-Real-IP')
            ?? $request->header('X-Forwarded-For')
            ?? $request->ip();

        // If X-Forwarded-For contains multiple IPs, get the first one
        if ($ipAddress && str_contains($ipAddress, ',')) {
            $ipAddress = trim(explode(',', $ipAddress)[0]);
        }

        return $ipAddress ?? '0.0.0.0';
    }

    /**
     * Get geographical data from IP address
     * Using free IP geolocation API (ip-api.com)
     */
    protected function getGeoData(string $ipAddress): array
    {
        // Skip local/private IPs
        if (!filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return [];
        }

        try {
            // Using ip-api.com (free, no API key required, 45 requests/minute limit)
            $url = "http://ip-api.com/json/{$ipAddress}?fields=status,message,country,countryCode,city,regionName,query";
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 2, // 2 second timeout
                    'method' => 'GET',
                ]
            ]);

            $response = @file_get_contents($url, false, $context);
            
            if ($response === false) {
                return [];
            }

            $data = json_decode($response, true);

            if (isset($data['status']) && $data['status'] === 'success') {
                return [
                    'country_code' => $data['countryCode'] ?? null,
                    'country_name' => $data['country'] ?? null,
                    'city' => $data['city'] ?? null,
                    'region' => $data['regionName'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            Log::warning('Failed to get geo data for IP', [
                'ip' => $ipAddress,
                'error' => $e->getMessage(),
            ]);
        }

        return [];
    }
}
