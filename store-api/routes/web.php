<?php
require_once __DIR__ . "/../config/config.php";

// Use realpath to avoid path issues on Windows/Linux
// $controllerPath = realpath(__DIR__ . "/../app/controllers/AuthController.php");
$controllerPath = realpath(__DIR__ . "/../app/controller/AuthController.php");

if ($controllerPath === false) {
    die("AuthController.php not found at: " . __DIR__ . "/../app/controllers/AuthController.php");
}

require_once $controllerPath;

$auth = new AuthController($conn);

$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':
        $auth->login();
        break;
    case 'dashboard':
        $auth->dashboard();
        break;
    case 'logout':
        $auth->logout();
        break;
    default:
        $auth->login();
}
