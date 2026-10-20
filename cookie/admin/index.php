<?php
session_start();
ob_start();
// Kiểm tra bảo mật: Nếu chưa đăng nhập thì không cho vào trang Admin
if (!isset($_SESSION['Username'])) {
    echo "<h3>Bạn chưa đăng nhập! Không được phép truy cập.</h3>";
    header("Location: ../index.php");
    exit();
}
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Administrator - Cookie</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="menu">
        <a href="index.php?page=home" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Admin Home & Favorite Web Links</a>
        <a href="index.php?page=upload" class="<?php echo ($page === 'upload') ? 'active' : ''; ?>">Upload</a>
        <a href="index.php?page=logout">Logout</a>
    </div>
    <div class="content">
        <?php
        $file = "pages/" . $page . ".php";
        if (file_exists($file)) {
            include($file);
        } else {
            include("pages/home.php");
        }
        ?>
    </div>
</body>
</html>