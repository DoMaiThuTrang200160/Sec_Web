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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (!empty($_POST['password'])) {
        $password = password_hash(
            trim($_POST['password']),
            PASSWORD_DEFAULT
        );
    } else {
        $password = $user['password'];
    }

    $image = $user['image'];

    $updateStmt = $conn->prepare(
        "UPDATE users
         SET username = ?,
             password = ?,
             fullname = ?,
             birthday = ?,
             address = ?,
             image = ?
         WHERE id = ?"
    );

    $updateStmt->bind_param(
        "ssssssi",
        $username,
        $password,
        $fullname,
        $birthday,
        $address,
        $image,
        $id
    );

    $updateStmt->execute();

    header("Location: userList.php");
    exit();
}

$imgPath = !empty($user['image'])
    ? $user['image']
    : "https://via.placeholder.com/150";

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin user</title>

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

        .form-table {
            width: 100%;
            max-width: 760px;
            border-collapse: collapse;
        }

        .form-table td {
            padding: 7px 5px;
            vertical-align: top;
        }

        .form-label {
            width: 110px;
        }

        .form-control {
            width: 380px;
            padding: 6px 7px;
            border: 1px solid #BFCFCA;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            outline: none;
        }

        .form-control:focus {
            border-color: #5B8798;
        }

        textarea.form-control {
            width: 480px;
            resize: vertical;
        }

        .old-image {
            width: 120px;
            height: 100px;
            object-fit: cover;
            display: block;
            margin-bottom: 4px;
            border: 1px solid #D6E0DC;
        }

        .image-note {
            font-size: 12px;
            color: #6F7775;
        }

        .form-actions {
            padding-top: 10px !important;
        }

        .btn {
            padding: 6px 15px;
            margin-right: 5px;
            border: 1px solid #BFCFCA;
            background: #FFFFFF;
            color: #404040;
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            cursor: pointer;
        }

        .btn:hover {
            background: #EAF1EF;
        }

        .btn-save {
            background: #5B8798;
            border-color: #5B8798;
            color: #FFFFFF;
        }

        .btn-save:hover {
            background: #345D6B;
        }
    </style>
</head>

<body>

<div class="admin-layout">

    <?php include 'sidebar.php'; ?>

    <main class="content">

        <h2 class="page-title">
            Sửa thông tin user:
            <?= htmlspecialchars($user['username']) ?>
        </h2>

        <form method="POST">

            <table class="form-table">

                <tr>
                    <td class="form-label">Username:</td>
                    <td>
                        <input
                            type="text"
                            name="username"
                            value="<?= htmlspecialchars($user['username']) ?>"
                            required
                            class="form-control"
                        >
                    </td>
                </tr>

                <tr>
                    <td class="form-label">Password:</td>
                    <td>
                        <input
                            type="password"
                            name="password"
                            placeholder="Để trống nếu không đổi mật khẩu"
                            class="form-control"
                        >
                    </td>
                </tr>

                <tr>
                    <td class="form-label">Fullname:</td>
                    <td>
                        <input
                            type="text"
                            name="fullname"
                            value="<?= htmlspecialchars($user['fullname'] ?? '') ?>"
                            class="form-control"
                        >
                    </td>
                </tr>

                <tr>
                    <td class="form-label">Birthday:</td>
                    <td>
                        <input
                            type="text"
                            name="birthday"
                            value="<?= htmlspecialchars($user['birthday'] ?? '') ?>"
                            class="form-control"
                        >
                    </td>
                </tr>

                <tr>
                    <td class="form-label">Address:</td>
                    <td>
                        <textarea
                            name="address"
                            rows="5"
                            class="form-control"
                        ><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">Image:</td>
                    <td>
                        <img
                            src="<?= htmlspecialchars($imgPath) ?>"
                            alt="Ảnh hiện tại"
                            class="old-image"
                        >

                        <span class="image-note">
                            Ảnh hiện tại
                        </span>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td class="form-actions">
                        <input type="reset" value="Reset" class="btn">
                        <input type="submit" value="Save" class="btn btn-save">
                    </td>
                </tr>

            </table>

        </form>

    </main>

</div>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>