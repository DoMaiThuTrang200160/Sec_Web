<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Trang productList (Hình 1)
    public function index(): void
    {
        $categoryId = Request::input('category_id') ? (int) Request::input('category_id') : null;
        $page       = max(1, (int) Request::input('page', 1));

        $this->render('product/list', [
            'categories'      => Category::all('name ASC'),
            'products'        => Product::paginate($categoryId, $page),
            'currentCategory' => $categoryId,
        ]);
    }

    // Trang productDetail
    public function detail($id): void
    {
        $product = Product::find((int) $id);
        if (!$product) {
            http_response_code(404);
            require __DIR__ . '/../Views/errors/404.php';
            return;
        }
        $this->render('product/detail', ['product' => $product]);
    }

    // Trang productSearch (Hình 2)
    public function search(): void
    {
        $keyword  = Request::input('keyword', '');
        $minPrice = Request::input('min_price') !== '' && Request::input('min_price') !== null
            ? (int) Request::input('min_price') : null;
        $maxPrice = Request::input('max_price') !== '' && Request::input('max_price') !== null
            ? (int) Request::input('max_price') : null;

        $products = $keyword !== '' ? Product::search($keyword, $minPrice, $maxPrice) : [];

        $this->render('product/search', compact('products', 'keyword', 'minPrice', 'maxPrice'));
    }
}
