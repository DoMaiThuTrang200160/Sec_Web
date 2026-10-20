<?php
namespace App\Models;

class Product extends Model
{
    protected static string $table = 'products';

    public static function paginate(?int $categoryId, int $page = 1, int $perPage = 9): array
    {
        $offset = ($page - 1) * $perPage;
        if ($categoryId) {
            $stmt = self::db()->prepare(
                "SELECT p.*, c.name AS category_name FROM products p
                 JOIN categories c ON c.id = p.category_id
                 WHERE p.category_id = ? ORDER BY p.id DESC LIMIT ? OFFSET ?"
            );
            $stmt->bindValue(1, $categoryId, \PDO::PARAM_INT);
            $stmt->bindValue(2, $perPage, \PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, \PDO::PARAM_INT);
        } else {
            $stmt = self::db()->prepare(
                "SELECT p.*, c.name AS category_name FROM products p
                 JOIN categories c ON c.id = p.category_id
                 ORDER BY p.id DESC LIMIT ? OFFSET ?"
            );
            $stmt->bindValue(1, $perPage, \PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, \PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function latestByCategory(int $categoryId, int $limit = 2): array
    {
        $stmt = self::db()->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY id DESC LIMIT ?");
        $stmt->bindValue(1, $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // LIKE với tham số bind - vẫn an toàn chống SQLi vì dùng prepared statement,
    // KHÔNG bao giờ nối chuỗi $keyword trực tiếp vào câu SQL.
    public static function search(string $keyword, ?int $minPrice = null, ?int $maxPrice = null): array
    {
        $sql = "SELECT p.*, c.name AS category_name FROM products p
                JOIN categories c ON c.id = p.category_id
                WHERE p.name LIKE ?";
        $params = ['%' . $keyword . '%'];

        if ($minPrice !== null) { $sql .= " AND p.price >= ?"; $params[] = $minPrice; }
        if ($maxPrice !== null) { $sql .= " AND p.price <= ?"; $params[] = $maxPrice; }
        $sql .= " ORDER BY p.id DESC";

        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            "INSERT INTO products (category_id, name, slug, price, discount_price, description, image, brand)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['category_id'], $data['name'], $data['slug'], $data['price'],
            $data['discount_price'] ?: null, $data['description'], $data['image'], $data['brand'],
        ]);
        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $stmt = self::db()->prepare(
            "UPDATE products SET category_id=?, name=?, slug=?, price=?, discount_price=?, description=?, image=?, brand=? WHERE id=?"
        );
        return $stmt->execute([
            $data['category_id'], $data['name'], $data['slug'], $data['price'],
            $data['discount_price'] ?: null, $data['description'], $data['image'], $data['brand'], $id,
        ]);
    }
}
