<h3>Đơn hàng #<?= (int) $order['id'] ?></h3>
<p>Khách hàng: <?= htmlspecialchars($order['full_name']) ?> - <?= htmlspecialchars($order['phone']) ?></p>
<p>Địa chỉ: <?= htmlspecialchars($order['address']) ?></p>
<p>Ngày đặt: <?= htmlspecialchars($order['created_at']) ?></p>

<table class="table">
  <thead><tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead>
  <tbody>
  <?php foreach ($order['items'] as $it): ?>
    <tr>
      <td><?= htmlspecialchars($it['product_name']) ?></td>
      <td><?= (int) $it['quantity'] ?></td>
      <td><?= number_format($it['price']) ?>đ</td>
      <td><?= number_format($it['price'] * $it['quantity']) ?>đ</td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<h5 class="text-end">Tổng: <span class="text-danger"><?= number_format($order['total']) ?>đ</span></h5>

<form method="post" action="/admin/orders/status/<?= (int) $order['id'] ?>" class="row g-2 align-items-center mt-3">
  <?= \App\Core\Csrf::field() ?>
  <div class="col-auto">
    <label class="col-form-label">Cập nhật trạng thái</label>
  </div>
  <div class="col-auto">
    <select name="status" class="form-select">
      <?php foreach (['pending','confirmed','shipping','completed','cancelled'] as $s): ?>
        <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-auto"><button class="btn btn-primary">Cập nhật</button></div>
</form>
<a href="/admin/orders" class="btn btn-secondary mt-3">Quay lại</a>
