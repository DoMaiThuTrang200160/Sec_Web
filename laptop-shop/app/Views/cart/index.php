<h3>Giỏ hàng của bạn</h3>
<?php if (empty($items)): ?>
  <p>Giỏ hàng đang trống. <a href="/products">Tiếp tục mua sắm</a></p>
<?php else: ?>
<table class="table align-middle">
  <thead><tr><th>Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $item): ?>
    <tr>
      <td>
        <img src="/uploads/products/<?= htmlspecialchars($item['product']['image'] ?: 'no-image.png') ?>" width="60">
        <?= htmlspecialchars($item['product']['name']) ?>
      </td>
      <td><?= number_format($item['product']['price']) ?>đ</td>
      <td style="max-width:100px">
        <form method="post" action="/cart/update">
          <?= \App\Core\Csrf::field() ?>
          <input type="hidden" name="product_id" value="<?= (int) $item['product']['id'] ?>">
          <input type="number" name="quantity" value="<?= (int) $item['quantity'] ?>" min="1"
                 class="form-control form-control-sm" onchange="this.form.submit()">
        </form>
      </td>
      <td><?= number_format($item['subtotal']) ?>đ</td>
      <td>
        <form method="post" action="/cart/remove">
          <?= \App\Core\Csrf::field() ?>
          <input type="hidden" name="product_id" value="<?= (int) $item['product']['id'] ?>">
          <button class="btn btn-sm btn-outline-danger">Xoá</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<div class="text-end">
  <h5>Tổng cộng: <span class="text-danger"><?= number_format($total) ?>đ</span></h5>
  <a href="/checkout" class="btn btn-success">Tiến hành đặt hàng</a>
</div>
<?php endif; ?>
