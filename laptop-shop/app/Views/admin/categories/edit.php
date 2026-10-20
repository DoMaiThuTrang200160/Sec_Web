<h3>Sửa Danh mục</h3>
<form method="post" action="/admin/categories/edit/<?= (int) $category['id'] ?>">
  <?= \App\Core\Csrf::field() ?>
  <div class="mb-3">
    <label class="form-label">Tên danh mục</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>">
    <?php if (!empty($errors['name'])): ?><small class="text-danger"><?= htmlspecialchars($errors['name']) ?></small><?php endif; ?>
  </div>
  <button class="btn btn-primary">Cập nhật</button>
  <a href="/admin/categories" class="btn btn-secondary">Huỷ</a>
</form>
