<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {

    $stmt = $conn->prepare(
        "DELETE FROM product WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: productList.php");
exit();

?>