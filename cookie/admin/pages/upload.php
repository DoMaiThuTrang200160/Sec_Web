<?php
$msg = "";
$msg_class = "";
if (isset($_POST['btnUpload'])) {
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    if (move_uploaded_file(
        $_FILES["fileToUpload"]["tmp_name"],
        $target_file
    )) {
        $msg = "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " upload thành công!";
        $msg_class = "success";
    } else {
        $msg = "Có lỗi khi upload file!";
        $msg_class = "error";
    }
}
?>
<div class="upload-page">
    <h3>UPLOAD FILE</h3>
    <?php if (!empty($msg)): ?>
        <p class="upload-message <?php echo $msg_class; ?>"><?php echo $msg; ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data" class="upload-form">
        <div class="upload-description">Chọn file lưu vào thư mục <strong>uploads/</strong></div>
        <div class="upload-file">
            <label for="fileToUpload">Chọn file</label>
            <input type="file" id="fileToUpload" name="fileToUpload" required>
        </div>
        <button type="submit" name="btnUpload">Tải lên</button>
    </form>
</div>