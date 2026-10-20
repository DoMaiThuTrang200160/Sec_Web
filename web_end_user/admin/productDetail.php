<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare(
    "SELECT
        p.*,
        b.name AS brand_name,
        c.name AS category_name
     FROM product p
     JOIN brand b ON p.brand_id = b.id
     JOIN category c ON p.category_id = c.id
     WHERE p.id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Sản phẩm không tồn tại! <a href='productList.php'>Quay lại</a>";
    exit();
}

$imgPath = !empty($product['image'])
    ? $product['image']
    : "https://via.placeholder.com/200";

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin chi tiết sản phẩm</title>

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
        }

        .page-title {
            margin: 0 0 20px;
            padding-bottom: 8px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 20px;
        }

        .detail-layout {
            display: flex;
            gap: 30px;
            align-items: flex-start;
            max-width: 1000px;
        }

        .image-box {
            width: 220px;
            flex-shrink: 0;
            text-align: center;
        }

        .image-box img {
            width: 210px;
            height: 210px;
            object-fit: cover;
            border: 1px solid #D6E0DC;
            display: block;
        }

        .detail-table {
            border-collapse: collapse;
            min-width: 550px;
        }

        .detail-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #EEF3F1;
            vertical-align: top;
        }

        .detail-table td:first-child {
            width: 140px;
            color: #345D6B;
            font-weight: bold;
        }

        .description {
            max-width: 600px;
            line-height: 1.5;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #345D6B;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="admin-layout">

    <?php include 'sidebar.php'; ?>

    <main class="content">

        <h2 class="page-title">
            Thông tin chi tiết sản phẩm:
            <?= htmlspecialchars($product['name']) ?>
        </h2>

        <div class="detail-layout">

            <div class="image-box">
                <img
                    src="<?= htmlspecialchars($imgPath) ?>"
                    alt="Product Image"
                >
            </div>

            <table class="detail-table">

                <tr>
                    <td>Tên sản phẩm:</td>
                    <td>
                        <?= htmlspecialchars($product['name']) ?>
                    </td>
                </tr>

                <tr>
                    <td>Thương hiệu:</td>
                    <td>
                        <?= htmlspecialchars($product['brand_name']) ?>
                    </td>
                </tr>

                <tr>
                    <td>Danh mục:</td>
                    <td>
                        <?= htmlspecialchars($product['category_name']) ?>
                    </td>
                </tr>

                <tr>
                    <td>Giá gốc:</td>
                    <td>
                        <?= number_format(
                            $product['price_original'],
                            0,
                            ',',
                            '.'
                        ) ?>
                        VNĐ
                    </td>
                </tr>

                <tr>
                    <td>Giá giảm:</td>
                    <td>
                        <?= number_format(
                            $product['price_discount'],
                            0,
                            ',',
                            '.'
                        ) ?>
                        VNĐ
                    </td>
                </tr>

                <tr>
                    <td>Thông số:</td>
                    <td class="description">
                        <?= nl2br(
                            htmlspecialchars(
                                $product['specs_summary'] ?? ''
                            )
                        ) ?>
                    </td>
                </tr>

                <tr>
                    <td>Mô tả:</td>
                    <td class="description">
                        <?= nl2br(
                            htmlspecialchars(
                                $product['description'] ?? ''
                            )
                        ) ?>
                    </td>
                </tr>

            </table>

        </div>

        <a href="productList.php" class="back-link">
            ← Quay lại danh sách sản phẩm
        </a>

    </main>

</div>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>