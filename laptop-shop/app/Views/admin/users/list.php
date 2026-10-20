<div class="d-flex justify-content-between mb-3">
  <h3>Quản lý Users</h3>
  <a href="/admin/users/add" class="btn btn-primary">+ Thêm user</a>
</div>
<table class="table">
  <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Họ tên</th><th>Vai trò</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= (int) $u['id'] ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><?= htmlspecialchars($u['full_name']) ?></td>
      <td><span class="badge bg-<?= $u['role'] === 'admin' ? 'danger' : 'secondary' ?>"><?= htmlspecialchars($u['role']) ?></span></td>
      <td>
        <a href="/admin/users/detail/<?= (int) $u['id'] ?>" class="btn btn-sm btn-outline-secondary">Xem</a>
        <a href="/admin/users/edit/<?= (int) $u['id'] ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
        <form method="post" action="/admin/users/delete/<?= (int) $u['id'] ?>" class="d-inline"
              onsubmit="return confirm('Xoá user này?')">
          <?= \App\Core\Csrf::field() ?>
          <button class="btn btn-sm btn-outline-danger">Xoá</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
