<?php
$error = "";
// Kiểm tra Cookie đã có hay chưa để điền sẵn vào ô input
$saved_user = isset($_COOKIE['Username']) ? $_COOKIE['Username'] : '';
$saved_pass = isset($_COOKIE['Password']) ? $_COOKIE['Password'] : '';
// Xử lý khi nhấn nút Đăng nhập
if (isset($_POST['btnDangNhap'])) {
    $name = $_POST['txtUsername'] ?? '';
    $pass = $_POST['txtPassword'] ?? '';
    if ($name === 'admin' && $pass === 'admin') {
        // Lưu thông tin vào Session
        $_SESSION['Username'] = $name;
        $_SESSION['Password'] = $pass;
        // Lưu thông tin vào Cookie trong 30 ngày
        setcookie("Username", $name, time() + 30 * 24 * 60 * 60, "/");
        setcookie("Password", $pass, time() + 30 * 24 * 60 * 60, "/");
        setcookie("LastLogin", date("d/m/Y H:i:s"), time() + 30 * 24 * 60 * 60, "/");
        // Redirect đến trang Admin
        header("Location: admin/index.php");
        exit();
    } else {
        $error = "Mật khẩu hoặc Username không đúng!";
    }
}
?>
<div class="login-page">
    <h3>ĐĂNG NHẬP</h3>
    <?php if (!empty($error)): ?>
        <p class="login-error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="" method="POST" class="login-form">
        <div class="form-group">
            <label for="txtUsername">Username</label>
            <input type="text" id="txtUsername" name="txtUsername" value="<?php echo htmlspecialchars($saved_user); ?>" required>
        </div>
        <div class="form-group">
            <label for="txtPassword">Password</label>
            <input type="password" id="txtPassword" name="txtPassword" value="<?php echo htmlspecialchars($saved_pass); ?>" required>
        </div>
        <div class="form-buttons">
            <input type="reset" value="Nhập lại">
            <input type="submit" name="btnDangNhap" value="Đăng nhập">
        </div>
        <?php if ($saved_user != ''): ?>
            <p class="cookie-note">Username và Password được lấy từ Cookie.</p>
        <?php endif; ?>
    </form>
    <div class="login-note">
        <h4>Chú ý</h4>
        <p>Dùng Session để xử lý đăng nhập.</p>
        <p>Cookies lưu thông tin người dùng đăng nhập thành công, thường dùng để ghi nhớ username, password để không phải nhập lại khi sử dụng cùng trình duyệt trong các lần truy cập sau.</p>
    </div>
</div>