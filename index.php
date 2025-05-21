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
    <img src="assets/images/trivfinalnatalaga.png" alt="TRIV Logo" class="logo">
  </div>

  <script>
    window.addEventListener('load', () => {
      setTimeout(() => {
        window.location.href = "public/index.php";
      }, 3000); // 3-second delay
    });
  </script>

</body>
</html>
