<div class="row justify-content-center">
  <div class="col-md-4">
    <h3>Đăng nhập</h3>
    <form method="post" action="/login">
      <?= \App\Core\Csrf::field() ?>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Đăng nhập</button>
    </form>
    <p class="mt-3">Chưa có tài khoản? <a href="/register">Đăng ký</a></p>
    <p class="text-muted small">Tài khoản admin mẫu: admin@laptopshop.local / admin123</p>
  </div>
</div>
