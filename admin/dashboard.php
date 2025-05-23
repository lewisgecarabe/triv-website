<?php
require_once '../classes/Auth.php';
Auth::requireLogin();
Auth::requireRole('admin');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
    <p>This is the admin dashboard.</p>
    <a href="../public/index.php">Logout</a>
</body>
</html>
