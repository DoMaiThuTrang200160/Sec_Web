<?php
namespace App\Core;

class Database
{
    private static ?\PDO $instance = null;

    public static function getInstance(): \PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/database.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            try {
                self::$instance = new \PDO($dsn, $config['user'], $config['pass'], [
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    // Bắt buộc tắt emulate prepares để prepared statement là THẬT ở tầng MySQL,
                    // đây là lớp phòng thủ cốt lõi chống SQL Injection.
                    \PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (\PDOException $e) {
                Logger::log('error', 'DB connection failed: ' . $e->getMessage());
                http_response_code(500);
                require __DIR__ . '/../Views/errors/500.php';
                exit;
            }
        }
        return self::$instance;
    }
}
