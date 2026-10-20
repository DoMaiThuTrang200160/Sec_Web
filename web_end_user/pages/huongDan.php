<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Hướng dẫn sử dụng</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            color: #404040;
            background: #FFFFFF;
        }

        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 74px;
            padding: 8px 24px;
            border-bottom: 1px solid #D6E0DC;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #345D6B;
            text-decoration: none;
        }

        .logo-symbol {
            width: 42px;
            height: 42px;
        }

        .logo-text {
            line-height: 1.05;
        }

        .logo-name {
            display: block;
            font-size: 19px;
            font-weight: bold;
        }

        .logo-subtitle {
            display: block;
            margin-top: 3px;
            color: #6F7775;
            font-size: 10px;
            letter-spacing: 1px;
        }

        .main-menu {
            display: flex;
        }

        .main-menu a {
            position: relative;
            padding: 25px 11px 23px;
            color: #404040;
            text-decoration: none;
        }

        .main-menu a:hover {
            color: #345D6B;
        }

        .main-menu a.active {
            color: #345D6B;
            font-weight: bold;
        }

        .main-menu a.active::after {
            content: "";
            position: absolute;
            left: 11px;
            right: 11px;
            bottom: 15px;
            height: 2px;
            background: #5B8798;
        }

        .account-area {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .top-link {
            padding: 5px 10px;
            border: 1px solid #BFCFCA;
            color: #404040;
            text-decoration: none;
            font-size: 13px;
        }

        .top-link:hover {
            background: #EAF1EF;
            color: #345D6B;
        }

        .cart-link {
            border-color: #5B8798;
            color: #345D6B;
        }

        .content {
            padding: 25px 28px;
        }

        .page-title {
            margin: 0 0 20px;
            padding-bottom: 9px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 22px;
        }

        .content-text {
            max-width: 900px;
            line-height: 1.7;
        }

    </style>

</head>

<body>

<header class="top-header">

    <div class="header-left">

        <a href="../index.php" class="logo">

            <svg class="logo-symbol" viewBox="0 0 48 48"
                 xmlns="http://www.w3.org/2000/svg">

                <rect x="4" y="4" width="40" height="40" rx="8"
                      fill="#EEF3F1" stroke="#5B8798" stroke-width="2"/>

                <path d="M12 17.5C12 15.57 13.57 14 15.5 14H32.5C34.43 14 36 15.57 36 17.5V28.5C36 30.43 34.43 32 32.5 32H15.5C13.57 32 12 30.43 12 28.5V17.5Z"
                      fill="#FFFFFF" stroke="#345D6B" stroke-width="2"/>

                <path d="M9 35H39"
                      stroke="#345D6B" stroke-width="2"/>

                <path d="M19 35L20.5 38H27.5L29 35"
                      fill="none" stroke="#5B8798" stroke-width="2"/>

            </svg>

            <span class="logo-text">
                <span class="logo-name">LAPTOP STORE</span>
                <span class="logo-subtitle">ONLINE SHOPPING</span>
            </span>

        </a>

        <nav class="main-menu">

            <a href="../index.php">
                Trang chủ
            </a>

            <a href="huongDan.php" class="active">
                Hướng dẫn
            </a>

            <a href="gioiThieu.php">
                Giới thiệu
            </a>

            <a href="lienHe.php">
                Liên hệ
            </a>

            <a href="gopY.php">
                Góp ý / Khiếu nại
            </a>

        </nav>

    </div>

    <div class="account-area">

        <a href="../gioHang.php" class="top-link cart-link">
            Giỏ hàng
        </a>

        <a href="../login.php" class="top-link">
            Đăng nhập Admin
        </a>

    </div>

</header>

<main class="content">

    <h1 class="page-title">
        Hướng dẫn
    </h1>

    <div class="content-text">
        Đây là trang hướng dẫn sử dụng website mua sắm trực tuyến.
    </div>

    <div class="content-text">
        ...
    </div>

</main>

</body>
</html>