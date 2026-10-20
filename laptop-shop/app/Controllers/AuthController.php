<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Core\Logger;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm(): void { $this->render('auth/login'); }

    public function login(): void
    {
        $email    = Request::input('email');
        $password = Request::input('password');

        $user = User::findByEmail($email);

        // password_verify - KHÔNG bao giờ so sánh mật khẩu bằng == hoặc so hash tự viết
        if (!$user || !password_verify($password, $user['password'])) {
            Logger::log('security', "Đăng nhập thất bại - email: $email - IP: " . ($_SERVER['REMOTE_ADDR'] ?? '?'));
            Session::flash('error', 'Email hoặc mật khẩu không đúng.');
            $this->redirect('/login');
        }

        Session::regenerate(); // Chống Session Fixation ngay sau khi xác thực thành công
        Session::set('user_id', $user['id']);
        Session::set('user_name', $user['full_name']);
        Session::set('user_role', $user['role']);

        $this->redirect($user['role'] === 'admin' ? '/admin' : '/');
    }

    public function registerForm(): void { $this->render('auth/register'); }

    public function register(): void
    {
        $data = Request::all();

        $validator = new Validator($data);
        $validator->required('full_name', 'Họ tên')
            ->required('username', 'Tên đăng nhập')
            ->required('email', 'Email')->email('email')
            ->required('password', 'Mật khẩu')->min('password', 6, 'Mật khẩu');

        if ($validator->fails()) {
            $this->render('auth/register', ['errors' => $validator->errors(), 'old' => $data]);
            return;
        }

        if (User::findByEmail($data['email'])) {
            $this->render('auth/register', ['errors' => ['email' => 'Email đã được sử dụng.'], 'old' => $data]);
            return;
        }

        User::create($data + ['role' => 'customer']);
        Session::flash('success', 'Đăng ký thành công, vui lòng đăng nhập.');
        $this->redirect('/login');
    }

    public function logout(): void
    {
        Session::destroy();
        $this->redirect('/login');
    }
}
