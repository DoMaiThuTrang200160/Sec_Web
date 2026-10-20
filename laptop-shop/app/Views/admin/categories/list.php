<div class="d-flex justify-content-between mb-3">
  <h3>Quản lý Danh mục</h3>
  <a href="/admin/categories/add" class="btn btn-primary">+ Thêm danh mục</a>
</div>
<table class="table">
  <thead><tr><th>ID</th><th>Tên</th><th>Slug</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($categories as $c): ?>
    <tr>
      <td><?= (int) $c['id'] ?></td>
      <td><?= htmlspecialchars($c['name']) ?></td>
      <td><code><?= htmlspecialchars($c['slug']) ?></code></td>
      <td>
        <a href="/admin/categories/edit/<?= (int) $c['id'] ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
        <form method="post" action="/admin/categories/delete/<?= (int) $c['id'] ?>" class="d-inline"
              onsubmit="return confirm('Xoá danh mục này? Toàn bộ sản phẩm thuộc danh mục cũng sẽ bị xoá.')">
          <?= \App\Core\Csrf::field() ?>
          <button class="btn btn-sm btn-outline-danger">Xoá</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
