<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(): void
    {
        $this->render('admin/categories/list', ['categories' => Category::all('name ASC')], 'admin');
    }

    public function addForm(): void
    {
        $this->render('admin/categories/add', [], 'admin');
    }

    public function add(): void
    {
        $data = Request::all();
        $v = new Validator($data);
        $v->required('name', 'Tên danh mục');

        if ($v->fails()) {
            $this->render('admin/categories/add', ['errors' => $v->errors(), 'old' => $data], 'admin');
            return;
        }

        Category::create(['name' => $data['name'], 'slug' => $this->slugify($data['name'])]);
        Session::flash('success', 'Thêm danh mục thành công.');
        $this->redirect('/admin/categories');
    }

    public function editForm($id): void
    {
        $category = Category::find((int) $id);
        if (!$category) { $this->redirect('/admin/categories'); }
        $this->render('admin/categories/edit', ['category' => $category], 'admin');
    }

    public function edit($id): void
    {
        $data = Request::all();
        $v = new Validator($data);
        $v->required('name', 'Tên danh mục');

        if ($v->fails()) {
            $this->render('admin/categories/edit', ['category' => array_merge(['id' => $id], $data), 'errors' => $v->errors()], 'admin');
            return;
        }

        Category::update((int) $id, ['name' => $data['name'], 'slug' => $this->slugify($data['name'])]);
        Session::flash('success', 'Cập nhật danh mục thành công.');
        $this->redirect('/admin/categories');
    }

    public function delete($id): void
    {
        Category::delete((int) $id);
        Session::flash('success', 'Đã xoá danh mục.');
        $this->redirect('/admin/categories');
    }

    // Slug đơn giản cho bài tập: bỏ dấu tiếng Việt sẽ tốt hơn nhưng ngoài phạm vi cần thiết ở đây,
    // nối thêm hậu tố random để đảm bảo UNIQUE không đụng nhau giữa các tên gần giống.
    private function slugify(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', '-', $text);
        return strtolower(trim($text, '-')) . '-' . substr(md5(uniqid()), 0, 5);
    }
}
