<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index(): void
    {
        $stats = [
            'users'      => count(User::all()),
            'categories' => count(Category::all()),
            'products'   => count(Product::all()),
            'orders'     => Order::countAll(),
            'revenue'    => Order::sumRevenue(),
        ];
        $this->render('admin/dashboard', ['stats' => $stats], 'admin');
    }
}
