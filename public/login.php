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

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $loginResult = $user->login($email, $password);
        
        if ($loginResult['success']) {
            Auth::login($loginResult['user'], $remember);
            
            // Check for redirect URL
            $redirectUrl = Auth::getLoginRedirectUrl();
            if ($redirectUrl) {
                header("Location: " . $redirectUrl);
            } else {
                Auth::redirectBasedOnRole($loginResult['user']['role']);
            }
            exit();
        } else {
            $error = $loginResult['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TRIV Design & Construction - Login</title>
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
        <!-- Left Panel with Image -->
        <div class="left-panel">
            <div class="logo-container">
                <img class="logo" src="../assets/images/login-photo.png" alt="TRIV Logo" />
            </div>
        </div>

        <!-- Right Panel with Login Form -->
        <div class="right-panel">
            <div class="login-form">
                <h2>Login to Your Account</h2>

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

                <form method="POST" action="login.php<?= isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : '' ?>">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required />
                    </div>

                    <div class="form-group remember-me">
                        <label>
                            <input type="checkbox" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>> 
                            Remember Me (30 days)
                        </label>
                    </div>

                    <button type="submit" class="login-btn">Login</button>
                </form>

                <p style="margin-top: 15px;">
                    Don't have an account? <a href="register.php">Register here</a>.
                </p>
                
                <p style="margin-top: 10px;">
                    <a href="index.php">← Back to Home</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>