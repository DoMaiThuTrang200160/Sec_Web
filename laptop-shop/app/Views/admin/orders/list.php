<h3>Quản lý Đơn hàng</h3>

<form method="get" action="/admin/orders" class="row g-2 mb-3">
  <div class="col-auto">
    <input type="text" id="from" name="from" class="form-control" placeholder="Từ ngày" value="<?= htmlspecialchars($from ?? '') ?>">
  </div>
  <div class="col-auto">
    <input type="text" id="to" name="to" class="form-control" placeholder="Đến ngày" value="<?= htmlspecialchars($to ?? '') ?>">
  </div>
  <div class="col-auto">
    <button class="btn btn-primary">Lọc</button>
    <a href="/admin/orders" class="btn btn-outline-secondary">Xoá lọc</a>
  </div>
</form>

<table class="table">
  <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($orders as $o): ?>
    <tr>
      <td>#<?= (int) $o['id'] ?></td>
      <td><?= htmlspecialchars($o['full_name']) ?></td>
      <td><?= htmlspecialchars($o['created_at']) ?></td>
      <td><?= number_format($o['total']) ?>đ</td>
      <td><span class="badge bg-secondary"><?= htmlspecialchars($o['status']) ?></span></td>
      <td><a href="/admin/orders/detail/<?= (int) $o['id'] ?>" class="btn btn-sm btn-outline-primary">Xem</a></td>
    </tr>
  <?php endforeach; ?>
  <?php if (empty($orders)): ?><tr><td colspan="6">Không có đơn hàng nào.</td></tr><?php endif; ?>
  </tbody>
</table>

<!-- Tích hợp thư viện open source Flatpickr làm datetime picker cho bộ lọc ngày -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr('#from', { dateFormat: 'Y-m-d' });
flatpickr('#to', { dateFormat: 'Y-m-d' });
</script>
