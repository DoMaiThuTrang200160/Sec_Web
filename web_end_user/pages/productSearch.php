<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../libs/connectDB.php';

$keyword = $_GET['keyword'] ?? '';

$cat_id = isset($_GET['cat_id'])
    ? intval($_GET['cat_id'])
    : 0;

$categories = $conn->query(
    "SELECT * FROM category ORDER BY name"
);

$sql = "
    SELECT p.*, c.name AS category_name
    FROM product p
    JOIN category c ON p.category_id = c.id
    WHERE 1 = 1
";

if (!empty($keyword)) {

    $safe_keyword = $conn->real_escape_string($keyword);

    $sql .= "
        AND (
            p.name LIKE '%$safe_keyword%'
            OR p.specs_summary LIKE '%$safe_keyword%'
        )
    ";
}

if ($cat_id > 0) {
    $sql .= " AND p.category_id = $cat_id";
}

$sql .= " ORDER BY p.id DESC";

$results = $conn->query($sql);

$selectedCategoryName = "";

if ($cat_id > 0 && $categories) {

    $categories->data_seek(0);

    while ($cat = $categories->fetch_assoc()) {

        if ((int)$cat['id'] === $cat_id) {
            $selectedCategoryName = $cat['name'];
            break;
        }

    }

    $categories->data_seek(0);
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

    <title>Kết quả tìm kiếm</title>

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
            flex-shrink: 0;
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

        /* ================= PAGE ================= */

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

        .search-form {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid #D6E0DC;
        }

        .search-form label {
            color: #345D6B;
            font-weight: bold;
        }

        .search-input,
        .category-select {
            padding: 6px 7px;
            border: 1px solid #BFCFCA;
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
        }

        .search-input {
            width: 260px;
        }

        .category-select {
            width: 180px;
        }

        .search-btn,
        .home-btn {
            padding: 6px 14px;
            border: 1px solid #5B8798;
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }

        .search-btn {
            background: #5B8798;
            color: #FFFFFF;
        }

        .search-btn:hover {
            background: #345D6B;
        }

        .home-btn {
            background: #FFFFFF;
            color: #345D6B;
        }

        .home-btn:hover {
            background: #EAF1EF;
        }

        .result-count {
            margin-bottom: 14px;
            color: #6F7775;
        }

        .selected-category {
            color: #345D6B;
        }

        /* ================= RESULT ================= */

        .result-item {
            display: flex;
            gap: 20px;
            max-width: 950px;
            margin-bottom: 14px;
            padding: 12px;
            border: 1px solid #D6E0DC;
            background: #FFFFFF;
        }

        .result-item:hover {
            background: #FAFCFB;
        }

        .result-image-area {
            width: 145px;
            flex-shrink: 0;
            text-align: center;
        }

        .result-image {
            width: 140px;
            height: 100px;
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

        .result-info {
            flex: 1;
        }

        .product-name {
            margin: 0 0 8px;
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

        .specs {
            padding: 9px 11px;
            border-left: 3px solid #5B8798;
            background: #F6F8F6;
            font-size: 13px;
            line-height: 1.6;
        }

        .price {
            margin-top: 5px;
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
            padding: 18px;
            border: 1px solid #D6E0DC;
            background: #FAFCFB;
            color: #6F7775;
        }

        @media (max-width: 1050px) {

            .top-header {
                flex-wrap: wrap;
                gap: 8px;
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

            .search-form {
                flex-wrap: wrap;
            }

            .result-item {
                flex-direction: column;
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

                <span class="logo-name">
                    LAPTOP STORE
                </span>

                <span class="logo-subtitle">
                    ONLINE SHOPPING
                </span>

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
            Giỏ hàng (<?= $cartCount ?>)
        </a>

        <?php if (isset($_SESSION['admin_logged'])): ?>

            <span class="account-name">
                Xin chào,
                <strong>
                    <?= htmlspecialchars($_SESSION['admin_logged']) ?>
                </strong>
            </span>

            <a href="../admin/index.php" class="top-link primary">
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

    <h2 class="page-title">

        <?php if ($cat_id > 0 && $selectedCategoryName): ?>

            <?= htmlspecialchars($selectedCategoryName) ?>

        <?php elseif (!empty($keyword)): ?>

            Kết quả tìm kiếm

        <?php else: ?>

            Danh sách sản phẩm

        <?php endif; ?>

    </h2>

    <form
        action="productSearch.php"
        method="GET"
        class="search-form"
    >

        <label for="keyword">
            Tìm kiếm:
        </label>

        <input
            id="keyword"
            type="text"
            name="keyword"
            value="<?= htmlspecialchars($keyword) ?>"
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

                <option
                    value="<?= $cat['id'] ?>"
                    <?= $cat_id == $cat['id'] ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($cat['name']) ?>
                </option>

            <?php
                endwhile;
            endif;
            ?>

        </select>

        <button
            type="submit"
            class="search-btn"
        >
            Tìm kiếm
        </button>

        <a
            href="../index.php"
            class="home-btn"
        >
            ← Về trang chính
        </a>

    </form>

    <div class="result-count">

        Tìm thấy:

        <strong>
            <?= $results ? $results->num_rows : 0 ?>
        </strong>

        sản phẩm

        <?php if ($cat_id > 0 && $selectedCategoryName): ?>

            <span class="selected-category">
                — Danh mục:
                <?= htmlspecialchars($selectedCategoryName) ?>
            </span>

        <?php endif; ?>

    </div>

    <?php if ($results && $results->num_rows > 0): ?>

        <?php while ($row = $results->fetch_assoc()): ?>

            <?php

            $imgSrc = !empty($row['image'])
                ? $row['image']
                : "https://via.placeholder.com/300x200";

            ?>

            <div class="result-item">

                <div class="result-image-area">

                    <img
                        src="<?= htmlspecialchars($imgSrc) ?>"
                        alt="<?= htmlspecialchars($row['name']) ?>"
                        class="result-image"
                    >

                    <a
                        href="productDetail.php?id=<?= $row['id'] ?>"
                        class="detail-link"
                    >
                        Xem chi tiết →
                    </a>

                </div>

                <div class="result-info">

                    <h3 class="product-name">

                        <a href="productDetail.php?id=<?= $row['id'] ?>">

                            <?= htmlspecialchars($row['name']) ?>

                        </a>

                    </h3>

                    <div class="specs">

                        <div>

                            <strong>Cấu hình:</strong>

                            <?= htmlspecialchars(
                                $row['specs_summary'] ?? 'Đang cập nhật'
                            ) ?>

                        </div>

                        <div class="price">

                            Giá:

                            <?= number_format(
                                $row['price_discount'] ?? $row['price_original'],
                                0,
                                ',',
                                '.'
                            ) ?>

                            VNĐ

                        </div>

                    </div>

                    <form
                        action="../gioHang.php"
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
                            value="<?= $row['id'] ?>"
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
            Không tìm thấy sản phẩm nào phù hợp.
        </div>

    <?php endif; ?>

</main>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>