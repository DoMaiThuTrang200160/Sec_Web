<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laptop Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">Laptop Shop</a>
    <form class="d-flex me-auto ms-4" method="get" action="/products/search">
      <input class="form-control me-2" type="text" name="keyword" placeholder="Tìm laptop...">
      <button class="btn btn-outline-light">Tìm</button>
    </form>
    <div class="d-flex">
      <a href="/products" class="btn btn-outline-light me-2">Sản phẩm</a>
      <a href="/cart" class="btn btn-outline-light me-2">Giỏ hàng</a>
      <?php if (\App\Core\Session::isLoggedIn()): ?>
        <span class="text-white me-2 align-self-center">
          Xin chào, <?= htmlspecialchars(\App\Core\Session::get('user_name')) ?>
        </span>
        <a href="/orders" class="btn btn-outline-light me-2">Đơn hàng</a>
        <a href="/logout" class="btn btn-outline-light">Đăng xuất</a>
      <?php else: ?>
        <a href="/login" class="btn btn-outline-light">Đăng nhập</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container mt-4 mb-5">
  <?php if ($msg = \App\Core\Session::getFlash('success')): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>
  <?php if ($msg = \App\Core\Session::getFlash('error')): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>
  <?= $content ?>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
