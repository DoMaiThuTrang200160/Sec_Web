<div class="row">
  <div class="col-md-3">
    <h5>Danh mục</h5>
    <div class="list-group mb-4">
      <a href="/products" class="list-group-item <?= !$currentCategory ? 'active' : '' ?>">Tất cả</a>
      <?php foreach ($categories as $c): ?>
        <a href="/products?category_id=<?= (int) $c['id'] ?>"
           class="list-group-item <?= (int) $currentCategory === (int) $c['id'] ? 'active' : '' ?>">
          <?= htmlspecialchars($c['name']) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="col-md-9">
    <div class="row">
      <?php if (empty($products)): ?><p>Không có sản phẩm nào.</p><?php endif; ?>
      <?php foreach ($products as $p): ?>
        <div class="col-6 col-md-4 mb-3">
          <div class="card h-100">
            <a href="/products/detail/<?= (int) $p['id'] ?>">
              <img src="/uploads/products/<?= htmlspecialchars($p['image'] ?: 'no-image.png') ?>"
                   class="card-img-top" style="height:180px;object-fit:cover">
            </a>
            <div class="card-body">
              <h6><?= htmlspecialchars($p['name']) ?></h6>
              <p class="text-muted small mb-1"><?= htmlspecialchars($p['category_name']) ?></p>
              <p class="text-danger fw-bold"><?= number_format($p['price']) ?>đ</p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
