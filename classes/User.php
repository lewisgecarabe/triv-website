<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $password, $role = 'client') {
    // 1. Check if email already exists
    $check = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        return false;  // Email already registered
    }

    // 2. If not, proceed to insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $hashed_password, $role]);
}


    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
?>
