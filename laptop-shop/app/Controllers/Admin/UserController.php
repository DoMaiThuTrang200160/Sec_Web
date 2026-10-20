<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $this->render('admin/users/list', ['users' => User::all()], 'admin');
    }

    public function addForm(): void
    {
        $this->render('admin/users/add', [], 'admin');
    }

    public function add(): void
    {
        $data = Request::all();
        $v = new Validator($data);
        $v->required('full_name', 'Họ tên')->required('username', 'Tên đăng nhập')
          ->required('email', 'Email')->email('email')
          ->required('password', 'Mật khẩu')->min('password', 6, 'Mật khẩu');

        $errors = $v->errors();
        if (!$v->fails() && User::findByEmail($data['email'])) {
            $errors['email'] = 'Email đã tồn tại.';
        }

        if (!empty($errors)) {
            $this->render('admin/users/add', ['errors' => $errors, 'old' => $data], 'admin');
            return;
        }

        User::create($data + ['role' => in_array($data['role'] ?? '', ['admin', 'customer']) ? $data['role'] : 'customer']);
        Session::flash('success', 'Thêm user thành công.');
        $this->redirect('/admin/users');
    }

    public function editForm($id): void
    {
        $user = User::find((int) $id);
        if (!$user) { $this->redirect('/admin/users'); }
        $this->render('admin/users/edit', ['user' => $user], 'admin');
    }

    public function edit($id): void
    {
        $data = Request::all();
        $v = new Validator($data);
        $v->required('full_name', 'Họ tên')->required('username', 'Tên đăng nhập')
          ->required('email', 'Email')->email('email');

        if ($v->fails()) {
            $this->render('admin/users/edit', ['user' => array_merge(['id' => $id], $data), 'errors' => $v->errors()], 'admin');
            return;
        }

        User::updateProfile((int) $id, $data + ['role' => in_array($data['role'] ?? '', ['admin', 'customer']) ? $data['role'] : 'customer']);
        Session::flash('success', 'Cập nhật user thành công.');
        $this->redirect('/admin/users');
    }

    public function detail($id): void
    {
        $user = User::find((int) $id);
        if (!$user) { $this->redirect('/admin/users'); }
        $this->render('admin/users/detail', ['user' => $user], 'admin');
    }

    public function delete($id): void
    {
        // Không cho tự xoá chính tài khoản đang đăng nhập -> tránh tự khoá quyền truy cập admin
        if ((int) $id === (int) Session::get('user_id')) {
            Session::flash('error', 'Không thể tự xoá tài khoản đang đăng nhập.');
            $this->redirect('/admin/users');
        }
        User::delete((int) $id);
        Session::flash('success', 'Đã xoá user.');
        $this->redirect('/admin/users');
    }
}
