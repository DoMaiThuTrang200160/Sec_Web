<?php
// Autoloader thủ công đơn giản: App\Models\User -> app/Models/User.php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strpos($class, $prefix) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . '/app/' . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
