<?php
session_start();
ob_start();

require_once "connect.php";

// Xác định trang hiện tại
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý Học sinh & Lớp học</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="menu">

        <a
            href="index.php?page=home"
            class="<?php echo ($page === 'home') ? 'active' : ''; ?>"
        >
            Trang chủ
        </a>

        <a
            href="index.php?page=lop_list"
            class="<?php echo ($page === 'lop_list') ? 'active' : ''; ?>"
        >
            Danh sách Lớp
        </a>

        <a
            href="index.php?page=lop_form"
            class="<?php echo ($page === 'lop_form') ? 'active' : ''; ?>"
        >
            Thêm Lớp mới
        </a>

        <a
            href="index.php?page=hoso_list"
            class="<?php echo ($page === 'hoso_list') ? 'active' : ''; ?>"
        >
            Danh sách Học sinh
        </a>

        <a
            href="index.php?page=hoso_form"
            class="<?php echo ($page === 'hoso_form') ? 'active' : ''; ?>"
        >
            Thêm Học sinh
        </a>

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