<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TRIV Website</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- Loader -->
  <div id="loader">
    <img src="assets/images/triv-logo.png" alt="TRIV Logo" class="logo">
  </div>

  <!-- Role Selection -->
  <div id="role-selector" style="display: none;">
    <h1>Welcome to TRIV</h1>
    <p>Choose your role: yeyyeyeyeyeye</p>
    <div class="buttons">
      <a href="public/index.php" class="btn client-btn">Client</a>
      <a href="admin/admin.php" class="btn admin-btn">Admin</a>
    </div>
  </div>

  <script>
    // Loader timeout
    window.addEventListener('load', () => {
      setTimeout(() => {
        document.getElementById('loader').style.display = 'none';
        document.getElementById('role-selector').style.display = 'block';
      }, 3000); // 2.5 seconds
    });
  </script>

</body>
</html>
