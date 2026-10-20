<?php

require_once 'libs/connectDB.php';

$passwords = [
    1 => 'admin',
    2 => 'nguyenvana',
    3 => 'tranthib',
    4 => 'leminhc',
    5 => 'phamduong',
    6 => 'hoanganh',
    7 => 'vuminh',
    8 => 'doanlinh',
    9 => 'nguyenhai',
    10 => 'trankhanh'
];

foreach ($passwords as $id => $password) {

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "UPDATE users SET password = ? WHERE id = ?"
    );

    $stmt->bind_param("si", $hash, $id);
    $stmt->execute();
}

echo "Đã cập nhật mật khẩu.";