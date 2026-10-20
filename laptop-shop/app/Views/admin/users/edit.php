<h3>Sửa User</h3>
<form method="post" action="/admin/users/edit/<?= (int) $user['id'] ?>">
  <?= \App\Core\Csrf::field() ?>
  <div class="mb-3">
    <label class="form-label">Họ tên</label>
    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>">
    <?php if (!empty($errors['full_name'])): ?><small class="text-danger"><?= htmlspecialchars($errors['full_name']) ?></small><?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Tên đăng nhập</label>
    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>">
    <?php if (!empty($errors['username'])): ?><small class="text-danger"><?= htmlspecialchars($errors['username']) ?></small><?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
    <?php if (!empty($errors['email'])): ?><small class="text-danger"><?= htmlspecialchars($errors['email']) ?></small><?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Vai trò</label>
    <select name="role" class="form-select">
      <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
      <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
  </div>
  <p class="text-muted small">Đổi mật khẩu nên tách thành chức năng riêng (yêu cầu xác nhận mật khẩu cũ) - ngoài phạm vi form này.</p>
  <button class="btn btn-primary">Cập nhật</button>
  <a href="/admin/users" class="btn btn-secondary">Huỷ</a>
</form>
