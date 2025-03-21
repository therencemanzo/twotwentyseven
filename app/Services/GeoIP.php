<?php

namespace App\Services;

class GeoIP
{
    /**
     * Simulate a geo-IP lookup.
     *
     * @param string $ipAddress The IP address to look up.
     * @return array|null The latitude and longitude, or null if not found.
     */
    public static function lookup(string $ipAddress): ?array
    {
        // Simulate known IP addresses and their geo-IP data
        $knownIps = [
            '127.0.0.1' => [ // Localhost
                'latitude' => 51.509865,
                'longitude' => -0.118092,
            ],
            '192.168.1.1' => [ // Example IP
                'latitude' => 51.50986524,
                'longitude' => -74.00602,
            ],
        ];

        // Return the geo-IP data if the IP is known, otherwise return null
        return $knownIps[$ipAddress] ?? null;
    }
}