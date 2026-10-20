<?php
namespace App\Core\Middleware;

use App\Core\Session;
use App\Core\Logger;

class AdminMiddleware
{
    public static function handle(): void
    {
        if (!Session::isLoggedIn() || !Session::isAdmin()) {
            Logger::log('security', 'Truy cập /admin trái phép - user_id: '
                . Session::get('user_id', 'guest') . ' - IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
            http_response_code(403);
            require __DIR__ . '/../../Views/errors/403.php';
            exit;
        }
    }
}
