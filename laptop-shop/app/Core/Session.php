<?php

namespace App\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_httponly' => true, // JS không đọc được cookie session -> giảm thiệt hại nếu dính XSS
                'cookie_samesite' => 'Lax', // Giảm rủi ro CSRF gửi kèm cookie từ site khác
            ]);
        }
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, string $message): void
    {
        $_SESSION['_flash'][$key] = $message;
    }
    public static function getFlash(string $key): ?string
    {
        $msg = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $msg;
    }

    // Gọi ngay sau khi login thành công để chống Session Fixation
    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain']);
        }
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return self::has('user_id');
    }
    public static function isAdmin(): bool
    {
        return self::get('user_role') === 'admin';
    }
}
