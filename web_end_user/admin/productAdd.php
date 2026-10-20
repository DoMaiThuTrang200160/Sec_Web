<?php

require_once '../libs/checkLogin.php';
require_once '../libs/connectDB.php';

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

    $stmt = $conn->prepare(
        "INSERT INTO product
        (name, brand_id, category_id, price_original, price_discount, specs_summary, description, image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "siiddsss",
        $name,
        $brandId,
        $categoryId,
        $priceOriginal,
        $priceDiscount,
        $specsSummary,
        $description,
        $image
    );

    $stmt->execute();

    header("Location: productList.php");
    exit();
}

?>

<!DOCTYPE html>

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm mới</title>

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
        color: #404040;
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
```

</head>

<body>

<div class="admin-layout">

```
<?php include 'sidebar.php'; ?>

<main class="content">

    <h2 class="page-title">Thêm sản phẩm mới</h2>

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
                        <option value="">-- Chọn thương hiệu --</option>

                        <?php while ($brand = $brands->fetch_assoc()): ?>

                            <option value="<?= $brand['id'] ?>">
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
                        <option value="">-- Chọn danh mục --</option>

                        <?php while ($category = $categories->fetch_assoc()): ?>

                            <option value="<?= $category['id'] ?>">
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
                    ></textarea>
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
                            class="form-control"
                        ></textarea>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="form-label">
                    Image:
                </td>

                <td>
                    <input
                        type="text"
                        name="image"
                        placeholder="Nhập đường dẫn ảnh"
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
        .then(editor => {
            console.log('CKEditor loaded successfully.');
        })
        .catch(error => {
            console.error('CKEditor error:', error);
        });
</script>

</body>
</html>

<?php require_once '../libs/closeConnectDB.php'; ?>
