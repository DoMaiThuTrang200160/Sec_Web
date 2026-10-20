<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$users = $conn->query(
    "SELECT * FROM users ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Users Manage</title>

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

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th,
        .user-table td {
            padding: 7px 8px;
            border: 1px solid #D6E0DC;
        }

        .user-table th {
            background: #EEF3F1;
            color: #345D6B;
            font-weight: bold;
        }

        .user-table tr:nth-child(even) {
            background: #FAFCFB;
        }

        .user-table tr:hover {
            background: #F0F5F3;
        }

        .user-table td {
            vertical-align: middle;
        }

        .user-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #D6E0DC;
            display: block;
            margin: auto;
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

        <h2 class="page-title">Quản lý người dùng</h2>

        <div class="toolbar">
            <a href="userAdd.php" class="add-btn">
                + Add new user
            </a>
        </div>

        <table class="user-table">

            <tr>
                <th width="50">ID</th>
                <th>Username</th>
                <th>Fullname</th>
                <th width="110">Image</th>
                <th width="190">Action</th>
            </tr>

            <?php while ($u = $users->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($u['id']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($u['username']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($u['fullname']) ?>
                    </td>

                    <td>
                        <?php
                        $img = !empty($u['image'])
                            ? $u['image']
                            : "https://via.placeholder.com/80";
                        ?>

                        <img
                            src="<?= htmlspecialchars($img) ?>"
                            alt="User Image"
                            class="user-image"
                        >
                    </td>

                    <td>
                        <a
                            href="userDetail.php?id=<?= $u['id'] ?>"
                            class="action-link"
                        >
                            Chi tiết
                        </a>

                        &nbsp;|&nbsp;

                        <a
                            href="userEdit.php?id=<?= $u['id'] ?>"
                            class="action-link"
                        >
                            Sửa
                        </a>

                        &nbsp;|&nbsp;

                        <a
                            href="userDelete.php?id=<?= $u['id'] ?>"
                            class="action-link"
                            onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')"
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