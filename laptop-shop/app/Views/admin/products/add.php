<h3>Thêm sản phẩm</h3>
<form method="post" action="/admin/products/add" enctype="multipart/form-data">
  <?= \App\Core\Csrf::field() ?>
  <div class="mb-3">
    <label class="form-label">Tên sản phẩm</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
    <?php if (!empty($errors['name'])): ?><small class="text-danger"><?= htmlspecialchars($errors['name']) ?></small><?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Danh mục</label>
    <select name="category_id" class="form-select">
      <?php foreach ($categories as $c): ?>
        <option value="<?= (int) $c['id'] ?>" <?= (($old['category_id'] ?? '') == $c['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['category_id'])): ?><small class="text-danger"><?= htmlspecialchars($errors['category_id']) ?></small><?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Thương hiệu</label>
    <input type="text" name="brand" class="form-control" value="<?= htmlspecialchars($old['brand'] ?? '') ?>">
    <?php if (!empty($errors['brand'])): ?><small class="text-danger"><?= htmlspecialchars($errors['brand']) ?></small><?php endif; ?>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Giá</label>
      <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($old['price'] ?? '') ?>">
      <?php if (!empty($errors['price'])): ?><small class="text-danger"><?= htmlspecialchars($errors['price']) ?></small><?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Giá khuyến mãi (không bắt buộc)</label>
      <input type="number" name="discount_price" class="form-control" value="<?= htmlspecialchars($old['discount_price'] ?? '') ?>">
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Ảnh sản phẩm</label>
    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
    <?php if (!empty($errors['image'])): ?><small class="text-danger"><?= htmlspecialchars($errors['image']) ?></small><?php endif; ?>
    <small class="text-muted">JPG/PNG/WEBP, tối đa 3MB.</small>
  </div>
  <div class="mb-3">
    <label class="form-label">Mô tả chi tiết</label>
    <textarea name="description" id="description" class="form-control" rows="8"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
  </div>
  <button class="btn btn-primary">Lưu sản phẩm</button>
  <a href="/admin/products" class="btn btn-secondary">Huỷ</a>
</form>

<!-- Tích hợp CKEditor (CDN) cho ô mô tả - Nhiệm vụ 16.
     Nếu môi trường không có internet, tải CKEditor về và đổi src thành đường dẫn local trong assets/vendor/ckeditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('description');</script>
