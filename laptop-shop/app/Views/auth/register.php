<div class="row justify-content-center">
  <div class="col-md-5">
    <h3>Đăng ký</h3>
    <form method="post" action="/register">
      <?= \App\Core\Csrf::field() ?>
      <div class="mb-3">
        <label class="form-label">Họ tên</label>
        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($old['full_name'] ?? '') ?>">
        <?php if (!empty($errors['full_name'])): ?><small class="text-danger"><?= htmlspecialchars($errors['full_name']) ?></small><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Tên đăng nhập</label>
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($old['username'] ?? '') ?>">
        <?php if (!empty($errors['username'])): ?><small class="text-danger"><?= htmlspecialchars($errors['username']) ?></small><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        <?php if (!empty($errors['email'])): ?><small class="text-danger"><?= htmlspecialchars($errors['email']) ?></small><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control">
        <?php if (!empty($errors['password'])): ?><small class="text-danger"><?= htmlspecialchars($errors['password']) ?></small><?php endif; ?>
      </div>
      <button class="btn btn-primary w-100">Đăng ký</button>
    </form>
  </div>
</div>
