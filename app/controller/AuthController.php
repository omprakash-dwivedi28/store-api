<?php
session_start();

class AuthController {
    private $userModel;

    public function __construct($db) {
        require_once __DIR__ . "/../models/User.php";
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findUser($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header("Location: index.php?route=dashboard");
                exit;
            } else {
                $error = "Invalid username or password";
                include __DIR__ . "/../views/login.php";
            }
        } else {
            include __DIR__ . "/../views/login.php";
        }
    }

    public function dashboard() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?route=login");
            exit;
        }

        $user = $_SESSION['user'];
        include __DIR__ . "/../views/dashboard.php";
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?route=login");
        exit;
    }
}
