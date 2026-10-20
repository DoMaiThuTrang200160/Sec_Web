<?php
namespace App\Core;

class Logger
{
    // channel 'security' -> storage/logs/security.log (dùng cho login fail, CSRF fail, truy cập trái phép...)
    // channel khác -> storage/logs/app.log
    public static function log(string $channel, string $message): void
    {
        $dir  = __DIR__ . '/../../storage/logs';
        $file = $channel === 'security' ? "$dir/security.log" : "$dir/app.log";
        $line = '[' . date('Y-m-d H:i:s') . "] [$channel] $message" . PHP_EOL;
        @file_put_contents($file, $line, FILE_APPEND);
    }
}
