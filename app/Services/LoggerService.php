<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LoggerService
{
    /**
     * @param $message
     * @param $context
     * @return void
     */
    public function info($message, $context = []): void
    {
        Log::info($message, $context);
    }

    /**
     * @param $message
     * @param $context
     * @return void
     */
    public function debug($message, $context = []): void
    {
        Log::debug($message, $context);
    }

    /**
     * @param $message
     * @param $context
     * @return void
     */
    public function error($message, $context = []): void
    {
        Log::error($message, $context);
    }
}
