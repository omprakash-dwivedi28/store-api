<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findUser($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username AND password = :password LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':username' => $username,
            ':password' => md5($password)
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
