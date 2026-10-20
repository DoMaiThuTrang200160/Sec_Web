<h3><?= htmlspecialchars($product['name']) ?></h3>
<img src="/uploads/products/<?= htmlspecialchars($product['image'] ?: 'no-image.png') ?>" width="200" class="mb-3 rounded">
<table class="table w-auto">
  <tr><th>Danh mục ID</th><td><?= (int) $product['category_id'] ?></td></tr>
  <tr><th>Giá</th><td><?= number_format($product['price']) ?>đ</td></tr>
  <tr><th>Thương hiệu</th><td><?= htmlspecialchars($product['brand']) ?></td></tr>
</table>
<h5>Mô tả</h5>
<div class="border p-3 rounded"><?= $product['description'] /* Đã được sanitizeRichText() khi lưu */ ?></div>
<a href="/admin/products" class="btn btn-secondary mt-3">Quay lại</a>
