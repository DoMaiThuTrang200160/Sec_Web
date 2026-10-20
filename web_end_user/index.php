<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION['admin_logged']) &&
    isset($_COOKIE['admin_logged'])
) {
    $_SESSION['admin_logged'] = $_COOKIE['admin_logged'];
}

require_once 'libs/connectDB.php';

$selectedBrandId = isset($_GET['brand_id'])
    ? intval($_GET['brand_id'])
    : 0;

$brands = $conn->query(
    "SELECT * FROM brand ORDER BY name"
);

$categories = $conn->query(
    "SELECT * FROM category ORDER BY name"
);

$sql = "
    SELECT
        p.*,
        b.name AS brand_name,
        c.name AS category_name
    FROM product p
    JOIN brand b ON p.brand_id = b.id
    JOIN category c ON p.category_id = c.id
";

if ($selectedBrandId > 0) {
    $sql .= " WHERE p.brand_id = " . $selectedBrandId;
}

$sql .= " ORDER BY p.id DESC";

$products = $conn->query($sql);

$selectedBrandName = "";

if ($selectedBrandId > 0 && $brands) {
    $brands->data_seek(0);

    while ($brand = $brands->fetch_assoc()) {
        if ((int)$brand['id'] === $selectedBrandId) {
            $selectedBrandName = $brand['name'];
            break;
        }
    }

    $brands->data_seek(0);
}

$cartCount = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum($_SESSION['cart']);
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Kinh doanh Online - Laptop</title>

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

        /* ================= HEADER ================= */

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
            flex-shrink: 0;
        }

        .logo-symbol {
            width: 42px;
            height: 42px;
            display: block;
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
            gap: 2px;
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
            font-size: 13px;
            flex-shrink: 0;
        }

        .account-name {
            color: #345D6B;
        }

        .top-link {
            padding: 5px 10px;
            border: 1px solid #BFCFCA;
            color: #404040;
            text-decoration: none;
            white-space: nowrap;
        }

        .top-link:hover {
            background: #EAF1EF;
            color: #345D6B;
        }

        .top-link.primary {
            background: #5B8798;
            border-color: #5B8798;
            color: #FFFFFF;
        }

        .top-link.primary:hover {
            background: #345D6B;
        }

        .cart-link {
            border-color: #5B8798;
            color: #345D6B;
        }

        /* ================= SEARCH ================= */

        .search-bar {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 9px 24px;
            border-bottom: 1px solid #D6E0DC;
            background: #F6F8F6;
        }

        .search-label {
            color: #345D6B;
            font-weight: bold;
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .search-input,
        .category-select {
            padding: 5px 7px;
            border: 1px solid #BFCFCA;
            background: #FFFFFF;
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
        }

        .search-input {
            width: 270px;
        }

        .category-select {
            width: 180px;
        }

        .search-btn {
            padding: 5px 13px;
            border: 1px solid #5B8798;
            background: #5B8798;
            color: #FFFFFF;
            font-family: "Times New Roman", Times, serif;
            cursor: pointer;
        }

        .search-btn:hover {
            background: #345D6B;
        }

        /* ================= MAIN ================= */

        .main-layout {
            display: flex;
            min-height: calc(100vh - 125px);
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 220px;
            padding: 15px 13px;
            border-right: 1px solid #D6E0DC;
            background: #EEF3F1;
            flex-shrink: 0;
        }

        .sidebar-title {
            margin-bottom: 12px;
            padding-bottom: 7px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 15px;
            font-weight: bold;
        }

        .support-list {
            margin-bottom: 18px;
            padding: 8px;
            border: 1px solid #D6E0DC;
            background: #FFFFFF;
        }

        .support-item {
            display: flex;
            justify-content: space-between;
            gap: 5px;
            padding: 6px 0;
            border-bottom: 1px solid #EEF3F1;
            font-size: 12px;
        }

        .support-item:last-child {
            border-bottom: 0;
        }

        .online {
            color: #345D6B;
            font-size: 11px;
            font-weight: bold;
        }

        .offline {
            color: #6F7775;
            font-size: 11px;
        }

        /* ================= CATEGORY ================= */

        .category-box {
            margin-bottom: 18px;
            padding: 9px;
            border: 1px solid #D6E0DC;
            background: #FFFFFF;
        }

        .category-title {
            margin-bottom: 6px;
            padding-bottom: 7px;
            border-bottom: 1px solid #EEF3F1;
            color: #345D6B;
            font-size: 13px;
            font-weight: bold;
        }

        .category-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .category-list li {
            border-bottom: 1px solid #EEF3F1;
        }

        .category-list li:last-child {
            border-bottom: 0;
        }

        .category-list a {
            display: block;
            padding: 7px 5px;
            color: #404040;
            text-decoration: none;
            font-size: 13px;
        }

        .category-list a:hover {
            background: #F6F8F6;
            color: #345D6B;
        }

        .category-list a.active {
            background: #EAF1EF;
            color: #345D6B;
            font-weight: bold;
        }

        .category-all {
            color: #345D6B !important;
        }

        /* ================= ADVERTISEMENT ================= */

        .advertisement {
            padding: 9px;
            border: 1px solid #D6E0DC;
            background: #FFFFFF;
        }

        .advertisement-title {
            margin-bottom: 8px;
            color: #345D6B;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        .advertisement-content {
            padding: 12px;
            background: #EAF1EF;
            color: #345D6B;
            font-weight: bold;
            line-height: 1.6;
            text-align: center;
        }

        /* ================= CONTENT ================= */

        .content {
            flex: 1;
            padding: 20px 26px;
        }

        .page-title {
            margin: 0 0 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 21px;
        }

        .product-count {
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #EEF3F1;
            color: #6F7775;
        }

        .selected-category {
            color: #345D6B;
        }

        .product-item {
            display: flex;
            gap: 20px;
            max-width: 1000px;
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #D6E0DC;
            background: #FFFFFF;
        }

        .product-item:hover {
            background: #FAFCFB;
        }

        .product-image-area {
            width: 155px;
            flex-shrink: 0;
            text-align: center;
        }

        .product-image {
            width: 150px;
            height: 105px;
            object-fit: contain;
            border: 1px solid #EEF3F1;
        }

        .detail-link {
            display: inline-block;
            margin-top: 5px;
            color: #345D6B;
            font-size: 12px;
            text-decoration: none;
        }

        .detail-link:hover {
            text-decoration: underline;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            margin: 0 0 5px;
            color: #345D6B;
            font-size: 16px;
        }

        .product-name a {
            color: inherit;
            text-decoration: none;
        }

        .product-name a:hover {
            text-decoration: underline;
        }

        .vat-note {
            margin: 0 0 8px;
            color: #6F7775;
            font-size: 12px;
        }

        .specs {
            padding: 9px 11px;
            border-left: 3px solid #5B8798;
            background: #F6F8F6;
            font-size: 13px;
            line-height: 1.6;
        }

        .specs ul {
            margin: 0;
            padding-left: 18px;
        }

        .price {
            color: #345D6B;
            font-weight: bold;
        }

        .cart-add-form {
            margin-top: 10px;
        }

        .cart-add-btn {
            padding: 6px 13px;
            border: 1px solid #5B8798;
            background: #5B8798;
            color: #FFFFFF;
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            cursor: pointer;
        }

        .cart-add-btn:hover {
            background: #345D6B;
        }

        .empty {
            padding: 20px;
            border: 1px solid #D6E0DC;
            background: #FAFCFB;
            color: #6F7775;
            text-align: center;
        }

        @media (max-width: 1050px) {

            .top-header {
                flex-wrap: wrap;
                gap: 5px;
            }

            .header-left {
                width: 100%;
            }

            .account-area {
                margin-left: auto;
            }

        }

        @media (max-width: 800px) {

            .top-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
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

            .search-bar {
                flex-wrap: wrap;
            }

            .search-form {
                flex-wrap: wrap;
            }

            .main-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: 0;
                border-bottom: 1px solid #D6E0DC;
            }

            .product-item {
                flex-direction: column;
            }

        }

    </style>

</head>

<body>

<header class="top-header">

    <div class="header-left">

        <a href="index.php" class="logo">

            <svg
                class="logo-symbol"
                viewBox="0 0 48 48"
                xmlns="http://www.w3.org/2000/svg"
                aria-label="Logo"
            >
                <rect
                    x="4"
                    y="4"
                    width="40"
                    height="40"
                    rx="8"
                    fill="#EEF3F1"
                    stroke="#5B8798"
                    stroke-width="2"
                />

                <path
                    d="M12 17.5C12 15.57 13.57 14 15.5 14H32.5C34.43 14 36 15.57 36 17.5V28.5C36 30.43 34.43 32 32.5 32H15.5C13.57 32 12 30.43 12 28.5V17.5Z"
                    fill="#FFFFFF"
                    stroke="#345D6B"
                    stroke-width="2"
                />

                <path
                    d="M9 35H39"
                    stroke="#345D6B"
                    stroke-width="2"
                    stroke-linecap="round"
                />

                <path
                    d="M19 35L20.5 38H27.5L29 35"
                    fill="none"
                    stroke="#5B8798"
                    stroke-width="2"
                    stroke-linecap="round"
                />

                <path
                    d="M19 20H29"
                    stroke="#5B8798"
                    stroke-width="2"
                    stroke-linecap="round"
                />

                <path
                    d="M19 24H26"
                    stroke="#5B8798"
                    stroke-width="2"
                    stroke-linecap="round"
                />
            </svg>

            <span class="logo-text">
                <span class="logo-name">LAPTOP STORE</span>
                <span class="logo-subtitle">ONLINE SHOPPING</span>
            </span>

        </a>

        <nav class="main-menu">

            <a href="index.php" class="active">
                Trang chủ
            </a>

            <a href="pages/huongDan.php">
                Hướng dẫn
            </a>

            <a href="pages/gioiThieu.php">
                Giới thiệu
            </a>

            <a href="pages/lienHe.php">
                Liên hệ
            </a>

            <a href="pages/gopY.php">
                Góp ý / Khiếu nại
            </a>

        </nav>

    </div>

    <div class="account-area">

        <a href="gioHang.php" class="top-link cart-link">
            Giỏ hàng (<?= $cartCount ?>)
        </a>

        <?php if (isset($_SESSION['admin_logged'])): ?>

            <span class="account-name">
                Xin chào,
                <strong>
                    <?= htmlspecialchars($_SESSION['admin_logged']) ?>
                </strong>
            </span>

            <a href="admin/index.php" class="top-link primary">
                Quản trị
            </a>

            <a
                href="logout.php"
                class="top-link"
                onclick="return confirm('Bạn muốn đăng xuất?')"
            >
                Đăng xuất
            </a>

        <?php else: ?>

            <a href="login.php" class="top-link">
                Đăng nhập Admin
            </a>

        <?php endif; ?>

    </div>

</header>

<div class="search-bar">

    <span class="search-label">
        Tìm kiếm:
    </span>

    <form
        action="pages/productSearch.php"
        method="GET"
        class="search-form"
    >

        <input
            type="text"
            name="keyword"
            placeholder="Nhập thông tin tìm kiếm"
            class="search-input"
        >

        <select
            name="cat_id"
            class="category-select"
        >

            <option value="">
                Tất cả danh mục
            </option>

            <?php
            if ($categories && $categories->num_rows > 0):
                while ($cat = $categories->fetch_assoc()):
            ?>

                <option value="<?= $cat['id'] ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </option>

            <?php
                endwhile;
                $categories->data_seek(0);
            endif;
            ?>

        </select>

        <button type="submit" class="search-btn">
            Tìm kiếm
        </button>

    </form>

</div>

<div class="main-layout">

    <aside class="sidebar">

        <div class="sidebar-title">
            KINH DOANH ONLINE
        </div>

        <div class="support-list">

            <div class="support-item">
                <span>Kinh doanh</span>
                <span class="online">Online Now</span>
            </div>

            <div class="support-item">
                <span>Kinh doanh</span>
                <span class="online">Online Now</span>
            </div>

            <div class="support-item">
                <span>Hỗ trợ kỹ thuật</span>
                <span class="offline">Not online</span>
            </div>

        </div>

        <div class="category-box">

            <div class="category-title">
                THƯƠNG HIỆU
            </div>

            <ul class="category-list">

                <li>
                    <a
                        href="index.php"
                        class="category-all <?= $selectedBrandId === 0 ? 'active' : '' ?>"
                    >
                        Tất cả sản phẩm
                    </a>
                </li>

                <?php
                if ($brands && $brands->num_rows > 0):
                    while ($brand = $brands->fetch_assoc()):
                ?>

                    <li>

                        <a
                            href="index.php?brand_id=<?= $brand['id'] ?>"
                            class="<?= $selectedBrandId == $brand['id'] ? 'active' : '' ?>"
                        >
                            <?= htmlspecialchars($brand['name']) ?>
                        </a>

                    </li>

                <?php
                    endwhile;
                endif;
                ?>

            </ul>

        </div>

        <div class="advertisement">

            <div class="advertisement-title">
                QUẢNG CÁO
            </div>

            <div class="advertisement-content">

                MUA LAPTOP<br>
                XÀI TRƯỚC,<br>
                TRẢ TIỀN SAU!

                <br><br>

                LAPTOP TRẢ GÓP

            </div>

        </div>

    </aside>

    <main class="content">

        <h2 class="page-title">

            <?php if ($selectedBrandId > 0 && $selectedBrandName): ?>

                <?= htmlspecialchars($selectedBrandName) ?>

            <?php else: ?>

                Danh sách sản phẩm

            <?php endif; ?>

        </h2>

        <div class="product-count">

            Products found:

            <strong>
                <?= $products ? $products->num_rows : 0 ?>
            </strong>

            <?php if ($selectedBrandId > 0 && $selectedBrandName): ?>

                <span class="selected-category">
                    — Thương hiệu:
                    <?= htmlspecialchars($selectedBrandName) ?>
                </span>

            <?php endif; ?>

        </div>

        <?php if ($products && $products->num_rows > 0): ?>

            <?php while ($p = $products->fetch_assoc()): ?>

                <?php

                $imgSrc = !empty($p['image'])
                    ? $p['image']
                    : "https://via.placeholder.com/300x200";

                ?>

                <div class="product-item">

                    <div class="product-image-area">

                        <a href="pages/productDetail.php?id=<?= $p['id'] ?>">

                            <img
                                src="<?= htmlspecialchars($imgSrc) ?>"
                                alt="<?= htmlspecialchars($p['name']) ?>"
                                class="product-image"
                            >

                        </a>

                        <a
                            href="pages/productDetail.php?id=<?= $p['id'] ?>"
                            class="detail-link"
                        >
                            Xem chi tiết →
                        </a>

                    </div>

                    <div class="product-info">

                        <h3 class="product-name">

                            <a href="pages/productDetail.php?id=<?= $p['id'] ?>">

                                <?= htmlspecialchars($p['name']) ?>

                            </a>

                        </h3>

                        <p class="vat-note">
                            (Chưa bao gồm 10% VAT)
                        </p>

                        <div class="specs">

                            <ul>

                                <li>
                                    <strong>Thương hiệu:</strong>

                                    <?= htmlspecialchars(
                                        $p['brand_name'] ?? 'Đang cập nhật'
                                    ) ?>
                                </li>

                                <li>
                                    <strong>Nhu cầu:</strong>

                                    <?= htmlspecialchars(
                                        $p['category_name'] ?? 'Đang cập nhật'
                                    ) ?>
                                </li>

                                <li>
                                    <strong>Cấu hình:</strong>

                                    <?= htmlspecialchars(
                                        $p['specs_summary'] ?? 'Đang cập nhật'
                                    ) ?>
                                </li>

                                <li>
                                    <strong>Mô tả ngắn:</strong>

                                    <?= htmlspecialchars(
                                        mb_strimwidth(
                                            $p['description'] ?? '',
                                            0,
                                            120,
                                            '...'
                                        )
                                    ) ?>
                                </li>

                                <li>
                                    <strong>Giá bán:</strong>

                                    <span class="price">

                                        <?= number_format(
                                            $p['price_discount'] ?? $p['price_original'],
                                            0,
                                            ',',
                                            '.'
                                        ) ?>

                                        VNĐ

                                    </span>

                                </li>

                            </ul>

                        </div>

                        <form
                            action="gioHang.php"
                            method="POST"
                            class="cart-add-form"
                        >

                            <input
                                type="hidden"
                                name="action"
                                value="add"
                            >

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?= $p['id'] ?>"
                            >

                            <input
                                type="hidden"
                                name="quantity"
                                value="1"
                            >

                            <button
                                type="submit"
                                class="cart-add-btn"
                            >
                                Thêm vào giỏ hàng
                            </button>

                        </form>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="empty">
                Không có sản phẩm nào.
            </div>

        <?php endif; ?>

    </main>

</div>

</body>
</html>

<?php require_once 'libs/closeConnectDB.php'; ?>