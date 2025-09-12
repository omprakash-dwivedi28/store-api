<?php
class UserController {
    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            echo "Access denied!";
            exit;
        }
    }

    public function dashboard() {
        $user = $_SESSION['user'];
        include __DIR__ . '/../views/user/dashboard.php';
    }
}
