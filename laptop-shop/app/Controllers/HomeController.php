<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(): void
    {
        $categories = Category::all('name ASC');
        $sections = [];
        foreach ($categories as $cat) {
            $sections[] = [
                'category' => $cat,
                'products' => Product::latestByCategory((int) $cat['id'], 2),
            ];
        }
        $this->render('home/index', ['sections' => $sections]);
    }
}
