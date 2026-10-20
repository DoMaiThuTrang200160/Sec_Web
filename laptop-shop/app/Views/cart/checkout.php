<h3>Thông tin đặt hàng</h3>
<div class="row">
  <div class="col-md-7">
    <form method="post" action="/checkout">
      <?= \App\Core\Csrf::field() ?>
      <div class="mb-3">
        <label class="form-label">Họ tên người nhận</label>
        <input type="text" name="full_name" class="form-control"
               value="<?= htmlspecialchars($old['full_name'] ?? \App\Core\Session::get('user_name', '')) ?>">
        <?php if (!empty($errors['full_name'])): ?><small class="text-danger"><?= htmlspecialchars($errors['full_name']) ?></small><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
        <?php if (!empty($errors['phone'])): ?><small class="text-danger"><?= htmlspecialchars($errors['phone']) ?></small><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Địa chỉ giao hàng</label>
        <textarea name="address" class="form-control"><?= htmlspecialchars($old['address'] ?? '') ?></textarea>
        <?php if (!empty($errors['address'])): ?><small class="text-danger"><?= htmlspecialchars($errors['address']) ?></small><?php endif; ?>
      </div>
      <button class="btn btn-success">Xác nhận đặt hàng</button>
    </form>
  </div>
  <div class="col-md-5">
    <h5>Đơn hàng của bạn</h5>
    <ul class="list-group">
      <?php foreach ($items as $item): ?>
        <li class="list-group-item d-flex justify-content-between">
          <?= htmlspecialchars($item['product']['name']) ?> x <?= (int) $item['quantity'] ?>
          <span><?= number_format($item['subtotal']) ?>đ</span>
        </li>
      <?php endforeach; ?>
      <li class="list-group-item d-flex justify-content-between fw-bold">
        Tổng cộng <span class="text-danger"><?= number_format($total) ?>đ</span>
      </li>
    </ul>
  </div>
</div>
