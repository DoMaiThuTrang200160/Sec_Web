<?php
namespace App\Core;

class Request
{
    public static function method(): string { return $_SERVER['REQUEST_METHOD']; }

    public static function uri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = (require __DIR__ . '/../../config/app.php')['base_url'];
        if ($base !== '' && strpos($uri, $base) === 0) {
            $uri = substr($uri, strlen($base));
        }
        return '/' . trim($uri, '/');
    }

    // Lấy input và trim chuỗi; KHÔNG tự escape ở đây - escape khi in ra View (htmlspecialchars),
    // vì escape sớm quá sẽ làm sai lệch dữ liệu trước khi validate/lưu DB.
    public static function input(string $key, $default = null)
    {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        return is_string($value) ? trim($value) : $value;
    }

    public static function all(): array { return array_merge($_GET, $_POST); }
    public static function file(string $key): ?array { return $_FILES[$key] ?? null; }

    public static function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
