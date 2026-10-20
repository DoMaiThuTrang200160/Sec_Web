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
$imagePath = "uploads/" . $image;
if (!file_exists($imagePath)) {
    $imagePath = "uploads/default.png";
}
?>
<h3>CHI TIẾT SINH VIÊN</h3>
<div class="detail-container">
    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Ảnh sinh viên" class="detail-avatar">
    <div class="detail-info">
        <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($birthday); ?></p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($address); ?></p>
        <p><strong>Lớp:</strong> <?php echo htmlspecialchars($class); ?></p>
    </div>
</div>
<div style="max-width: 650px; margin: 0 auto;">
    <a href="index.php?page=list" class="back-button">← Quay lại</a>
</div>