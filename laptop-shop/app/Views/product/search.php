<form method="get" action="/products/search" class="row g-2 mb-4">
  <div class="col-md-4">
    <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" class="form-control" placeholder="Tên sản phẩm...">
  </div>
  <div class="col-md-3">
    <input type="number" name="min_price" value="<?= htmlspecialchars((string) $minPrice) ?>" class="form-control" placeholder="Giá từ">
  </div>
  <div class="col-md-3">
    <input type="number" name="max_price" value="<?= htmlspecialchars((string) $maxPrice) ?>" class="form-control" placeholder="Giá đến">
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary w-100">Tìm kiếm</button>
  </div>
</form>

<div class="row">
  <?php if ($keyword !== '' && empty($products)): ?>
    <p>Không tìm thấy sản phẩm phù hợp.</p>
  <?php endif; ?>
  <?php foreach ($products as $p): ?>
    <div class="col-6 col-md-4 mb-3">
      <div class="card h-100">
        <a href="/products/detail/<?= (int) $p['id'] ?>">
          <img src="/uploads/products/<?= htmlspecialchars($p['image'] ?: 'no-image.png') ?>"
               class="card-img-top" style="height:180px;object-fit:cover">
        </a>
        <div class="card-body">
          <h6><?= htmlspecialchars($p['name']) ?></h6>
          <p class="text-danger fw-bold"><?= number_format($p['price']) ?>đ</p>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
