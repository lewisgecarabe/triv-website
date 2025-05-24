<?php
require_once '../classes/Auth.php';
require_once '../classes/Database.php';

Auth::requireLogin();
Auth::requireRole('admin');

$db = new Database();
$conn = $db->connect();

$project = new Project($conn);
$user = new User($conn);

$projectCount = $project->getCount();
$userCount = $user->getCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - TRIV</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
    body { display: flex; height: 100vh; background: #f4f6f8; }
    aside { width: 250px; background: #20232a; color: white; padding: 20px; }
    aside h2 { margin-bottom: 20px; }
    aside ul { list-style: none; }
    aside ul li { margin: 20px 0; }
    aside ul li a { color: white; text-decoration: none; display: flex; align-items: center; }
    aside ul li a i { margin-right: 10px; }
    aside ul li a.active { background: #007bff; padding: 10px; border-radius: 5px; }
    main { flex: 1; padding: 20px; }
    header { background: white; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; border-radius: 8px; }
    .card-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .card h3 { margin-bottom: 10px; color: #333; }
    .card p { color: #777; font-size: 14px; }
    .btn { display: inline-block; margin-top: 10px; background: #007bff; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
    .btn:hover { background: #0056b3; }
    .count { font-size: 2em; font-weight: bold; color: #007bff; }
  </style>
</head>
<body>
  <aside>
    <h2>TRIV Admin</h2>
    <ul>
      <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
      <li><a href="projects.php"><i class="fas fa-tools"></i> Projects</a></li>
      <li><a href="#"><i class="fas fa-users"></i> Users</a></li>
      <li><a href="#"><i class="fas fa-concierge-bell"></i> Services</a></li>
      <li><a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </aside>

  <main>
    <header>
      <h1>Welcome, Admin</h1>
    </header>

    <div class="card-container">
      <div class="card">
        <h3>Total Projects</h3>
        <div class="count"><?= $projectCount ?></div>
        <p><?= $projectCount ?> active projects</p>
        <a href="projects.php" class="btn">Manage Projects</a>
      </div>

      <div class="card">
        <h3>Total Users</h3>
        <div class="count"><?= $userCount ?></div>
        <p><?= $userCount ?> registered users</p>
        <a href="#" class="btn">Manage Users</a>
      </div>

      <div class="card">
        <h3>Total Services</h3>
        <div class="count">4</div>
        <p>4 core services</p>
        <a href="#" class="btn">Manage Services</a>
      </div>
    </div>
  </main>
</body>
</html>