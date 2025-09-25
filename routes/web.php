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

    case 'billing':
           include __DIR__ . '/../app/views/user/billing.php';
            break;
     case 'cust_wise_due':
           include __DIR__ . '/../app/views/user/customer_due.php';
            break;

    case 'save_bill':
        include __DIR__ . '/../app/views/user/save_bill.php';
        break;

    case 'area_master':
           include __DIR__ . '/../app/views/admin/area_master.php';
            break;
    case 'add':
           include __DIR__ . '/../app/views/admin/area_master.php';
            break;
    case 'cust_master':
           include __DIR__ . '/../app/views/admin/customer_master.php';
            break;
    case 'customer_edit':
           include __DIR__ . '/../app/views/admin/customer_edit.php';
            break;
    case 'customer_update':
           include __DIR__ . '/../app/views/admin/customer_update.php';
            break;
     case 'customer_detail':
           include __DIR__ . '/../app/views/admin/customer_detail.php';
            break;
      case 'customer_add':
           include __DIR__ . '/../app/views/admin/customer_add.php';
            break;
            

    default:
        echo "404 - Page Not Found";
}
