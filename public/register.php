<?php
require_once '../classes/Database.php';
require_once '../classes/Auth.php';

Auth::startSession();

// Redirect if already logged in
if (Auth::isLoggedIn()) {
    Auth::redirectBasedOnRole();
}

$db = new Database();
$conn = $db->connect();
$user = new User($conn);

$error = "";
$success = "";

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $registerResult = $user->register($name, $email, $password, 'client');
        
        if ($registerResult['success']) {
            $success = $registerResult['message'] . " You can now log in.";
        } else {
            $error = $registerResult['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TRIV Design & Construction - Register</title>
    <link rel="stylesheet" href="../admin/style.css" />
    <style>
        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #fcc;
        }
        .success-message {
            background-color: #efe;
            color: #363;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #cfc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo-container">
                <img class="logo" src="../assets/images/trivfinalnatalaga.png" alt="TRIV Logo" />
            </div>
        </div>
        
        <div class="right-panel">
            <div class="login-form">
                <p style="margin-bottom: 10px;">
                    <a href="index.php">← Back to Home</a>
                </p>
                <h2>Create an Account</h2>

                <?php if (!empty($error)): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="success-message">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="register.php">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required />
                        <small>Minimum 6 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required />
                    </div>

                    <button type="submit" class="login-btn">Register</button>
                </form>

                <p style="margin-top: 15px;">
                    Already have an account? <a href="login.php">Login here</a>.
                </p>
                
            
            </div>
        </div>
    </div>
</body>
</html>