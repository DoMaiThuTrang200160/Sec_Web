<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;
$file = "pages/student.txt";
if (!file_exists($file)) {
    echo "<p class='no-data'>Chưa có dữ liệu sinh viên.</p>";
    exit;
}
$lines = file($file, FILE_IGNORE_NEW_LINES);
$startIndex = $id * 5;
if ($id < 0 || $startIndex + 4 >= count($lines)) {
    echo "<p class='no-data'>Không tìm thấy sinh viên.</p>";
    exit;
}
$name = $lines[$startIndex];
$birthday = $lines[$startIndex + 1];
$address = $lines[$startIndex + 2];
$image = $lines[$startIndex + 3];
$class = $lines[$startIndex + 4];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $class = $_POST['class'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }
    $lines[$startIndex] = $name;
    $lines[$startIndex + 1] = $birthday;
    $lines[$startIndex + 2] = $address;
    $lines[$startIndex + 3] = $image;
    $lines[$startIndex + 4] = $class;
    file_put_contents($file, implode(PHP_EOL, $lines) . PHP_EOL);
    header("Location: index.php?page=list");
    exit;
}
?>
<h3>SỬA THÔNG TIN SINH VIÊN</h3>
<form method="post" enctype="multipart/form-data">
    <table class="student-form-table">
        <tr>
            <td>Họ tên</td>
            <td>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </td>
        </tr>
        <tr>
            <td>Ngày sinh</td>
            <td>
                <input type="text" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>" required>
            </td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td>
                <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            </td>
        </tr>
        <tr>
            <td>Lớp</td>
            <td>
                <input type="text" name="class" value="<?php echo htmlspecialchars($class); ?>" required>
            </td>
        </tr>
        <tr>
            <td>Ảnh</td>
            <td>
                <input type="file" name="image">
                <div class="current-image">Ảnh hiện tại:<strong><?php echo htmlspecialchars($image); ?></strong></div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="form-buttons">
                <input type="submit" value="Lưu thay đổi">
                <input type="reset" value="Nhập lại">
            </td>
        </tr>
    </table>
</form>
<div style="max-width: 650px; margin: 0 auto;">
    <a href="index.php?page=list" class="back-button">← Quay lại</a>
</div>