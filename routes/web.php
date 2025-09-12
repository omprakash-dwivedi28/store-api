<?php
$route = $_GET['route'] ?? 'login';

// Auth Controller
require_once __DIR__ . '/../app/controllers/AuthController.php';
$authController = new AuthController();

// Routes
switch ($route) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login($_POST);
        } else {
            $authController->showLogin();
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'admin-dashboard':
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;

    case 'user-dashboard':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->dashboard();
        break;

    default:
        echo "404 - Page Not Found";
}
