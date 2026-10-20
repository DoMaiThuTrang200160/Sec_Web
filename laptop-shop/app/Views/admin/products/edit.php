<h3>Sửa sản phẩm</h3>
<form method="post" action="/admin/products/edit/<?= (int) $product['id'] ?>" enctype="multipart/form-data">
  <?= \App\Core\Csrf::field() ?>
  <div class="mb-3">
    <label class="form-label">Tên sản phẩm</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>">
    <?php if (!empty($errors['name'])): ?><small class="text-danger"><?= htmlspecialchars($errors['name']) ?></small><?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Danh mục</label>
    <select name="category_id" class="form-select">
      <?php foreach ($categories as $c): ?>
        <option value="<?= (int) $c['id'] ?>" <?= ((int) $product['category_id'] === (int) $c['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Thương hiệu</label>
    <input type="text" name="brand" class="form-control" value="<?= htmlspecialchars($product['brand']) ?>">
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Giá</label>
      <input type="number" name="price" class="form-control" value="<?= htmlspecialchars((string) $product['price']) ?>">
      <?php if (!empty($errors['price'])): ?><small class="text-danger"><?= htmlspecialchars($errors['price']) ?></small><?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Giá khuyến mãi</label>
      <input type="number" name="discount_price" class="form-control" value="<?= htmlspecialchars((string) ($product['discount_price'] ?? '')) ?>">
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Ảnh hiện tại</label><br>
    <img src="/uploads/products/<?= htmlspecialchars($product['image'] ?: 'no-image.png') ?>" width="120" class="mb-2 rounded"><br>
    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
    <small class="text-muted">Chỉ chọn file mới nếu muốn thay ảnh.</small>
    <?php if (!empty($errors['image'])): ?><small class="text-danger d-block"><?= htmlspecialchars($errors['image']) ?></small><?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Mô tả chi tiết</label>
    <textarea name="description" id="description" class="form-control" rows="8"><?= htmlspecialchars($product['description']) ?></textarea>
  </div>
  <button class="btn btn-primary">Cập nhật</button>
  <a href="/admin/products" class="btn btn-secondary">Huỷ</a>
</form>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('description');</script>
