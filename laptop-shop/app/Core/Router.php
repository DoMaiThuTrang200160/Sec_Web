<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, string $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, string $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, string $handler, array $middleware): void
    {
        // /products/detail/{id} -> #^products/detail/([^/]+)$#
        $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', trim($path, '/'));
        $this->routes[] = [
            'method'     => $method,
            'pattern'    => '#^' . $pattern . '$#',
            'handler'    => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = trim($uri, '/');
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            if (preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches);

                foreach ($route['middleware'] as $middlewareClass) {
                    $middlewareClass::handle();
                }

                [$controllerName, $action] = explode('@', $route['handler']);
                $controllerClass = "App\\Controllers\\" . str_replace('/', '\\', $controllerName);

                if (!class_exists($controllerClass) || !method_exists($controllerClass, $action)) {
                    $this->notFound();
                    return;
                }
                $controller = new $controllerClass();
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }
        $this->notFound();
    }

    private function notFound(): void
    {
        http_response_code(404);
        require __DIR__ . '/../Views/errors/404.php';
    }
}
