<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare(
    "SELECT * FROM category WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$category = $stmt->get_result()->fetch_assoc();

if (!$category) {
    echo "Danh mục không tồn tại! <a href='categoryList.php'>Quay lại</a>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');

    if ($name !== '') {

        $updateStmt = $conn->prepare(
            "UPDATE category
             SET name = ?
             WHERE id = ?"
        );

        $updateStmt->bind_param(
            "si",
            $name,
            $id
        );

        $updateStmt->execute();

        header("Location: categoryList.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>

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

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            padding: 22px 28px;
        }

        .page-title {
            margin: 0 0 20px;
            padding-bottom: 8px;
            border-bottom: 1px solid #D6E0DC;
            color: #345D6B;
            font-size: 20px;
        }

        .form-table {
            width: 100%;
            max-width: 650px;
            border-collapse: collapse;
        }

        .form-table td {
            padding: 7px 5px;
            vertical-align: top;
        }

        .form-label {
            width: 110px;
        }

        .form-control {
            width: 380px;
            padding: 6px 7px;
            border: 1px solid #BFCFCA;
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            outline: none;
        }

        .form-control:focus {
            border-color: #5B8798;
        }

        .form-actions {
            padding-top: 10px !important;
        }

        .btn {
            padding: 6px 15px;
            margin-right: 5px;
            border: 1px solid #BFCFCA;
            background: #FFFFFF;
            color: #404040;
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            cursor: pointer;
        }

        .btn:hover {
            background: #EAF1EF;
        }

        .btn-save {
            background: #5B8798;
            border-color: #5B8798;
            color: #FFFFFF;
        }

        .btn-save:hover {
            background: #345D6B;
        }
    </style>
</head>

<body>

<div class="admin-layout">

    <?php include 'sidebar.php'; ?>

    <main class="content">

        <h2 class="page-title">
            Sửa danh mục:
            <?= htmlspecialchars($category['name']) ?>
        </h2>

        <form method="POST">

            <table class="form-table">

                <tr>
                    <td class="form-label">
                        Tên danh mục:
                    </td>

                    <td>
                        <input
                            type="text"
                            name="name"
                            value="<?= htmlspecialchars($category['name']) ?>"
                            required
                            class="form-control"
                        >
                    </td>
                </tr>

                <tr>
                    <td></td>

                    <td class="form-actions">
                        <input
                            type="reset"
                            value="Reset"
                            class="btn"
                        >

                        <input
                            type="submit"
                            value="Save"
                            class="btn btn-save"
                        >
                    </td>
                </tr>

            </table>

        </form>

    </main>

</div>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>