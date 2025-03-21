<?php

namespace App\Tools;

use Illuminate\Support\Facades\Log;


class DeveloperTest
{
    /**
     * Log data to the log file
     *
     * @param string $message
     * @param array $data
     * @return bool
     */
    public static function logData(string $message, array $data): bool
    {
        Log::info('Something happened: ' . $message, $data);

        return true;
    }
}
