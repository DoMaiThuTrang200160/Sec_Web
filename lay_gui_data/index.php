<?php
$page = $_GET['page'] ?? 'home';
?>
<style>
    .menu {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 14px 25px;
        background-color: #FFFFFF;
        border-bottom: 1px solid #D6E0DC;
        gap: 22px;
    }
    .menu a {
        display: inline-block;
        color: #404040;
        text-decoration: none;
        font-family: "Times New Roman", serif;
        font-size: 14px;
        font-weight: bold;
        padding: 7px 2px;
        border-bottom: 2px solid transparent;
        transition: 0.3s;
    }
    .menu a:hover {
        color: #5B8798;
        border-bottom-color: #5B8798;
    }
    .menu a.active {
        color: #5B8798;
        border-bottom-color: #5B8798;
    }
    .content {
        padding: 25px 30px;
        min-height: 300px;
        background-color: #FFFFFF;
        color: #404040;
    }
    .content h1, .content h2, .content h3, .content h4 {
        color: #345D6B;
    }
    .content input, .content select, .content textarea {
        font-family: "Times New Roman", serif;
    }
</style>
<div class="menu">
    <link rel="stylesheet" href="style.css">
    <a href="index.php?page=home">Home</a>
    <a href="index.php?page=drawTable">DrawTable</a>
    <a href="index.php?page=calculate1">Calculate1</a>
    <a href="index.php?page=calculate2"> Calculate2</a>
    <a href="index.php?page=array1">Array1</a>
    <a href="index.php?page=array2">Array2</a>
</div>
<div class="content">
    <?php
    switch ($page) {
        case 'drawTable':
            include 'pages/drawTable.php';
            break;
        case 'calculate1':
            include 'pages/calculate1.php';
            break;
        case 'calculate2':
            include 'pages/calculate2.php';
            break;
        case 'array1':
            include 'pages/array1.php';
            break;
        case 'array2':
            include 'pages/array2.php';
            break;
        case 'uploadprocess':
            include 'pages/uploadprocess.php';
            break;
        case 'home':
        default:
            include 'pages/home.php';
            break;
    }
    ?>
</div>