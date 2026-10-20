<?php
namespace App\Core;

abstract class Controller
{
    // Render 1 view HTML, bọc trong layout (main cho end-user, admin cho trang quản trị)
    protected function render(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data);
        $viewFile = __DIR__ . "/../Views/$view.php";
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        require __DIR__ . "/../Views/layouts/$layout.php";
    }

    // Trả JSON - dùng cho các endpoint gọi qua AJAX (jQuery), ví dụ cart/add
    protected function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $path): void
    {
        $base = (require __DIR__ . '/../../config/app.php')['base_url'];
        header('Location: ' . $base . $path);
        exit;
    }
}
