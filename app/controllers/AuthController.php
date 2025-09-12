<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/db.php';

class AuthController {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function showLogin() {
        include __DIR__ . '/../views/login.php';
    }

    public function login($data) {
        $username = trim($data['username']);
        $password = trim($data['password']);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // if ($user && password_verify($password, $user['password']))
        if ($user && $user['password'] === md5($password)) 

             {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            if ($user['role'] === 'admin') {
                header("Location: /store-api/public/index.php?route=admin-dashboard");
            } else {
                header("Location: /store-api/public/index.php?route=user-dashboard");
            }
            exit;
        } else {
            
            $error = "Invalid username or password!,$username,$password";
            include __DIR__ . '/../views/login.php';
        }
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header("Location: /store-api/public/index.php?route=login");
        exit;
    }
}
