<?php

session_start();

require_once 'libs/connectDB.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'add'
) {
    $product_id = intval($_POST['product_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 1);

    if ($product_id > 0 && $quantity > 0) {

        $stmt = $conn->prepare(
            "SELECT id FROM product WHERE id = ?"
        );

        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        if ($stmt->get_result()->fetch_assoc()) {

            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        }

        $stmt->close();
    }

    header("Location: gioHang.php");
    exit();
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'update'
) {
    if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {

        foreach ($_POST['quantity'] as $product_id => $quantity) {

            $product_id = intval($product_id);
            $quantity = intval($quantity);

            if ($product_id <= 0) {
                continue;
            }

            if ($quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        }
    }

    header("Location: gioHang.php");
    exit();
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'remove'
) {
    $product_id = intval($_POST['product_id'] ?? 0);

    if ($product_id > 0) {
        unset($_SESSION['cart'][$product_id]);
    }

    header("Location: gioHang.php");
    exit();
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'clear'
) {
    $_SESSION['cart'] = [];

    header("Location: gioHang.php");
    exit();
}

$cartProducts = [];
$totalAmount = 0;
$totalQuantity = 0;

if (!empty($_SESSION['cart'])) {

    $productIds = array_filter(
        array_map('intval', array_keys($_SESSION['cart'])),
        function ($id) {
            return $id > 0;
        }
    );

    if (!empty($productIds)) {

        $idList = implode(',', $productIds);

        $sql = "
            SELECT p.*, c.name AS category_name
            FROM product p
            JOIN category c ON p.category_id = c.id
            WHERE p.id IN ($idList)
            ORDER BY p.id DESC
        ";

        $result = $conn->query($sql);

        if ($result) {

            while ($product = $result->fetch_assoc()) {

                $productId = intval($product['id']);

                $quantity = intval(
                    $_SESSION['cart'][$productId] ?? 0
                );

                if ($quantity <= 0) {
                    continue;
                }

                $unitPrice = !empty($product['price_discount'])
                    ? (float) $product['price_discount']
                    : (float) $product['price_original'];

                $subtotal = $unitPrice * $quantity;

                $product['quantity'] = $quantity;
                $product['unit_price'] = $unitPrice;
                $product['subtotal'] = $subtotal;

                $cartProducts[] = $product;

                $totalAmount += $subtotal;
                $totalQuantity += $quantity;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>

    <meta charset="UTF-8">

    <title>Giỏ hàng</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            color: #404040;
            background: #FFFFFF;
        }

        .page {
            padding: 22px 28px;
        }

        .page-title {
            margin: 0 0 18px;
            padding-bottom: 8px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 21px;
        }

        .cart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .cart-count {
            color: #6F7775;
        }

        .cart-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            display: inline-block;
            padding: 6px 13px;
            border: 1px solid #5B8798;
            background: #FFFFFF;
            color: #345D6B;
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }

        .action-btn:hover {
            background: #EAF1EF;
        }

        .clear-btn {
            border-color: #A96A6A;
            color: #8A4444;
        }

        .clear-btn:hover {
            background: #FAF4F4;
        }

        .cart-table {
            width: 100%;
            max-width: 1100px;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            padding: 8px;
            border: 1px solid #D6E0DC;
            vertical-align: middle;
        }

        .cart-table th {
            background: #EEF3F1;
            color: #345D6B;
            font-weight: bold;
        }

        .cart-table tr:nth-child(even) {
            background: #FAFCFB;
        }

        .cart-image {
            width: 100px;
            height: 75px;
            object-fit: contain;
            border: 1px solid #EEF3F1;
            background: #FFFFFF;
        }

        .product-name {
            color: #345D6B;
            font-weight: bold;
        }

        .product-category {
            margin-top: 3px;
            color: #6F7775;
            font-size: 12px;
        }

        .quantity-input {
            width: 60px;
            padding: 5px;
            border: 1px solid #BFCFCA;
            font-family: "Times New Roman", Times, serif;
            text-align: center;
        }

        .price {
            color: #345D6B;
            font-weight: bold;
        }

        .remove-btn {
            padding: 5px 9px;
            border: 1px solid #B98B8B;
            background: #FFFFFF;
            color: #8A4444;
            font-family: "Times New Roman", Times, serif;
            cursor: pointer;
        }

        .remove-btn:hover {
            background: #FAF4F4;
        }

        .cart-footer {
            max-width: 1100px;
            margin-top: 18px;
            padding-top: 14px;
            border-top: 1px solid #D6E0DC;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .update-btn {
            padding: 7px 15px;
            border: 1px solid #5B8798;
            background: #5B8798;
            color: #FFFFFF;
            font-family: "Times New Roman", Times, serif;
            cursor: pointer;
        }

        .update-btn:hover {
            background: #345D6B;
        }

        .total {
            color: #345D6B;
            font-size: 18px;
            font-weight: bold;
        }

        .empty {
            max-width: 700px;
            padding: 20px;
            border: 1px solid #D6E0DC;
            background: #FAFCFB;
            color: #6F7775;
            text-align: center;
        }

        .empty a {
            display: inline-block;
            margin-top: 12px;
            color: #345D6B;
            text-decoration: none;
        }

        .empty a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

<main class="page">

    <h2 class="page-title">
        Giỏ hàng
    </h2>

    <?php if (!empty($cartProducts)): ?>

        <div class="cart-header">

            <div class="cart-count">
                Có
                <strong><?= $totalQuantity ?></strong>
                sản phẩm trong giỏ hàng
            </div>

            <div class="cart-actions">

                <a
                    href="index.php"
                    class="action-btn"
                >
                    ← Tiếp tục mua hàng
                </a>

                <form method="POST" style="margin: 0;">

                    <input
                        type="hidden"
                        name="action"
                        value="clear"
                    >

                    <button
                        type="submit"
                        class="action-btn clear-btn"
                        onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')"
                    >
                        Xóa giỏ hàng
                    </button>

                </form>

            </div>

        </div>

        <form
            method="POST"
            id="update-cart-form"
        >

            <input
                type="hidden"
                name="action"
                value="update"
            >

            <table class="cart-table">

                <tr>
                    <th width="60">STT</th>
                    <th width="120">Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th width="140">Đơn giá</th>
                    <th width="110">Số lượng</th>
                    <th width="150">Thành tiền</th>
                    <th width="80">Xóa</th>
                </tr>

                <?php foreach ($cartProducts as $index => $product): ?>

                    <?php
                    $imgSrc = !empty($product['image'])
                        ? $product['image']
                        : "https://via.placeholder.com/150x100";
                    ?>

                    <tr>

                        <td style="text-align: center;">
                            <?= $index + 1 ?>
                        </td>

                        <td style="text-align: center;">

                            <img
                                src="<?= htmlspecialchars($imgSrc) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="cart-image"
                            >

                        </td>

                        <td>

                            <div class="product-name">
                                <?= htmlspecialchars($product['name']) ?>
                            </div>

                            <div class="product-category">
                                <?= htmlspecialchars($product['category_name']) ?>
                            </div>

                        </td>

                        <td class="price">

                            <?= number_format(
                                $product['unit_price'],
                                0,
                                ',',
                                '.'
                            ) ?>

                            VNĐ

                        </td>

                        <td style="text-align: center;">

                            <input
                                type="number"
                                name="quantity[<?= $product['id'] ?>]"
                                value="<?= $product['quantity'] ?>"
                                min="0"
                                class="quantity-input"
                            >

                        </td>

                        <td class="price">

                            <?= number_format(
                                $product['subtotal'],
                                0,
                                ',',
                                '.'
                            ) ?>

                            VNĐ

                        </td>

                        <td style="text-align: center;">

                            <button
                                type="button"
                                class="remove-btn"
                                onclick="removeProduct(<?= $product['id'] ?>)"
                            >
                                Xóa
                            </button>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

            <div class="cart-footer">

                <button
                    type="submit"
                    class="update-btn"
                >
                    Cập nhật giỏ hàng
                </button>

                <div class="total">

                    Tổng tiền:
                    <?= number_format(
                        $totalAmount,
                        0,
                        ',',
                        '.'
                    ) ?>

                    VNĐ

                </div>

            </div>

        </form>

        <form
            method="POST"
            id="remove-form"
            style="display: none;"
        >

            <input
                type="hidden"
                name="action"
                value="remove"
            >

            <input
                type="hidden"
                name="product_id"
                id="remove-product-id"
            >

        </form>

    <?php else: ?>

        <div class="empty">

            Giỏ hàng hiện đang trống.

            <br>

            <a href="index.php">
                ← Quay lại trang chính để chọn sản phẩm
            </a>

        </div>

    <?php endif; ?>

</main>

<script>
function removeProduct(productId) {

    document.getElementById('remove-product-id').value = productId;

    document.getElementById('remove-form').submit();
}
</script>

</body>
</html>

<?php require_once 'libs/closeConnectDB.php'; ?>