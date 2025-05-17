<?php
session_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>TRIV Design & Construction - Login</title>
 <link rel="stylesheet" href="../admin/style.css">
</head>
<body>
 <div class="container">
   <div class="left-panel">
     <div class="logo-container">
       <img class="logo" src="../assets/images/login-photo.png" alt="TRIV Logo">
     </div>
   </div>
   <div class="right-panel">
     <div class="login-form">
       <h2>Log in Here</h2>

       <?php if (!empty($error)): ?>
         <div class="error-message" style="color: red; margin-bottom: 10px;">
           <?php echo htmlspecialchars($error); ?>
         </div>
       <?php endif; ?>

       <form action="login.php" method="POST">
         <div class="form-group">
           <label for="email">Email:</label>
           <input type="email" id="email" name="email" required>
         </div>

         <div class="form-group">
           <label for="password">Password:</label>
           <input type="password" id="password" name="password" required>
         </div>

         <button type="submit" class="login-btn">Log in</button>
       </form>

     </div>
   </div>
 </div>
</body>
</html>
