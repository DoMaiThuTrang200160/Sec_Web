<?php
namespace App\Models;

class Order extends Model
{
    protected static string $table = 'orders';

    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            "INSERT INTO orders (user_id, full_name, phone, address, total) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$data['user_id'], $data['full_name'], $data['phone'], $data['address'], $data['total']]);
        return (int) self::db()->lastInsertId();
    }

    public static function byUser(int $userId): array
    {
        $stmt = self::db()->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function withDetails(int $id): ?array
    {
        $order = self::find($id);
        if (!$order) {
            return null;
        }
        $order['items'] = OrderDetail::byOrder($id);
        return $order;
    }

    public static function updateStatus(int $id, string $status): bool
    {
        $stmt = self::db()->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // Lọc theo khoảng ngày cho trang Admin (kết hợp datetime picker ở giao diện)
    public static function filter(?string $from, ?string $to): array
    {
        $sql = "SELECT * FROM orders WHERE 1=1";
        $params = [];
        if ($from) { $sql .= " AND created_at >= ?"; $params[] = $from . ' 00:00:00'; }
        if ($to)   { $sql .= " AND created_at <= ?"; $params[] = $to . ' 23:59:59'; }
        $sql .= " ORDER BY id DESC";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function countAll(): int
    {
        return (int) self::db()->query("SELECT COUNT(*) c FROM orders")->fetch()['c'];
    }

    public static function sumRevenue(): float
    {
        return (float) self::db()->query("SELECT COALESCE(SUM(total),0) s FROM orders WHERE status != 'cancelled'")->fetch()['s'];
    }
}
