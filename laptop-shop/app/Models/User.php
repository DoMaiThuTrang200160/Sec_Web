<?php
namespace App\Models;

class User extends Model
{
    protected static string $table = 'users';

    public static function findByEmail(string $email): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            "INSERT INTO users (username, email, password, full_name, role) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['username'],
            $data['email'],
            // Không bao giờ lưu mật khẩu dạng plain-text hay tự mã hoá md5/sha1
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['full_name'],
            $data['role'] ?? 'customer',
        ]);
        return (int) self::db()->lastInsertId();
    }

    public static function updateProfile(int $id, array $data): bool
    {
        $stmt = self::db()->prepare("UPDATE users SET username=?, email=?, full_name=?, role=? WHERE id=?");
        return $stmt->execute([$data['username'], $data['email'], $data['full_name'], $data['role'], $id]);
    }
}
