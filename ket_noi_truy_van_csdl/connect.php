<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "quanlyhocsinh";

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$conn) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, 'UTF8');

?>