<?php
$page = $_GET['page'] ?? 'home';
?>
<div class="menu">
    <link rel="stylesheet" href="style.css">
    <a href="index.php?page=home" class="<?= $page === 'home' ? 'active' : '' ?>">Home</a>
    <a href="index.php?page=register" class="<?= $page === 'register' ? 'active' : '' ?>">Register</a>
    <a href="index.php?page=result_register" class="<?= $page === 'result_register' ? 'active' : '' ?>">ResultRegister</a>
    <a href="index.php?page=calculate" class="<?= $page === 'calculate' ? 'active' : '' ?>">Calculate</a>
</div>
<div class="content">
    <?php
    switch ($page) {
        case 'register':
            include 'pages/register.php';
            break;
        case 'result_register':
            include 'pages/result_register.php';
            break;
        case 'calculate':
            include 'pages/calculate.php';
            break;
        default:
            include 'pages/home.php';
            break;
    }
    ?>
</div>