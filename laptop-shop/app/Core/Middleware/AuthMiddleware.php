<?php
namespace App\Core\Middleware;

use App\Core\Session;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Vui lòng đăng nhập để tiếp tục.');
            $base = (require __DIR__ . '/../../../config/app.php')['base_url'];
            header('Location: ' . $base . '/login');
            exit;
        }
    }
}
