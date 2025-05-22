<?php
// register.php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

$error = "";
$success = "";

$db = new Database();
$conn = $db->connect();
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = 'client';  // Fixed role

    if ($user->register($name, $email, $password, $role)) {
        $success = "Account successfully created! You can now <a href='login.php'>login</a>.";
    } else {
        $error = "Registration failed. Email might already be taken.";
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
</head>
<body>
 <div class="container">
   <div class="left-panel">
     <div class="logo-container">
       <img class="logo" src="../assets/images/login-photo.png" alt="TRIV Logo" />
     </div>
   </div>
   <div class="right-panel">
     <div class="login-form">
       <h2>Create an Account</h2>

       <?php if (!empty($error)): ?>
         <div class="error-message" style="color: red; margin-bottom: 10px;">
           <?php echo htmlspecialchars($error); ?>
         </div>
       <?php endif; ?>

       <?php if (!empty($success)): ?>
         <div class="success-message" style="color: green; margin-bottom: 10px;">
           <?php echo $success; ?>
         </div>
       <?php endif; ?>

       <form action="register.php" method="POST">
         <div class="form-group">
           <label for="name">Full Name:</label>
           <input type="text" id="name" name="name" required />
         </div>

         <div class="form-group">
           <label for="email">Email:</label>
           <input type="email" id="email" name="email" required />
         </div>

         <div class="form-group">
           <label for="password">Password:</label>
           <input type="password" id="password" name="password" required />
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
