<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(): void
    {
        $from = Request::input('from');
        $to = Request::input('to');
        $orders = ($from || $to) ? Order::filter($from ?: null, $to ?: null) : Order::all();
        $this->render('admin/orders/list', ['orders' => $orders, 'from' => $from, 'to' => $to], 'admin');
    }

    public function detail($id): void
    {
        $order = Order::withDetails((int) $id);
        if (!$order) { $this->redirect('/admin/orders'); }
        $this->render('admin/orders/detail', ['order' => $order], 'admin');
    }

    public function updateStatus($id): void
    {
        $status = Request::input('status');
        $allowed = ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'];
        if (in_array($status, $allowed, true)) {
            Order::updateStatus((int) $id, $status);
            Session::flash('success', 'Đã cập nhật trạng thái đơn hàng.');
        }
        $this->redirect('/admin/orders/detail/' . $id);
    }
}
