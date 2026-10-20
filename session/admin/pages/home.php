<div class="admin-home">
    <h3>TRANG QUẢN TRỊ - HOME</h3>
    <div class="admin-welcome">
        <p>Xin chào<b><?php echo htmlspecialchars($_SESSION['Username'] ?? ''); ?></b>, bạn đã đăng nhập thành công vào khu vực Administrator!</p>
    </div>
    <div class="admin-info">
        <div class="admin-info-row">
            <span>Tên tài khoản:</span>
            <strong><?php echo htmlspecialchars($_SESSION['Username'] ?? ''); ?></strong>
        </div>
        <div class="admin-info-row">
            <span>Mật khẩu đã lưu Session:</span>
            <strong><?php echo htmlspecialchars($_SESSION['Password'] ?? ''); ?></strong>
        </div>
    </div>
</div>