<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<div class="menu" id="menu">
    <link rel="stylesheet" href="style.css">
    <a href="index.php?page=home">Trang chủ</a>
    <a href="index.php?page=login">Đăng nhập</a>
</div>
<?php
$file = "pages/" . $page . ".php";
if (file_exists($file)) {
    include($file);
} else {
    include("pages/home.php");
}
?>