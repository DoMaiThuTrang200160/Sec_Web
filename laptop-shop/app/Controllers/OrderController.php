<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function checkoutForm(): void
    {
        $items = Cart::items();
        if (empty($items)) {
            Session::flash('error', 'Giỏ hàng đang trống.');
            $this->redirect('/cart');
        }
        $this->render('cart/checkout', ['items' => $items, 'total' => Cart::total()]);
    }

    public function placeOrder(): void
    {
        $items = Cart::items();
        if (empty($items)) {
            $this->redirect('/cart');
        }

        $data = Request::all();
        $validator = new Validator($data);
        $validator->required('full_name', 'Họ tên')
            ->required('phone', 'Số điện thoại')
            ->required('address', 'Địa chỉ');

        if ($validator->fails()) {
            $this->render('cart/checkout', [
                'items' => $items, 'total' => Cart::total(),
                'errors' => $validator->errors(), 'old' => $data,
            ]);
            return;
        }

        $orderId = Order::create([
            'user_id'   => Session::get('user_id'),
            'full_name' => $data['full_name'],
            'phone'     => $data['phone'],
            'address'   => $data['address'],
            'total'     => Cart::total(),
        ]);

        // Ghi từng dòng chi tiết đơn hàng - chốt lại giá tại thời điểm mua (khác Cart::items() lấy giá real-time)
        foreach ($items as $item) {
            OrderDetail::create([
                'order_id'   => $orderId,
                'product_id' => $item['product']['id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['product']['price'],
            ]);
        }

        Cart::clear();
        Session::flash('success', 'Đặt hàng thành công! Mã đơn hàng #' . $orderId);
        $this->redirect('/orders/' . $orderId);
    }

    public function myOrders(): void
    {
        $orders = Order::byUser((int) Session::get('user_id'));
        $this->render('order/index', ['orders' => $orders]);
    }

    public function detail($id): void
    {
        $order = Order::withDetails((int) $id);

        // Chống IDOR: user chỉ được xem đơn hàng của chính mình, dù có đoán được ID đơn hàng khác
        if (!$order || (int) $order['user_id'] !== (int) Session::get('user_id')) {
            http_response_code(404);
            require __DIR__ . '/../Views/errors/404.php';
            return;
        }
        $this->render('order/detail', ['order' => $order]);
    }
}
