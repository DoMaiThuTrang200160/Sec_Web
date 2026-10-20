<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index(): void
    {
        $this->render('cart/index', ['items' => Cart::items(), 'total' => Cart::total()]);
    }

    public function add(): void
    {
        $productId = (int) Request::input('product_id');
        $qty = max(1, (int) Request::input('quantity', 1));

        $product = Product::find($productId);
        if (!$product) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.'], 404);
            }
            $this->redirect('/products');
        }

        Cart::add($productId, $qty);

        // Trả JSON nếu gọi qua AJAX (jQuery) - đáp ứng yêu cầu tích hợp AJAX của bài nâng cao
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Đã thêm vào giỏ hàng.', 'cart_count' => Cart::count()]);
        }
        $this->redirect('/cart');
    }

    public function update(): void
    {
        $productId = (int) Request::input('product_id');
        $qty = (int) Request::input('quantity', 1);
        Cart::update($productId, $qty);
        $this->redirect('/cart');
    }

    public function remove(): void
    {
        $productId = (int) Request::input('product_id');
        Cart::remove($productId);
        $this->redirect('/cart');
    }
}
