<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo "Người dùng không tồn tại! <a href='userList.php'>Quay lại</a>";
    exit();
}

$imgPath = !empty($user['image'])
    ? $user['image']
    : "https://via.placeholder.com/200";

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin chi tiết người dùng</title>

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
            max-width: 850px;
        }

        .image-box {
            width: 210px;
            flex-shrink: 0;
            text-align: center;
        }

        .image-box img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #D6E0DC;
            display: block;
        }

        .detail-table {
            border-collapse: collapse;
            min-width: 430px;
        }

        .detail-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #EEF3F1;
            vertical-align: top;
        }

        .detail-table td:first-child {
            width: 120px;
            color: #345D6B;
            font-weight: bold;
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
            Thông tin chi tiết người dùng:
            <?= htmlspecialchars($user['username']) ?>
        </h2>

        <div class="detail-layout">

            <div class="image-box">
                <img
                    src="<?= htmlspecialchars($imgPath) ?>"
                    alt="User Avatar"
                >
            </div>

            <table class="detail-table">

                <tr>
                    <td>Username:</td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                </tr>

                <tr>
                    <td>Fullname:</td>
                    <td><?= htmlspecialchars($user['fullname'] ?? '') ?></td>
                </tr>

                <tr>
                    <td>Birthday:</td>
                    <td><?= htmlspecialchars($user['birthday'] ?? '') ?></td>
                </tr>

                <tr>
                    <td>Address:</td>
                    <td><?= nl2br(htmlspecialchars($user['address'] ?? '')) ?></td>
                </tr>

                <tr>
                    <td>Role:</td>
                    <td><?= htmlspecialchars($user['role'] ?? '') ?></td>
                </tr>

            </table>

        </div>

        <a href="userList.php" class="back-link">
            ← Quay lại danh sách người dùng
        </a>

    </main>

</div>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>