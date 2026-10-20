<?php
namespace App\Models;

use App\Core\Database;

abstract class Model
{
    protected static string $table = '';

    protected static function db(): \PDO { return Database::getInstance(); }

    public static function all(string $order = 'id DESC'): array
    {
        return self::db()->query("SELECT * FROM " . static::$table . " ORDER BY $order")->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
