<?php
session_start();
ob_start();
// Include thư viện các hàm toán học
require_once 'libs/math.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Function</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <a href="index.php?page=home" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Home</a>
        <a href="index.php?page=ar1Chieu" class="<?php echo ($page === 'ar1Chieu') ? 'active' : ''; ?>">Mảng 1 chiều</a>
        <a href="index.php?page=matrix" class="<?php echo ($page === 'matrix') ? 'active' : ''; ?>">Matrix</a>
        <a href="index.php?page=associateArray" class="<?php echo ($page === 'associateArray') ? 'active' : ''; ?>">AssociateArr</a>
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