<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$products = $conn->query(
    "SELECT
        p.*,
        b.name AS brand_name,
        c.name AS category_name
     FROM product p
     JOIN brand b ON p.brand_id = b.id
     JOIN category c ON p.category_id = c.id
     ORDER BY p.id DESC"
);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Product Manage</title>

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

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            padding: 22px 28px;
            overflow-x: auto;
        }

        .page-title {
            margin: 0 0 18px;
            padding-bottom: 8px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 20px;
        }

        .toolbar {
            margin-bottom: 12px;
            text-align: right;
        }

        .add-btn {
            display: inline-block;
            padding: 6px 13px;
            background: #5B8798;
            border: 1px solid #5B8798;
            color: #FFFFFF;
            text-decoration: none;
            font-size: 13px;
        }

        .add-btn:hover {
            background: #345D6B;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th,
        .product-table td {
            padding: 7px 8px;
            border: 1px solid #D6E0DC;
        }

        .product-table th {
            background: #EEF3F1;
            color: #345D6B;
            font-weight: bold;
        }

        .product-table tr:nth-child(even) {
            background: #FAFCFB;
        }

        .product-table tr:hover {
            background: #F0F5F3;
        }

        .product-table td {
            vertical-align: middle;
        }

        .product-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #D6E0DC;
            display: block;
            margin: auto;
        }

        .price-line {
            white-space: nowrap;
            line-height: 1.6;
        }

        .action-link {
            color: #345D6B;
            text-decoration: none;
        }

        .action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="admin-layout">

    <?php include 'sidebar.php'; ?>

    <main class="content">

        <h2 class="page-title">Quản lý sản phẩm</h2>

        <div class="toolbar">
            <a href="productAdd.php" class="add-btn">
                + Add new product
            </a>
        </div>

        <table class="product-table">

            <tr>
                <th width="50">ID</th>
                <th>Tên sản phẩm</th>
                <th width="100">Thương hiệu</th>
                <th width="120">Danh mục</th>
                <th width="180">Giá</th>
                <th width="110">Hình ảnh</th>
                <th width="190">Action</th>
            </tr>

            <?php while ($p = $products->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($p['id']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($p['name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($p['brand_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($p['category_name']) ?>
                    </td>

                    <td>
                        <div class="price-line">
                            Giá gốc:
                            <?= number_format(
                                $p['price_original'],
                                0,
                                ',',
                                '.'
                            ) ?>
                            VNĐ
                        </div>

                        <div class="price-line">
                            Giá giảm:
                            <?= number_format(
                                $p['price_discount'],
                                0,
                                ',',
                                '.'
                            ) ?>
                            VNĐ
                        </div>
                    </td>

                    <td>
                        <?php
                        $img = !empty($p['image'])
                            ? $p['image']
                            : "https://via.placeholder.com/80";
                        ?>

                        <img
                            src="<?= htmlspecialchars($img) ?>"
                            alt="Product Image"
                            class="product-image"
                        >
                    </td>

                    <td>
                        <a
                            href="productDetail.php?id=<?= $p['id'] ?>"
                            class="action-link"
                        >
                            Chi tiết
                        </a>

                        &nbsp;|&nbsp;

                        <a
                            href="productEdit.php?id=<?= $p['id'] ?>"
                            class="action-link"
                        >
                            Sửa
                        </a>

                        &nbsp;|&nbsp;

                        <a
                            href="productDelete.php?id=<?= $p['id'] ?>"
                            class="action-link"
                            onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                        >
                            Xóa
                        </a>
                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    </main>

</div>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>