<?php
session_start();
ob_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bằng File</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <a href="index.php?page=home" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Home</a>
        <a href="index.php?page=list" class="<?php echo ($page === 'list') ? 'active' : ''; ?>">List</a>
        <a href="index.php?page=add" class="<?php echo ($page === 'add') ? 'active' : ''; ?>">Add</a>
    </div>
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