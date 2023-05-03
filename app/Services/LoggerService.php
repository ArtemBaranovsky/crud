<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LoggerService
{
    public function info($message, $context = []): void
    {
        Log::info($message, $context);
    }

    public function debug($message, $context = []): void
    {
        Log::debug($message, $context);
    }

    public function error($message, $context = []): void
    {
        Log::error($message, $context);
    }
}
