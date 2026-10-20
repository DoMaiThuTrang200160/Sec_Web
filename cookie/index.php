<?php
session_start();
ob_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <a href="index.php?page=home" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Trang chủ</a>
        <a href="index.php?page=login" class="<?php echo ($page === 'login') ? 'active' : ''; ?>">Đăng nhập</a>
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