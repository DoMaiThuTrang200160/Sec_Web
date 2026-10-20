<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Khôi phục trạng thái đăng nhập từ Cookie nếu Session không còn.
if (
    !isset($_SESSION['admin_logged']) &&
    isset($_COOKIE['admin_logged'])
) {
    $_SESSION['admin_logged'] = $_COOKIE['admin_logged'];
}

// Chưa đăng nhập thì chuyển về trang login.
if (!isset($_SESSION['admin_logged'])) {
    header("Location: ../login.php");
    exit();
}

?>