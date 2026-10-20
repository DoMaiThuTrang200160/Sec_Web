<?php
if (isset($_POST['btnLuu'])) {
    $ten      = trim($_POST['txtTen'] ?? '');
    $ngaysinh = trim($_POST['txtNgaySinh'] ?? '');
    $diachi   = trim($_POST['txtDiaChi'] ?? '');
    $lop      = trim($_POST['txtLop'] ?? '');
    $imageName = "default.png";
    // Xử lý upload ảnh
    if (isset($_FILES['fileImage']) && $_FILES['fileImage']['error'] == 0) {
        $fileName = time() . "_" . basename($_FILES['fileImage']['name']);
        $targetPath = "uploads/" . $fileName;
        if (move_uploaded_file($_FILES['fileImage']['tmp_name'], $targetPath)) {
            $imageName = $fileName;
        }
    }
    // Ghi 5 dòng dữ liệu vào file student.txt
    $filePath = "pages/student.txt";
    $content = $ten . "\n" . $ngaysinh . "\n" . $diachi . "\n" . $imageName . "\n" . $lop . "\n";
    $file = fopen($filePath, "a");
    if ($file) {
        fwrite($file, $content);
        fclose($file);
        header("Location: index.php?page=list");
        exit();
    }
}
?>
<h3>THÊM SINH VIÊN MỚI</h3>
<form action="" method="POST" enctype="multipart/form-data">
    <table class="student-form-table">
        <tr>
            <td>Full name:</td>
            <td>
                <input type="text" name="txtTen" required>
            </td>
        </tr>
        <tr>
            <td>Birthday:</td>
            <td>
                <input type="text" name="txtNgaySinh" placeholder="YYYY-MM-DD" required>
            </td>
        </tr>
        <tr>
            <td>Address:</td>
            <td>
                <input type="text" name="txtDiaChi" required>
            </td>
        </tr>
        <tr>
            <td>Image:</td>
            <td>
                <input type="file" name="fileImage" accept="image/*">
            </td>
        </tr>
        <tr>
            <td>Class:</td>
            <td>
                <input type="text" name="txtLop" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="form-buttons">
                <input type="reset" value="Nhập lại">
                <input type="submit" name="btnLuu" value="Lưu">
            </td>
        </tr>
    </table>
</form>