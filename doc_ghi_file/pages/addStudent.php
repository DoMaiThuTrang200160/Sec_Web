<?php
$msg = "";
if (isset($_POST['btnGhi'])) {
    $ten = trim($_POST['txtTen'] ?? '');
    $diachi = trim($_POST['txtDiaChi'] ?? '');
    $tuoi = trim($_POST['txtTuoi'] ?? '');
    if (!empty($ten) && !empty($diachi) && !empty($tuoi)) {
        $filePath = "data/student.txt";
        // Tạo thư mục data nếu chưa có
        if (!file_exists("data")) {
            mkdir("data", 0777, true);
        }
        // Nội dung 3 dòng tương ứng với 1 sinh viên
        $content = $ten . "\n" . $diachi . "\n" . $tuoi . "\n";
        // Mở file ở chế độ ghi tiếp vào cuối file
        $file = fopen($filePath, "a");
        if ($file) {
            fwrite($file, $content);
            fclose($file);
            // Chuyển hướng về trang hiển thị danh sách
            header("Location: index.php?page=listStudent");
            exit();
        } else {
            $msg = "<p class='error-message'>Không thể mở file để ghi!</p>";
        }
    } else {
        $msg = "<p class='error-message'>Vui lòng nhập đầy đủ thông tin!</p>";
    }
}
?>
<div class="student-page">
    <h3>THÊM SINH VIÊN MỚI</h3>
    <?php echo $msg; ?>
    <form action="" method="POST" class="student-form">
        <div class="form-group">
            <label for="txtTen">Tên</label>
            <input type="text" id="txtTen" name="txtTen" required>
        </div>
        <div class="form-group">
            <label for="txtDiaChi">Địa chỉ</label>
            <input type="text" id="txtDiaChi" name="txtDiaChi" required>
        </div>
        <div class="form-group">
            <label for="txtTuoi">Tuổi</label>
            <input type="text" id="txtTuoi" name="txtTuoi" required>
        </div>
        <div class="form-buttons">
            <input type="reset" value="Nhập lại">
            <input type="submit" name="btnGhi" value="Ghi">
        </div>
    </form>
</div>