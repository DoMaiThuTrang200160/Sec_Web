<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $passwordInput = trim($_POST['password'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $role = 'user';

    $password = password_hash($passwordInput, PASSWORD_DEFAULT);

    $imageName = '';

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../images/" . $imageName
        );
    }

    $stmt = $conn->prepare(
        "INSERT INTO users
        (username, password, fullname, birthday, address, image, role)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssssss",
        $username,
        $password,
        $fullname,
        $birthday,
        $address,
        $imageName,
        $role
    );

    $stmt->execute();

    header("Location: userList.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm người dùng mới</title>

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
            max-width: 700px;
            border-collapse: collapse;
        }

        .form-table td {
            padding: 7px 5px;
            vertical-align: top;
        }

        .form-label {
            width: 110px;
            color: #404040;
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

        input[type="file"] {
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
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

        <h2 class="page-title">Thêm người dùng mới</h2>

        <form method="POST" enctype="multipart/form-data">

            <table class="form-table">

                <tr>
                    <td class="form-label">Username:</td>
                    <td>
                        <input
                            type="text"
                            name="username"
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
                            required
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
                            placeholder="YYYY-MM-DD"
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
                        ></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">Image:</td>
                    <td>
                        <input type="file" name="image">
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