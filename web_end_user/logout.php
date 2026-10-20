<?php

session_start();

// Xóa toàn bộ thông tin Session.
$_SESSION = [];

// Xóa Session cookie nếu có.
if (ini_get("session.use_cookies")) {

    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();

// Xóa Cookie ghi nhớ đăng nhập.
setcookie(
    'admin_logged',
    '',
    time() - 3600,
    "/"
);

// Quay về trang chủ.
header("Location: index.php");
exit();

?>