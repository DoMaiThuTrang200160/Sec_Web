<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Core\Router;
use App\Core\Request;

$router = new Router();
require __DIR__ . '/../config/routes.php';

$router->dispatch(Request::uri(), Request::method());
