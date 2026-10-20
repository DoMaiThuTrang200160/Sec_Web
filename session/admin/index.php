<?php
session_start();
// Kiểm tra Session: Nếu chưa đăng nhập thì chặn truy cập
if (($_SESSION['Status'] ?? '') !== 'login') {
    header("Location: ../index.php");
    exit();
}
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<div class="menu" id="menu">
    <a href="index.php?page=home" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Admin Home</a>
    <a href="index.php?page=upload" class="<?php echo ($page === 'upload') ? 'active' : ''; ?>">Upload File</a>
    <a href="index.php?page=logout">Logout</a>
</div>
<?php
$file = "pages/" . $page . ".php";
if (file_exists($file)) {
    include($file);
} else {
    include("pages/home.php");
}
?>