<?php
namespace App\Models;

class Category extends Model
{
    protected static string $table = 'categories';

    public static function create(array $data): int
    {
        $stmt = self::db()->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        $stmt->execute([$data['name'], $data['slug']]);
        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $stmt = self::db()->prepare("UPDATE categories SET name=?, slug=? WHERE id=?");
        return $stmt->execute([$data['name'], $data['slug'], $id]);
    }
}
