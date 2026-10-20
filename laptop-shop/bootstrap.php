<?php
require_once __DIR__ . '/autoload.php';

use App\Core\Session;

date_default_timezone_set('Asia/Ho_Chi_Minh');

// Không hiện chi tiết lỗi PHP ra trình duyệt (tránh rò rỉ đường dẫn/cấu trúc source cho attacker)
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/storage/logs/app.log');

Session::start();
