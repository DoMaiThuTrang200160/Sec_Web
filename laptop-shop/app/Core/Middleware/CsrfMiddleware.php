<?php
namespace App\Core\Middleware;

use App\Core\Request;
use App\Core\Csrf;
use App\Core\Logger;

class CsrfMiddleware
{
    public static function handle(): void
    {
        if (Request::method() === 'POST') {
            $token = Request::input('_csrf');
            if (!Csrf::verify($token)) {
                Logger::log('security', 'CSRF token sai/thiếu - IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown')
                    . ' - URI: ' . ($_SERVER['REQUEST_URI'] ?? ''));
                http_response_code(403);
                die('Yêu cầu không hợp lệ (thiếu hoặc sai CSRF token). Vui lòng tải lại trang và thử lại.');
            }
        }
    }
}
