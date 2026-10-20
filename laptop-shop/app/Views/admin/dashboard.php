<h3>Dashboard</h3>
<div class="row g-3">
  <div class="col-6 col-md-3"><div class="card p-3 text-center"><h4><?= (int) $stats['users'] ?></h4><p class="mb-0">Users</p></div></div>
  <div class="col-6 col-md-3"><div class="card p-3 text-center"><h4><?= (int) $stats['categories'] ?></h4><p class="mb-0">Danh mục</p></div></div>
  <div class="col-6 col-md-3"><div class="card p-3 text-center"><h4><?= (int) $stats['products'] ?></h4><p class="mb-0">Sản phẩm</p></div></div>
  <div class="col-6 col-md-3"><div class="card p-3 text-center"><h4><?= (int) $stats['orders'] ?></h4><p class="mb-0">Đơn hàng</p></div></div>
</div>
<div class="mt-4">
  <h5>Doanh thu (không tính đơn đã huỷ): <span class="text-success"><?= number_format($stats['revenue']) ?>đ</span></h5>
</div>
