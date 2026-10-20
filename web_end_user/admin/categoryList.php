<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$categories = $conn->query(
    "SELECT * FROM category ORDER BY id ASC"
);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Category Manage</title>

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

        .category-table {
            width: 100%;
            border-collapse: collapse;
        }

        .category-table th,
        .category-table td {
            padding: 8px;
            border: 1px solid #D6E0DC;
        }

        .category-table th {
            background: #EEF3F1;
            color: #345D6B;
            font-weight: bold;
        }

        .category-table tr:nth-child(even) {
            background: #FAFCFB;
        }

        .category-table tr:hover {
            background: #F0F5F3;
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

        <h2 class="page-title">Quản lý danh mục</h2>

        <div class="toolbar">
            <a href="categoryAdd.php" class="add-btn">
                + Add new category
            </a>
        </div>

        <table class="category-table">

            <tr>
                <th width="80">ID</th>
                <th>Tên danh mục</th>
                <th width="180">Action</th>
            </tr>

            <?php while ($c = $categories->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($c['id']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($c['name']) ?>
                    </td>

                    <td>
                        <a
                            href="categoryEdit.php?id=<?= $c['id'] ?>"
                            class="action-link"
                        >
                            Sửa
                        </a>

                        &nbsp;|&nbsp;

                        <a
                            href="categoryDelete.php?id=<?= $c['id'] ?>"
                            class="action-link"
                            onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')"
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