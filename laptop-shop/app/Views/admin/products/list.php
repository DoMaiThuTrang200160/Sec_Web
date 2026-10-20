<div class="d-flex justify-content-between mb-3">
  <h3>Quản lý Sản phẩm</h3>
  <a href="/admin/products/add" class="btn btn-primary">+ Thêm sản phẩm</a>
</div>
<table class="table align-middle">
  <thead><tr><th>Ảnh</th><th>Tên</th><th>Giá</th><th>Thương hiệu</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($products as $p): ?>
    <tr>
      <td><img src="/uploads/products/<?= htmlspecialchars($p['image'] ?: 'no-image.png') ?>" width="60"></td>
      <td><?= htmlspecialchars($p['name']) ?></td>
      <td><?= number_format($p['price']) ?>đ</td>
      <td><?= htmlspecialchars($p['brand']) ?></td>
      <td>
        <a href="/admin/products/detail/<?= (int) $p['id'] ?>" class="btn btn-sm btn-outline-secondary">Xem</a>
        <a href="/admin/products/edit/<?= (int) $p['id'] ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
        <form method="post" action="/admin/products/delete/<?= (int) $p['id'] ?>" class="d-inline"
              onsubmit="return confirm('Xoá sản phẩm này?')">
          <?= \App\Core\Csrf::field() ?>
          <button class="btn btn-sm btn-outline-danger">Xoá</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
