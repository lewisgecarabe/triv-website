<?php
session_start();
require '../classes/Database.php';
require '../classes/User.php';

$db = new Database();
$conn = $db->connect();
$user = new User($conn);

// Handle Cookie Login
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['role'] = $_COOKIE['user_role'];
    redirectBasedOnRole($_SESSION['role']);
}

// Handle Form Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $remember = isset($_POST['remember']);

    $loggedInUser = $user->login($email, $pass);

    if ($loggedInUser) {
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['role'] = $loggedInUser['role'];

        if ($remember) {
            setcookie('user_id', $loggedInUser['id'], time() + (86400 * 30), "/");
            setcookie('user_role', $loggedInUser['role'], time() + (86400 * 30), "/");
        }

        redirectBasedOnRole($loggedInUser['role']);
    } else {
        echo "Invalid login credentials.";
    }
}

function redirectBasedOnRole($role) {
    if ($role === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
}
?>

<form method="POST">
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <label><input type="checkbox" name="remember"> Remember Me</label><br>
  <button type="submit">Login</button>
</form>
