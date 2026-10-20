<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare(
    "SELECT * FROM product WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Sản phẩm không tồn tại! <a href='productList.php'>Quay lại</a>";
    exit();
}

$brands = $conn->query(
    "SELECT * FROM brand ORDER BY name ASC"
);

$categories = $conn->query(
    "SELECT * FROM category ORDER BY id ASC"
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $brandId = intval($_POST['brand_id'] ?? 0);
    $categoryId = intval($_POST['category_id'] ?? 0);
    $priceOriginal = trim($_POST['price_original'] ?? '');
    $priceDiscount = trim($_POST['price_discount'] ?? '');
    $specsSummary = trim($_POST['specs_summary'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    $updateStmt = $conn->prepare(
        "UPDATE product
         SET name = ?,
             brand_id = ?,
             category_id = ?,
             price_original = ?,
             price_discount = ?,
             specs_summary = ?,
             description = ?,
             image = ?
         WHERE id = ?"
    );

    $updateStmt->bind_param(
        "siiddsssi",
        $name,
        $brandId,
        $categoryId,
        $priceOriginal,
        $priceDiscount,
        $specsSummary,
        $description,
        $image,
        $id
    );

    $updateStmt->execute();

    header("Location: productList.php");
    exit();
}

$imgPath = !empty($product['image'])
    ? $product['image']
    : "https://via.placeholder.com/150";

?>

<!DOCTYPE html>

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin sản phẩm</title>

```
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

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
        max-width: 850px;
        border-collapse: collapse;
    }

    .form-table td {
        padding: 7px 5px;
        vertical-align: top;
    }

    .form-label {
        width: 130px;
    }

    .form-control {
        width: 480px;
        padding: 6px 7px;
        border: 1px solid #BFCFCA;
        font-family: "Times New Roman", Times, serif;
        font-size: 14px;
        outline: none;
    }

    .form-control:focus {
        border-color: #5B8798;
    }

    select.form-control {
        background: #FFFFFF;
    }

    textarea.form-control {
        resize: vertical;
    }

    .old-image {
        width: 150px;
        height: 120px;
        object-fit: cover;
        display: block;
        margin-bottom: 5px;
        border: 1px solid #D6E0DC;
    }

    .image-note {
        font-size: 12px;
        color: #6F7775;
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

    .description-editor {
        width: 700px;
    }

    .description-editor .ck-editor__editable {
        min-height: 220px;
        font-family: "Times New Roman", Times, serif;
        font-size: 14px;
    }

    .description-editor .ck-toolbar {
        font-family: "Times New Roman", Times, serif;
    }
</style>
```

</head>

<body>

<div class="admin-layout">

```
<?php include 'sidebar.php'; ?>

<main class="content">

    <h2 class="page-title">
        Sửa thông tin sản phẩm:
        <?= htmlspecialchars($product['name']) ?>
    </h2>

    <form method="POST">

        <table class="form-table">

            <tr>
                <td class="form-label">
                    Tên sản phẩm:
                </td>

                <td>
                    <input
                        type="text"
                        name="name"
                        value="<?= htmlspecialchars($product['name']) ?>"
                        required
                        class="form-control"
                    >
                </td>
            </tr>

            <tr>
                <td class="form-label">
                    Thương hiệu:
                </td>

                <td>
                    <select
                        name="brand_id"
                        class="form-control"
                        required
                    >

                        <?php while ($brand = $brands->fetch_assoc()): ?>

                            <option
                                value="<?= $brand['id'] ?>"
                                <?= $brand['id'] == $product['brand_id']
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars($brand['name']) ?>
                            </option>

                        <?php endwhile; ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td class="form-label">
                    Danh mục:
                </td>

                <td>
                    <select
                        name="category_id"
                        class="form-control"
                        required
                    >

                        <?php while ($category = $categories->fetch_assoc()): ?>

                            <option
                                value="<?= $category['id'] ?>"
                                <?= $category['id'] == $product['category_id']
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars($category['name']) ?>
                            </option>

                        <?php endwhile; ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td class="form-label">
                    Giá gốc:
                </td>

                <td>
                    <input
                        type="number"
                        name="price_original"
                        value="<?= htmlspecialchars($product['price_original']) ?>"
                        min="0"
                        step="1"
                        required
                        class="form-control"
                    >
                </td>
            </tr>

            <tr>
                <td class="form-label">
                    Giá giảm:
                </td>

                <td>
                    <input
                        type="number"
                        name="price_discount"
                        value="<?= htmlspecialchars($product['price_discount']) ?>"
                        min="0"
                        step="1"
                        required
                        class="form-control"
                    >
                </td>
            </tr>

            <tr>
                <td class="form-label">
                    Thông số:
                </td>

                <td>
                    <textarea
                        name="specs_summary"
                        rows="5"
                        class="form-control"
                    ><?= htmlspecialchars($product['specs_summary'] ?? '') ?></textarea>
                </td>
            </tr>

            <tr>
                <td class="form-label">
                    Mô tả:
                </td>

                <td>
                    <div class="description-editor">
                        <textarea
                            name="description"
                            id="description"
                        ><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="form-label">
                    Image:
                </td>

                <td>

                    <img
                        src="<?= htmlspecialchars($imgPath) ?>"
                        alt="Ảnh sản phẩm"
                        class="old-image"
                    >

                    <input
                        type="text"
                        name="image"
                        value="<?= htmlspecialchars($product['image'] ?? '') ?>"
                        class="form-control"
                    >

                    <span class="image-note">
                        Nhập đường dẫn ảnh mới hoặc giữ nguyên đường dẫn hiện tại.
                    </span>

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
```

</div>

<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: [
                'heading',
                '|',
                'bold',
                'italic',
                'underline',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'link',
                '|',
                'undo',
                'redo'
            ]
        })
        .catch(error => {
            console.error(error);
        });
</script>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>
