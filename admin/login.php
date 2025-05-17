<?php
session_start();
require_once "../classes/Database.php";
require_once "../classes/Auth.php";

$error = "";

$db = new Database();
$conn = $db->connect();
$auth = new Auth($conn);

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($auth->login($email, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>