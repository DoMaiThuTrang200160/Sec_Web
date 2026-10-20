<?php

require_once '../libs/connectDB.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare(
    "SELECT p.*, c.name AS category_name
     FROM product p
     JOIN category c ON p.category_id = c.id
     WHERE p.id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Sản phẩm không tồn tại!";
    exit;
}

$imgSrc = !empty($product['image'])
    ? $product['image']
    : "https://via.placeholder.com/500x350";

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title><?= htmlspecialchars($product['name']) ?></title>

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

        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 74px;
            padding: 8px 24px;
            border-bottom: 1px solid #D6E0DC;
            background: #FFFFFF;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #345D6B;
            text-decoration: none;
        }

        .logo-symbol {
            width: 42px;
            height: 42px;
        }

        .logo-text {
            line-height: 1.05;
        }

        .logo-name {
            display: block;
            font-size: 19px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .logo-subtitle {
            display: block;
            margin-top: 3px;
            color: #6F7775;
            font-size: 10px;
            letter-spacing: 1px;
        }

        .main-menu {
            display: flex;
            align-items: center;
        }

        .main-menu a {
            position: relative;
            padding: 25px 11px 23px;
            color: #404040;
            text-decoration: none;
            white-space: nowrap;
        }

        .main-menu a:hover {
            color: #345D6B;
        }

        .main-menu a.active {
            color: #345D6B;
            font-weight: bold;
        }

        .main-menu a.active::after {
            content: "";
            position: absolute;
            left: 11px;
            right: 11px;
            bottom: 15px;
            height: 2px;
            background: #5B8798;
        }

        .account-area {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .account-name {
            color: #345D6B;
            font-size: 13px;
        }

        .top-link {
            padding: 5px 10px;
            border: 1px solid #BFCFCA;
            color: #404040;
            text-decoration: none;
            font-size: 13px;
        }

        .top-link:hover {
            background: #EAF1EF;
            color: #345D6B;
        }

        .cart-link {
            border-color: #5B8798;
            color: #345D6B;
        }

        .page {
            padding: 22px 28px;
        }

        .back-link,
        .cart-link-page {
            display: inline-block;
            margin-bottom: 18px;
            color: #345D6B;
            text-decoration: none;
        }

        .back-link:hover,
        .cart-link-page:hover {
            text-decoration: underline;
        }

        .cart-link-page {
            margin-left: 18px;
        }

        .page-title {
            margin: 0 0 8px;
            color: #345D6B;
            font-size: 22px;
        }

        .category {
            margin: 0 0 18px;
            color: #6F7775;
        }

        .product-layout {
            display: flex;
            gap: 30px;
            max-width: 1000px;
            align-items: flex-start;
        }

        .product-image {
            width: 400px;
            height: 300px;
            border: 1px solid #D6E0DC;
            padding: 10px;
            object-fit: contain;
            background: #FAFCFB;
        }

        .product-info {
            flex: 1;
            max-width: 600px;
        }

        .price {
            margin-bottom: 18px;
            color: #345D6B;
            font-size: 20px;
            font-weight: bold;
        }

        .info-block {
            margin-bottom: 18px;
            padding: 12px;
            border: 1px solid #D6E0DC;
            background: #FAFCFB;
        }

        .info-title {
            margin: 0 0 8px;
            color: #345D6B;
            font-size: 15px;
        }

        .info-text {
            margin: 0;
            line-height: 1.6;
        }

        .cart-form {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .quantity-label {
            color: #345D6B;
            font-weight: bold;
        }

        .quantity-input {
            width: 55px;
            padding: 7px;
            border: 1px solid #BFCFCA;
            font-family: "Times New Roman", Times, serif;
            text-align: center;
        }

        .buy-btn {
            padding: 7px 16px;
            background: #5B8798;
            border: 1px solid #5B8798;
            color: #FFFFFF;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            cursor: pointer;
        }

        .buy-btn:hover {
            background: #345D6B;
        }

        .description {
            max-width: 1000px;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #D6E0DC;
        }

        .description h3 {
            margin: 0 0 8px;
            color: #345D6B;
        }

        .description p {
            line-height: 1.7;
            margin: 0;
        }

        @media (max-width: 1000px) {

            .top-header {
                flex-wrap: wrap;
                gap: 8px;
            }

            .header-left {
                flex-wrap: wrap;
            }

        }

        @media (max-width: 800px) {

            .top-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .main-menu {
                flex-wrap: wrap;
            }

            .main-menu a {
                padding: 8px 9px;
            }

            .main-menu a.active::after {
                bottom: 3px;
            }

            .product-layout {
                flex-direction: column;
            }

            .product-image {
                width: 100%;
                max-width: 500px;
            }

        }

    </style>

</head>

<body>

<header class="top-header">

    <div class="header-left">

        <a href="../index.php" class="logo">

            <svg
                class="logo-symbol"
                viewBox="0 0 48 48"
                xmlns="http://www.w3.org/2000/svg"
            >
                <rect x="4" y="4" width="40" height="40" rx="8"
                      fill="#EEF3F1" stroke="#5B8798" stroke-width="2"/>

                <path d="M12 17.5C12 15.57 13.57 14 15.5 14H32.5C34.43 14 36 15.57 36 17.5V28.5C36 30.43 34.43 32 32.5 32H15.5C13.57 32 12 30.43 12 28.5V17.5Z"
                      fill="#FFFFFF" stroke="#345D6B" stroke-width="2"/>

                <path d="M9 35H39"
                      stroke="#345D6B" stroke-width="2" stroke-linecap="round"/>

                <path d="M19 35L20.5 38H27.5L29 35"
                      fill="none" stroke="#5B8798" stroke-width="2" stroke-linecap="round"/>

                <path d="M19 20H29"
                      stroke="#5B8798" stroke-width="2" stroke-linecap="round"/>

                <path d="M19 24H26"
                      stroke="#5B8798" stroke-width="2" stroke-linecap="round"/>
            </svg>

            <span class="logo-text">
                <span class="logo-name">LAPTOP STORE</span>
                <span class="logo-subtitle">ONLINE SHOPPING</span>
            </span>

        </a>

        <nav class="main-menu">

            <a href="../index.php">
                Trang chủ
            </a>

            <a href="huongDan.php">
                Hướng dẫn
            </a>

            <a href="gioiThieu.php">
                Giới thiệu
            </a>

            <a href="lienHe.php">
                Liên hệ
            </a>

            <a href="gopY.php">
                Góp ý / Khiếu nại
            </a>

        </nav>

    </div>

    <div class="account-area">

        <a href="../gioHang.php" class="top-link cart-link">
            Giỏ hàng
        </a>

        <?php if (isset($_SESSION['admin_logged'])): ?>

            <span class="account-name">
                Xin chào,
                <strong>
                    <?= htmlspecialchars($_SESSION['admin_logged']) ?>
                </strong>
            </span>

            <a href="../admin/index.php" class="top-link">
                Quản trị
            </a>

            <a
                href="../logout.php"
                class="top-link"
                onclick="return confirm('Bạn muốn đăng xuất?')"
            >
                Đăng xuất
            </a>

        <?php else: ?>

            <a href="../login.php" class="top-link">
                Đăng nhập Admin
            </a>

        <?php endif; ?>

    </div>

</header>

<main class="page">

    <a href="../index.php" class="back-link">
        ← Quay lại danh sách sản phẩm
    </a>

    <a href="../gioHang.php" class="cart-link-page">
        Xem giỏ hàng
    </a>

    <h1 class="page-title">
        <?= htmlspecialchars($product['name']) ?>
    </h1>

    <p class="category">
        Danh mục:
        <strong>
            <?= htmlspecialchars($product['category_name']) ?>
        </strong>
    </p>

    <div class="product-layout">

        <img
            src="<?= htmlspecialchars($imgSrc) ?>"
            alt="<?= htmlspecialchars($product['name']) ?>"
            class="product-image"
        >

        <div class="product-info">

            <div class="price">
                Giá bán:

                <?= number_format(
                    $product['price_discount'] ?? $product['price_original'],
                    0,
                    ',',
                    '.'
                ) ?>

                VNĐ
            </div>

            <div class="info-block">

                <h3 class="info-title">
                    Thông số kỹ thuật
                </h3>

                <p class="info-text">
                    <?= htmlspecialchars($product['specs_summary'] ?? '') ?>
                </p>

            </div>

            <form
                action="../gioHang.php"
                method="POST"
                class="cart-form"
            >

                <input
                    type="hidden"
                    name="action"
                    value="add"
                >

                <input
                    type="hidden"
                    name="product_id"
                    value="<?= $product['id'] ?>"
                >

                <label
                    for="quantity"
                    class="quantity-label"
                >
                    Số lượng:
                </label>

                <input
                    id="quantity"
                    type="number"
                    name="quantity"
                    value="1"
                    min="1"
                    class="quantity-input"
                >

                <button
                    type="submit"
                    class="buy-btn"
                >
                    THÊM VÀO GIỎ HÀNG
                </button>

            </form>

        </div>

    </div>

    <section class="description">

        <h3>Mô tả sản phẩm</h3>

        <p>
            <?= nl2br(
                htmlspecialchars($product['description'] ?? '')
            ) ?>
        </p>

    </section>

</main>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>