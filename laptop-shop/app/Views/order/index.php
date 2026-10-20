<h3>Đơn hàng của tôi</h3>
<table class="table">
  <thead><tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($orders as $o): ?>
    <tr>
      <td>#<?= (int) $o['id'] ?></td>
      <td><?= htmlspecialchars($o['created_at']) ?></td>
      <td><?= number_format($o['total']) ?>đ</td>
      <td><span class="badge bg-secondary"><?= htmlspecialchars($o['status']) ?></span></td>
      <td><a href="/orders/<?= (int) $o['id'] ?>" class="btn btn-sm btn-outline-primary">Xem</a></td>
    </tr>
  <?php endforeach; ?>
  <?php if (empty($orders)): ?><tr><td colspan="5">Bạn chưa có đơn hàng nào.</td></tr><?php endif; ?>
  </tbody>
</table>
