<?php
require_once '../classes/Auth.php';
require_once '../classes/Database.php';

// Ensure only admins can access this page
Auth::checkAdminAccess();

$db = new Database();
$conn = $db->connect();

$project = new Project($conn);
$user = new User($conn);
$service = new Service($conn);
$contactInquiry = new ContactInquiry($conn);
$job = new Job($conn);
$jobApplication = new JobApplication($conn);
$developer = new Developer($conn);
$teamMember = new TeamMember($conn);

// Get dashboard statistics
$projectCount = $project->getCount();
$userCount = $user->getCount();
$serviceCount = $service->getCount();
$inquiryCount = $contactInquiry->getCount();
$pendingInquiries = $contactInquiry->getPendingCount();
$recentInquiries = $contactInquiry->getRecentInquiries();
$developerCount = $developer->getCount();
$jobCount = $job->getCount();
$applicationCount = $jobApplication->getCount();
$pendingApplications = $jobApplication->getPendingCount();
$recentApplications = $jobApplication->getRecentApplications(3);
$teamMemberCount = $teamMember->getCount();

$userName = Auth::getUserName();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - TRIV</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
   * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
font-family: 'Lato', sans-serif;
}
    
    body { 
      display: flex; 
      height: 100vh; 
     color: #333;
    }
    
    aside { 
      width: 250px; 
      background: #1a2b49; 
      color: white; 
      padding: 20px; 
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    
    aside h2 { 
      margin-bottom: 30px; 
      text-align: center;
      color: #ffc107;
      font-size: 1.5em;
    }
    
    aside ul { 
      list-style: none; 
    }
    
    aside ul li { 
      margin: 15px 0; 
    }
    
    aside ul li a { 
      color: white; 
      text-decoration: none; 
      display: flex; 
      align-items: center; 
      padding: 12px 15px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    aside ul li a:hover {
      background: rgba(97, 218, 251, 0.1);
      transform: translateX(5px);
    }
    
    aside ul li a i { 
      margin-right: 12px; 
      width: 20px;
      text-align: center;
    }
    
    aside ul li a.active { 
      background: #ffc107; 
      box-shadow: 0 2px 10px rgba(83, 86, 88, 0.3);
    }
    
    .logout-btn {
      margin-top: 30px !important;
      border-top: 1px solid #333;
      padding-top: 20px !important;
    }
    
    .logout-btn a {
      color: #ff6b6b !important;
    }
    
    main { 
      flex: 1; 
      padding: 20px; 
      overflow-y: auto;
    }
    
    header { 
      background: white; 
      padding: 25px; 
      box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
      margin-bottom: 25px; 
      border-radius: 12px;
      border-left: 4px solid #1a2b49;
    }
    
    header h1 {
      color: #333;
      font-size: 1.8em;
      margin-bottom: 5px;
    }
    
    header p {
      color: #666;
      font-size: 1em;
    }
    
    .card-container { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
      gap: 20px; 
      margin-bottom: 30px;
    }
    
    .card { 
      background: white; 
      padding: 25px; 
      border-radius: 12px; 
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
      cursor: pointer;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #1a2b49, #1a2b49);
    }
    
    .card h3 { 
      margin-bottom: 15px; 
      color: #333; 
      font-size: 1.1em;
      font-weight: 600;
    }
    
    .card p { 
      color: #777; 
      font-size: 14px; 
      margin-bottom: 15px;
    }
    
    .btn { 
      display: inline-block; 
      background: #007bff; 
      color: white; 
      padding: 10px 16px; 
      text-decoration: none; 
      border-radius: 6px; 
      font-size: 14px;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
    }
    
    .btn:hover { 
      background: #0056b3; 
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
    
    .btn.btn-success {
      background: #28a745;
    }
    
    .btn.btn-success:hover {
      background: #1e7e34;
      box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    
    .count { 
      font-size: 2.5em; 
      font-weight: bold; 
      color: #007bff; 
      margin-bottom: 10px;
      display: block;
    }
    
    .badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #dc3545;
      color: white;
      border-radius: 50%;
      width: 25px;
      height: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: bold;
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    
    .recent-section {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      margin-top: 20px;
    }
    
    .recent-section h2 {
      color: #333;
      margin-bottom: 20px;
      font-size: 1.3em;
      border-bottom: 2px solid #f0f0f0;
      padding-bottom: 10px;
    }
    
    .inquiry-item {
      padding: 15px;
      border-left: 3px solid #007bff;
      background: #f8f9fa;
      margin-bottom: 15px;
      border-radius: 0 8px 8px 0;
      transition: all 0.3s ease;
    }
    
    .inquiry-item:hover {
      background: #e9ecef;
      transform: translateX(5px);
    }
    
    .inquiry-item h4 {
      color: #333;
      margin-bottom: 5px;
      font-size: 1em;
    }
    
    .inquiry-item p {
      color: #666;
      font-size: 0.9em;
      margin-bottom: 5px;
    }
    
    .inquiry-item .meta {
      color: #999;
      font-size: 0.8em;
    }
    
    .status-badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 0.75em;
      font-weight: bold;
      text-transform: uppercase;
    }
    
    .status-pending {
      background: #fff3cd;
      color: #856404;
    }
    
    .status-in-progress {
      background: #cce5ff;
      color: #004085;
    }
    
    .status-completed {
      background: #d4edda;
      color: #155724;
    }
    
    .empty-state {
      text-align: center;
      color: #666;
      font-style: italic;
      padding: 40px 20px;
    }
    
    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }
      
      aside {
        width: 100%;
        padding: 15px;
      }
      
      aside ul {
        display: flex;
        overflow-x: auto;
        gap: 10px;
      }
      
      aside ul li {
        margin: 0;
        white-space: nowrap;
      }
      
      main {
        padding: 15px;
      }
      
      .card-container {
        grid-template-columns: 1fr;
      }
    }

    img {
      max-width: 100%;
       height: 40px;
}
  </style>
</head>
<body>
  <aside>
    <h2><img src = ../assets/images/trivfinalnatalaga.png></h2>
    <ul>
      <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
      <li><a href="projects.php"><i class="fas fa-tools"></i> Projects</a></li>
      <li><a href="manage-users.php"><i class="fas fa-users"></i> Users</a></li>
      <li><a href="services.php"><i class="fas fa-concierge-bell"></i> Services</a></li>
       <li><a href="manage-jobs.php"><i class="fas fa-briefcase"></i> Jobs</a></li>
            <li><a href="manage-applications.php"><i class="fas fa-file-alt"></i> Applications</a></li>
            <li><a href="manage-team.php"><i class="fas fa-users-cog"></i> Team Members</a></li>
            <li><a href="manage-developers.php"><i class="fas fa-code"></i> Developers</a></li>
            <li><a href="manage-inquiries.php"><i class="fas fa-envelope"></i> Inquiries</a></li>
      <li class="logout-btn"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </aside>

  <main>
    <header>
      <h1><i class="fas fa-user-shield"></i> Welcome back, <?= htmlspecialchars($userName) ?>!</h1>
      <p>Admin Dashboard - TRIV Design & Construction</p>
    </header>

    <div class="card-container">
      <div class="card" onclick="window.location.href='projects.php'">
        <h3><i class="fas fa-tools"></i> Total Projects</h3>
        <div class="count"><?= $projectCount ?></div>
        <p><?= $projectCount ?> active projects in portfolio</p>
        <a href="projects.php" class="btn"><i class="fas fa-cog"></i> Manage Projects</a>
      </div>

      <div class="card" onclick="window.location.href='manage-users.php'">
        <h3><i class="fas fa-users"></i> Total Users</h3>
        <div class="count"><?= $userCount ?></div>
        <p><?= $userCount ?> registered users</p>
        <a href="manage-users.php" class="btn"><i class="fas fa-user-cog"></i> Manage Users</a>
      </div>

      <div class="card" onclick="window.location.href='services.php'">
        <h3><i class="fas fa-concierge-bell"></i> Total Services</h3>
        <div class="count"><?= $serviceCount ?></div>
        <p><?= $serviceCount ?> active services offered</p>
        <a href="services.php" class="btn"><i class="fas fa-edit"></i> Manage Services</a>
      </div>
      
<div class="card" onclick="window.location.href='manage-team.php'">
      <h3><i class="fas fa-users-cog"></i> Team Members</h3>
      <div class="count"><?= $teamMemberCount ?></div>
      <p><?= $teamMemberCount ?> team members</p>
      <a href="manage-team.php" class="btn btn-info">
        <i class="fas fa-users"></i> Manage Team
      </a>
    </div>

       <div class="card">
        <h3><i class="fas fa-briefcase"></i> Job Postings</h3>
        <div class="count"><?= $jobCount ?></div>
        <p><?= $jobCount ?> active job postings</p>
        <a href="manage-jobs.php" class="btn btn-warning"><i class="fas fa-plus"></i> Manage Jobs</a>
      </div>

      <div class="card" onclick="window.location.href='manage-applications.php'">
        <?php if ($pendingApplications > 0): ?>
          <div class="badge"><?= $pendingApplications ?></div>
        <?php endif; ?>
        <h3><i class="fas fa-file-alt"></i> Job Applications</h3>
        <div class="count"><?= $applicationCount ?></div>
        <p><?= $applicationCount ?> total applications
          <?php if ($pendingApplications > 0): ?>
            <br><strong style="color: #dc3545;"><?= $pendingApplications ?> pending review</strong>
          <?php endif; ?>
        </p>
        <a href="manage-applications.php" class="btn btn-success">
          <i class="fas fa-eye"></i> Review Applications
        </a>
      </div>

      <div class="card" onclick="window.location.href='manage-inquiries.php'">
        <?php if ($pendingInquiries > 0): ?>
          <div class="badge"><?= $pendingInquiries ?></div>
        <?php endif; ?>
        <h3><i class="fas fa-envelope"></i> Contact Inquiries</h3>
        <div class="count"><?= $inquiryCount ?></div>
        <p><?= $inquiryCount ?> total inquiries 
          <?php if ($pendingInquiries > 0): ?>
            <br><strong style="color: #dc3545;"><?= $pendingInquiries ?> pending review</strong>
          <?php endif; ?>
        </p>
        <a href="manage-inquiries.php" class="btn btn-success">
          <i class="fas fa-envelope-open"></i> Manage Inquiries
        </a>
      </div>
        <div class="card" onclick="window.location.href='manage-developers.php'">
    <h3><i class="fas fa-code"></i> Developers</h3>
    <div class="count"><?= $developerCount ?></div>
    <p><?= $developerCount ?> developers in the team</p>
    <a href="manage-developers.php" class="btn btn-primary">
        <i class="fas fa-users-cog"></i> Manage Developers
    </a>
</div>
    </div>
  </main>




  <script>
    // Add some interactive features
    document.addEventListener('DOMContentLoaded', function() {
      // Add click animation to cards
      const cards = document.querySelectorAll('.card');
      cards.forEach(card => {
        card.addEventListener('click', function(e) {
          if (!e.target.closest('.btn')) {
            const btn = this.querySelector('.btn');
            if (btn) {
              btn.click();
            }
          }
        });
      });

      // Auto-refresh pending count every 30 seconds
      setInterval(function() {
        fetch('get-pending-count.php')
          .then(response => response.json())
          .then(data => {
            const badge = document.querySelector('.badge');
            if (data.count > 0) {
              if (badge) {
                badge.textContent = data.count;
              } else {
                // Create badge if it doesn't exist
                const card = document.querySelector('.card:last-child');
                const newBadge = document.createElement('div');
                newBadge.className = 'badge';
                newBadge.textContent = data.count;
                card.appendChild(newBadge);
              }
            } else if (badge) {
              badge.remove();
            }
          })
          .catch(error => console.log('Error fetching pending count:', error));
      }, 30000);
    });
  </script>
</body>
</html>