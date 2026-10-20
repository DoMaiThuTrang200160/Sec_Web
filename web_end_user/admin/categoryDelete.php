<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {

    $checkStmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM product
         WHERE category_id = ?"
    );

    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();

    $result = $checkStmt->get_result()->fetch_assoc();

    if ($result['total'] == 0) {

        $deleteStmt = $conn->prepare(
            "DELETE FROM category
             WHERE id = ?"
        );

        $deleteStmt->bind_param("i", $id);
        $deleteStmt->execute();
    }
}

header("Location: categoryList.php");
exit();

?>