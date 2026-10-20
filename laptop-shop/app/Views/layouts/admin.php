<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin - Laptop Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
  <nav class="bg-dark text-white p-3" style="width:220px; min-height:100vh;">
    <h5 class="mb-4">Admin Panel</h5>
    <a href="/admin" class="d-block text-white-50 mb-2">Dashboard</a>
    <a href="/admin/users" class="d-block text-white-50 mb-2">Users</a>
    <a href="/admin/categories" class="d-block text-white-50 mb-2">Categories</a>
    <a href="/admin/products" class="d-block text-white-50 mb-2">Products</a>
    <a href="/admin/orders" class="d-block text-white-50 mb-2">Orders</a>
    <hr>
    <a href="/" class="d-block text-white-50 mb-2">&larr; Về trang bán hàng</a>
    <a href="/logout" class="d-block text-white-50">Đăng xuất</a>
  </nav>
  <div class="flex-fill p-4">
    <?php if ($msg = \App\Core\Session::getFlash('success')): ?>
      <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if ($msg = \App\Core\Session::getFlash('error')): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?= $content ?>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
