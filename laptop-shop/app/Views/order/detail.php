<h3>Chi tiết đơn hàng #<?= (int) $order['id'] ?></h3>
<p>Người nhận: <?= htmlspecialchars($order['full_name']) ?> - <?= htmlspecialchars($order['phone']) ?></p>
<p>Địa chỉ: <?= htmlspecialchars($order['address']) ?></p>
<p>Trạng thái: <span class="badge bg-info text-dark"><?= htmlspecialchars($order['status']) ?></span></p>
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
