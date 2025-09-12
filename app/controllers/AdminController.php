<?php
class AdminController {
    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "Access denied!";
            exit;
        }
    }

    public function dashboard() {
        $user = $_SESSION['user'];
        include __DIR__ . '/../views/admin/dashboard.php';
    }
}
