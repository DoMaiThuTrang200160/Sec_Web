<?php
namespace App\Models;

use App\Core\Session;

// Giỏ hàng lưu trong Session (không cần bảng DB riêng) - phù hợp cho cả khách chưa đăng nhập.
// Cấu trúc lưu: ['product_id' => quantity, ...]
class Cart
{
    private const KEY = 'cart';

    public static function all(): array
    {
        return Session::get(self::KEY, []);
    }

    public static function add(int $productId, int $qty = 1): void
    {
        $cart = self::all();
        $cart[$productId] = ($cart[$productId] ?? 0) + $qty;
        Session::set(self::KEY, $cart);
    }

    public static function update(int $productId, int $qty): void
    {
        $cart = self::all();
        if ($qty <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $qty;
        }
        Session::set(self::KEY, $cart);
    }

    public static function remove(int $productId): void
    {
        $cart = self::all();
        unset($cart[$productId]);
        Session::set(self::KEY, $cart);
    }

    public static function clear(): void
    {
        Session::remove(self::KEY);
    }

    // Lấy chi tiết giỏ hàng kèm thông tin sản phẩm mới nhất từ DB (giá luôn đúng thời điểm hiện tại)
    public static function items(): array
    {
        $items = [];
        foreach (self::all() as $productId => $qty) {
            $product = Product::find((int) $productId);
            if ($product) {
                $items[] = [
                    'product'  => $product,
                    'quantity' => $qty,
                    'subtotal' => $product['price'] * $qty,
                ];
            }
        }
        return $items;
    }

    public static function total(): float
    {
        return array_sum(array_column(self::items(), 'subtotal'));
    }

    public static function count(): int
    {
        return array_sum(self::all());
    }
}
