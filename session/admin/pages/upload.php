<?php
$msg = "";
$msg_class = "";
if (isset($_POST['btnUpload'])) {
    $target_dir = "../uploads/";
    // Tự tạo thư mục uploads nếu chưa tồn tại
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $msg = "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " đã được upload thành công!";
        $msg_class = "success";
    } else {
        $msg = "Có lỗi xảy ra khi upload file.";
        $msg_class = "error";
    }
}
?>
<div class="upload-container">
    <h3>UPLOAD FILE</h3>
    <?php if ($msg != "") { ?>
        <div class="upload-message <?php echo $msg_class; ?>"><?php echo $msg; ?></div>
    <?php } ?>
    <div class="upload-description">Chọn file từ máy tính để upload vào thư mục<b>uploads/</b>.</div>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="upload-form-group">
            <label for="fileToUpload">Chọn file:</label>
            <input type="file" id="fileToUpload" name="fileToUpload" required>
        </div>
        <div class="upload-button">
            <button type="submit" name="btnUpload">TẢI LÊN</button>
        </div>
    </form>
</div>