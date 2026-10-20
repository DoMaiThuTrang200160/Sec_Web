<?php
session_start();
ob_start();
require_once("libs/connectDB.php");
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truy vấn dữ liệu Sinh viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <a href="index.php?page=home" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Trang chủ</a>
    </div>
    <div class="content">
        <h3>TRUY VẤN DỮ LIỆU</h3>
        <div class="layout-container">
            <!-- Cột bên trái: Danh sách lớp -->
            <div class="sidebar">
                <?php include "pages/home.php"; ?>
            </div>
            <!-- Cột bên phải: Danh sách học sinh / Chi tiết -->
            <div class="content-area">
                <?php
                $file = "pages/" . $page . ".php";
                if (file_exists($file) && $page != 'home') {
                    include($file);
                } else {
                    echo "<p class='notice'>
                            Chọn lớp học ở danh sách bên trái để xem danh sách học sinh.
                          </p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
require_once("libs/closeConnectDB.php");
?>