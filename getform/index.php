<?php
$page = $_GET['page'] ?? 'home';
?>
<div class="menu">
    <link rel="stylesheet" href="style.css">
    <a href="index.php?page=home">Home</a>
    <a href="index.php?page=register">Register</a>
    <a href="index.php?page=contact1Page">Contact1Page</a>
</div>
<div class="content">
    <?php
    switch ($page) {
        case 'register':
            include 'pages/register.php';
            break;
        case 'contact1Page':
            include 'pages/contact1Page.php';
            break;
        case 'registerProcess':
            include 'pages/registerProcess.php';
            break;
        case 'home':
        default:
            include 'pages/home.php';
            break;
    }
    ?>
</div>