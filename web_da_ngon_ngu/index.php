<?php
session_start();
ob_start();
// 1. Lấy biến page gửi qua GET hoặc POST
$page = "home";
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}
if (isset($_POST["page"])) {
    $page = $_POST["page"];
}
// 2. Xử lý lưu Session ngôn ngữ khi submit đổi ngôn ngữ
if (isset($_POST["btnEnglish"])) {
    $_SESSION["lang"] = "english";
    header("Location: index.php?page=$page");
    exit();
}
if (isset($_POST["btnVietnamese"])) {
    $_SESSION["lang"] = "vietnamese";
    header("Location: index.php?page=$page");
    exit();
}
// 3. Check Session ngôn ngữ
// Mặc định là English
$lang = "english";
if (isset($_SESSION["lang"])) {
    $lang = $_SESSION["lang"];
}
// 4. Require file ngôn ngữ tương ứng
require_once("lang/" . $lang . ".php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Đa Ngôn Ngữ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Thanh chuyển đổi ngôn ngữ -->
    <div class="lang-bar-container">
        <div class="lang-switch-btns">
            <form method="post" action="">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($page); ?>">
                <input type="submit" name="btnVietnamese" value="Vietnamese">
            </form>
            <form method="post" action="">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($page); ?>">
                <input type="submit" name="btnEnglish" value="English">
            </form>
        </div>
        <!-- Menu của nhiệm vụ 10 -->
        <div class="menu">
            <a href="index.php?page=home" class="<?php echo ($page === 'home') ? 'active' : ''; ?>"><?php echo HOME; ?></a>
            <a href="index.php?page=contact" class="<?php echo ($page === 'contact') ? 'active' : ''; ?>"><?php echo CONTACT; ?></a>
            <a href="index.php?page=introduction" class="<?php echo ($page === 'introduction') ? 'active' : ''; ?>"><?php echo INTRODUCTION; ?></a>
            <a href="index.php?page=login" class="<?php echo ($page === 'login') ? 'active' : ''; ?>"><?php echo LOGIN; ?></a>
        </div>
    </div>
    <!-- Nội dung trang -->
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