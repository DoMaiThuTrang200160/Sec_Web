<?php foreach ($sections as $section): ?>
  <h4 class="mt-4 border-bottom pb-2"><?= htmlspecialchars($section['category']['name']) ?></h4>
  <div class="row">
    <?php if (empty($section['products'])): ?>
      <p class="text-muted">Chưa có sản phẩm.</p>
    <?php endif; ?>
    <?php foreach ($section['products'] as $p): ?>
      <div class="col-6 col-md-3 mb-3">
        <div class="card h-100">
          <a href="/products/detail/<?= (int) $p['id'] ?>">
            <img src="/uploads/products/<?= htmlspecialchars($p['image'] ?: 'no-image.png') ?>"
                 class="card-img-top" style="height:160px;object-fit:cover" alt="">
          </a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><?= htmlspecialchars($p['name']) ?></h6>
            <p class="text-danger fw-bold mb-2"><?= number_format($p['price']) ?>đ</p>
            <a href="/products/detail/<?= (int) $p['id'] ?>" class="btn btn-sm btn-primary mt-auto">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>
