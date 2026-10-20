<h3>Chi tiết User</h3>
<table class="table w-auto">
  <tr><th>ID</th><td><?= (int) $user['id'] ?></td></tr>
  <tr><th>Họ tên</th><td><?= htmlspecialchars($user['full_name']) ?></td></tr>
  <tr><th>Username</th><td><?= htmlspecialchars($user['username']) ?></td></tr>
  <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
  <tr><th>Vai trò</th><td><?= htmlspecialchars($user['role']) ?></td></tr>
  <tr><th>Ngày tạo</th><td><?= htmlspecialchars($user['created_at']) ?></td></tr>
</table>
<a href="/admin/users" class="btn btn-secondary">Quay lại</a>
