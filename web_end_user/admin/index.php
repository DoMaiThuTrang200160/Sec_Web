<?php
require_once '../libs/checkLogin.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            color: #404040;
            background: #ffffff;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .admin-content {
            flex: 1;
            padding: 22px 28px;
        }

        .page-title {
            margin: 0 0 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 21px;
            font-weight: bold;
        }

        .welcome {
            margin: 18px 0 8px;
        }

        .welcome strong {
            color: #5B8798;
        }

        .description {
            margin: 0 0 16px;
            line-height: 1.6;
        }

        .function-list {
            margin: 0;
            padding-left: 24px;
            line-height: 1.9;
        }

        .function-list strong {
            color: #345D6B;
        }
    </style>
</head>

<body>

<div class="admin-layout">

    <?php include 'sidebar.php'; ?>

    <main class="admin-content">

        <h2 class="page-title">Trang quản trị hệ thống</h2>

        <p class="welcome">
            Xin chào,
            <strong><?= htmlspecialchars($_SESSION['admin_logged']) ?></strong>!
        </p>

        <p class="description">
            Chào mừng bạn đến với bảng điều khiển quản trị.
            Vui lòng chọn một trong các chức năng ở menu bên trái để tiếp tục:
        </p>

        <ul class="function-list">
            <li>
                <strong>Users Manage:</strong>
                Quản lý danh sách người dùng, xem chi tiết, thêm, sửa và xóa tài khoản.
            </li>
            <li>
                <strong>Categories:</strong>
                Quản lý các danh mục sản phẩm.
            </li>
            <li>
                <strong>Products:</strong>
                Quản lý danh sách sản phẩm.
            </li>
            <li>
                <strong>Return Home:</strong>
                Quay trở lại trang chủ cửa hàng.
            </li>
            <li>
                <strong>Logout:</strong>
                Đăng xuất khỏi phiên làm việc Admin.
            </li>
        </ul>

    </main>

</div>

</body>
</html>