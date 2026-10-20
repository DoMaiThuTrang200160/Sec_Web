<div class="row">
  <div class="col-md-5">
    <img src="/uploads/products/<?= htmlspecialchars($product['image'] ?: 'no-image.png') ?>" class="img-fluid rounded">
  </div>
  <div class="col-md-7">
    <h3><?= htmlspecialchars($product['name']) ?></h3>
    <p class="text-muted">Thương hiệu: <?= htmlspecialchars($product['brand']) ?></p>
    <h4 class="text-danger"><?= number_format($product['price']) ?>đ</h4>
    <hr>
    <div>
      <?php
        // Nội dung này do Admin nhập qua CKEditor (rich text). CKEditor tự escape khi lưu HTML hợp lệ,
        // nhưng để an toàn tuyệt đối, Admin\ProductController sẽ lọc qua strip_tags whitelist trước khi
        // ghi DB (xem ghi chú trong app/Controllers/Admin/ProductController.php).
        echo $product['description'];
      ?>
    </div>
    <form method="post" action="/cart/add" class="mt-4" id="add-cart-form">
      <?= \App\Core\Csrf::field() ?>
      <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
      <div class="input-group" style="max-width:220px">
        <input type="number" name="quantity" value="1" min="1" class="form-control">
        <button class="btn btn-success">Thêm vào giỏ</button>
      </div>
      <div id="cart-msg" class="mt-2"></div>
    </form>
  </div>
</div>
<script>
// Ví dụ dùng AJAX (jQuery) cho task nâng cao: thêm giỏ hàng không reload trang
$('#add-cart-form').on('submit', function (e) {
  e.preventDefault();
  $.post('/cart/add', $(this).serialize(), function (res) {
    $('#cart-msg').html('<span class="text-success">' + res.message + '</span>');
  }, 'json');
});
</script>
