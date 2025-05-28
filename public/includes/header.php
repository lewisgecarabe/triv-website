<?php
require_once '../classes/Auth.php';
require_once '../classes/Database.php';

// Require login to access profile
Auth::requireLogin();

$db = new Database();
$conn = $db->connect();
$userObj = new User($conn);

$userId = Auth::getUserId();
$user = $userObj->getUserById($userId);

$message = '';
$messageType = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validate current password if trying to change password
    if (!empty($newPassword)) {
        if (empty($currentPassword)) {
            $message = 'Current password is required to change password.';
            $messageType = 'error';
        } elseif (!password_verify($currentPassword, $user['password'])) {
            $message = 'Current password is incorrect.';
            $messageType = 'error';
        } elseif ($newPassword !== $confirmPassword) {
            $message = 'New passwords do not match.';
            $messageType = 'error';
        } elseif (strlen($newPassword) < 6) {
            $message = 'New password must be at least 6 characters long.';
            $messageType = 'error';
        }
    }
    
    if (empty($message)) {
        $updateData = [
            'name' => $name,
            'email' => $email,
            'role' => $user['role'], // Keep existing role
            'status' => $user['status'] // Keep existing status
        ];
        
        if (!empty($newPassword)) {
            $updateData['password'] = $newPassword;
        }
        
        if ($userObj->update($userId, $updateData)) {
            // Update session data
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            
            $message = 'Profile updated successfully!';
            $messageType = 'success';
            
            // Refresh user data
            $user = $userObj->getUserById($userId);
        } else {
            $message = 'Error updating profile. Email may already be in use.';
            $messageType = 'error';
        }
    }
}

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - TRIV Design & Construction</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f8; }
        
        .container { max-width: 800px; margin: 50px auto; padding: 20px; }
        .profile-card { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); padding: 30px; }
        .profile-header { text-align: center; margin-bottom: 30px; }
        .profile-header h1 { color: #333; margin-bottom: 10px; }
        .profile-header p { color: #666; }
        
        .message { padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .message.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        
        .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 14px; transition: all 0.3s ease; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
        
        .password-section { border-top: 1px solid #eee; padding-top: 30px; margin-top: 30px; }
        .password-section h3 { color: #333; margin-bottom: 20px; }
        
        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
            .container { margin: 20px; padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <h1><i class="fas fa-user-circle"></i> My Profile</h1>
                <p>Manage your account information and settings</p>
            </div>
            
            <?php if ($message): ?>
                <div class="message <?= $messageType ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                </div>
                
                <div class="password-section">
                    <h3><i class="fas fa-lock"></i> Change Password</h3>
                    <p style="color: #666; margin-bottom: 20px;">Leave password fields empty if you don't want to change your password.</p>
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" minlength="6">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" minlength="6">
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
