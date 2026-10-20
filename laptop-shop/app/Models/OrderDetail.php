<?php
namespace App\Models;

class OrderDetail extends Model
{
    protected static string $table = 'order_details';

    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$data['order_id'], $data['product_id'], $data['quantity'], $data['price']]);
        return (int) self::db()->lastInsertId();
    }

    public static function byOrder(int $orderId): array
    {
        $stmt = self::db()->prepare(
            "SELECT od.*, p.name AS product_name, p.image FROM order_details od
             JOIN products p ON p.id = od.product_id WHERE od.order_id = ?"
        );
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
}
