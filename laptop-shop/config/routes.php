<?php
use App\Core\Middleware\AuthMiddleware;
use App\Core\Middleware\AdminMiddleware;
use App\Core\Middleware\CsrfMiddleware;

/** @var \App\Core\Router $router */

// ==== End user ====
$router->get('/', 'HomeController@index');

$router->get('/products', 'ProductController@index');
$router->get('/products/detail/{id}', 'ProductController@detail');
$router->get('/products/search', 'ProductController@search');

$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login', [CsrfMiddleware::class]);
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register', [CsrfMiddleware::class]);
$router->get('/logout', 'AuthController@logout');

// ==== Giỏ hàng ====
$router->get('/cart', 'CartController@index');
$router->post('/cart/add', 'CartController@add', [CsrfMiddleware::class]);
$router->post('/cart/update', 'CartController@update', [CsrfMiddleware::class]);
$router->post('/cart/remove', 'CartController@remove', [CsrfMiddleware::class]);

// ==== Checkout / Đơn hàng (yêu cầu đăng nhập) ====
$router->get('/checkout', 'OrderController@checkoutForm', [AuthMiddleware::class]);
$router->post('/checkout', 'OrderController@placeOrder', [AuthMiddleware::class, CsrfMiddleware::class]);
$router->get('/orders', 'OrderController@myOrders', [AuthMiddleware::class]);
$router->get('/orders/{id}', 'OrderController@detail', [AuthMiddleware::class]);

// ==== Admin (yêu cầu đăng nhập + role admin) ====
$router->get('/admin', 'Admin\\DashboardController@index', [AdminMiddleware::class]);

$router->get('/admin/users', 'Admin\\UserController@index', [AdminMiddleware::class]);
$router->get('/admin/users/add', 'Admin\\UserController@addForm', [AdminMiddleware::class]);
$router->post('/admin/users/add', 'Admin\\UserController@add', [AdminMiddleware::class, CsrfMiddleware::class]);
$router->get('/admin/users/edit/{id}', 'Admin\\UserController@editForm', [AdminMiddleware::class]);
$router->post('/admin/users/edit/{id}', 'Admin\\UserController@edit', [AdminMiddleware::class, CsrfMiddleware::class]);
$router->get('/admin/users/detail/{id}', 'Admin\\UserController@detail', [AdminMiddleware::class]);
// Xoá dùng POST + CSRF (không dùng link GET) để tránh CSRF-delete qua link giả mạo
$router->post('/admin/users/delete/{id}', 'Admin\\UserController@delete', [AdminMiddleware::class, CsrfMiddleware::class]);

$router->get('/admin/categories', 'Admin\\CategoryController@index', [AdminMiddleware::class]);
$router->get('/admin/categories/add', 'Admin\\CategoryController@addForm', [AdminMiddleware::class]);
$router->post('/admin/categories/add', 'Admin\\CategoryController@add', [AdminMiddleware::class, CsrfMiddleware::class]);
$router->get('/admin/categories/edit/{id}', 'Admin\\CategoryController@editForm', [AdminMiddleware::class]);
$router->post('/admin/categories/edit/{id}', 'Admin\\CategoryController@edit', [AdminMiddleware::class, CsrfMiddleware::class]);
$router->post('/admin/categories/delete/{id}', 'Admin\\CategoryController@delete', [AdminMiddleware::class, CsrfMiddleware::class]);

$router->get('/admin/products', 'Admin\\ProductController@index', [AdminMiddleware::class]);
$router->get('/admin/products/add', 'Admin\\ProductController@addForm', [AdminMiddleware::class]);
$router->post('/admin/products/add', 'Admin\\ProductController@add', [AdminMiddleware::class, CsrfMiddleware::class]);
$router->get('/admin/products/edit/{id}', 'Admin\\ProductController@editForm', [AdminMiddleware::class]);
$router->post('/admin/products/edit/{id}', 'Admin\\ProductController@edit', [AdminMiddleware::class, CsrfMiddleware::class]);
$router->get('/admin/products/detail/{id}', 'Admin\\ProductController@detail', [AdminMiddleware::class]);
$router->post('/admin/products/delete/{id}', 'Admin\\ProductController@delete', [AdminMiddleware::class, CsrfMiddleware::class]);

$router->get('/admin/orders', 'Admin\\OrderController@index', [AdminMiddleware::class]);
$router->get('/admin/orders/detail/{id}', 'Admin\\OrderController@detail', [AdminMiddleware::class]);
$router->post('/admin/orders/status/{id}', 'Admin\\OrderController@updateStatus', [AdminMiddleware::class, CsrfMiddleware::class]);
