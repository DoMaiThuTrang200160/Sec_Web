<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "quanlyhocsinh";
// 1. Kết nối cơ sở dữ liệu
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}
// Thiết lập bảng mã tiếng Việt UTF-8
mysqli_set_charset($conn, 'utf8');
?>