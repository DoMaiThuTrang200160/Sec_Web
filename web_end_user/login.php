<?php

session_start();

require_once 'libs/connectDB.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if (
        $user &&
        password_verify($password, $user['password'])
    ) {

        if (
            !isset($user['role']) ||
            $user['role'] !== 'admin'
        ) {

            $error = "Tài khoản của bạn không có quyền truy cập Admin!";

        } else {

            $_SESSION['admin_logged'] = $user['username'];

            if (isset($_POST['remember'])) {

                setcookie(
                    'admin_logged',
                    $user['username'],
                    time() + 86400,
                    "/"
                );

            }

            header("Location: admin/userList.php");
            exit();
        }

    } else {

        $error = "Tài khoản hoặc mật khẩu không chính xác!";

    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #EEF3F1;
            font-family: "Times New Roman", Times, serif;
            color: #404040;
        }

        .login-box {
            width: 350px;
            padding: 22px;
            border: 1px solid #D6E0DC;
            background: #FFFFFF;
        }

        .login-title {
            margin: 0 0 18px;
            padding-bottom: 9px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 20px;
            text-align: center;
        }

        .error {
            margin-bottom: 14px;
            padding: 7px 9px;
            border: 1px solid #D6BFBF;
            background: #FAF4F4;
            color: #8A4444;
            font-size: 13px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 13px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #345D6B;
            font-weight: bold;
        }

        .form-input {
            width: 100%;
            padding: 7px;
            border: 1px solid #BFCFCA;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            outline: none;
        }

        .form-input:focus {
            border-color: #5B8798;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 17px;
            font-size: 13px;
        }

        .login-btn {
            width: 100%;
            padding: 7px;
            border: 1px solid #5B8798;
            background: #5B8798;
            color: #FFFFFF;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #345D6B;
        }
    </style>
</head>

<body>

<form method="POST" class="login-box">

    <h2 class="login-title">
        ĐĂNG NHẬP ADMIN
    </h2>

    <?php if ($error): ?>

        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <div class="form-group">

        <label for="username">
            Username:
        </label>

        <input
            id="username"
            type="text"
            name="username"
            required
            class="form-input"
        >

    </div>

    <div class="form-group">

        <label for="password">
            Password:
        </label>

        <input
            id="password"
            type="password"
            name="password"
            required
            class="form-input"
        >

    </div>

    <div class="remember">

        <input
            type="checkbox"
            name="remember"
            id="remember"
        >

        <label for="remember">
            Ghi nhớ đăng nhập
        </label>

    </div>

    <button type="submit" class="login-btn">
        Đăng nhập
    </button>

</form>

</body>
</html>

<?php require_once 'libs/closeConnectDB.php'; ?>