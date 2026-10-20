<?php
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  // Kiểm tra thông tin đăng nhập admin/admin
  if ($username === 'admin' && $password === 'admin') {
    // Lưu Session
    $_SESSION['Status'] = 'login';
    $_SESSION['Username'] = 'admin';
    $_SESSION['Password'] = 'admin';
    header("Location: admin/index.php");
    exit();
  } else {
    $error = "Tài khoản hoặc mật khẩu không chính xác!";
  }
}
?>
<div class="login-page">
  <h3>ĐĂNG NHẬP HỆ THỐNG</h3>
  <?php if (!empty($error)) { ?>
    <div class="login-message"><?php echo htmlspecialchars($error); ?></div>
  <?php } ?>
  <form action="" method="POST" class="login-form">
    <div class="form-group">
      <label for="username">Tên đăng nhập:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Mật khẩu:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="form-button">
      <input type="submit" value="ĐĂNG NHẬP">
    </div>
  </form>
  <div class="login-note">
    <p><b>Chú ý:</b></p>
    <p>- Xử lý đăng nhập cần dùng Session để lưu trạng thái đã đăng nhập thành công hoặc truyền dữ liệu giữa các page.</p>
    <p>- Session là một phiên làm việc của người dùng, bắt đầu khi client gửi request và kết nối đến web server.</p>
    <p>- Biến session lưu trữ thông tin trong một phiên làm việc của người dùng và có phạm vi toàn cục.</p>
    <p>- Session thường được sử dụng trong Login, ShoppingCart, MultiLanguage.</p>
    <p>- Trước khi sử dụng biến session trong PHP cần gọi hàm <b>session_start()</b>.</p>
    <p>- Có thể hủy biến session khi không dùng bằng cách sử dụng hàm <b>unset()</b> hoặc đặt giá trị bằng <b>null</b>.</p>
  </div>
</div>