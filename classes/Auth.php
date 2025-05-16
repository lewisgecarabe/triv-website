<?php
class Auth {
    private $conn;

    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Note: If password is hashed, use password_verify() instead.
            if ($admin['password'] === $password) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];
                return true;
            }
        }

        return false;
    }
}
?>
