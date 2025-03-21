<?php

namespace App\Http\Middleware;

use App\Services\GeoIP;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class GeoIpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();

        $geoIpData = Cache::remember("geo_ip_{$ipAddress}", 7200, function () use ($ipAddress) {
            return GeoIP::lookup($ipAddress) ?? [
                'latitude' => 0,
                'longitude' => 0,
            ];
        });

        // Bind the geo-IP data to the service container
        app()->instance('geoIpData', $geoIpData);

        return $next($request);
    }
}
