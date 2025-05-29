<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/auth.php';


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit();
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit();
}

$db = new Database();
$conn = $db->connect();
$user = new User($conn);
$contactInquiry = new ContactInquiry($conn);

$userId = $_SESSION['user_id'];
$userInfo = $user->getUserById($userId);

// Get user's projects/inquiries
$userInquiries = $contactInquiry->getInquiriesByUser($userId);

// Get active tab (default to projects)
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'projects';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Portal - TRIV</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
font-family: 'Lato', sans-serif;
}

body {
  line-height: 1.6;
  color: #333;
  overflow-x: hidden;
}
        .header {
            background:rgb(92, 94, 99);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
img {
  max-width: 100%;
  height: 40px;
}
        .header .img {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header .logout-btn {
            background: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.3s;
            font-size: 0.9rem;
        }

        .header .logout-btn:hover {
            background: #c82333;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border-left: 4px solid #1a2b49;
        }

        .welcome-card h1 {
            color: #1a2b49;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }

        .welcome-card p {
            color: #666;
            margin-bottom: 0;
        }

        .tabs {
            display: flex;
            background: white;
            border-radius: 12px 12px 0 0;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .tab {
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .tab:hover {
            background: #f8f9fa;
            color: #1a2b49;
        }

        .tab.active {
            background: #1a2b49;
            color: white;
        }

        .tab .badge {
            background: #dc3545;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }

        .tab-content {
            background: white;
            padding: 2rem;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            min-height: 400px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        /* Projects Tab Styles */
        .project-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #1a2b49;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .project-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .project-title {
            font-weight: 600;
            color: #1a2b49;
            font-size: 1.1rem;
        }

        .project-status {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
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

        .project-details {
            color: #666;
            margin-bottom: 1rem;
        }

        .project-meta {
            display: flex;
            gap: 1.5rem;
            color: #888;
            font-size: 0.9rem;
        }

        .project-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }



        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1rem;
            }
            
            .tabs {
                flex-direction: column;
            }
            
            .tab {
                border-bottom: 1px solid #eee;
            }
            
            .documents-grid {
                grid-template-columns: 1fr;
            }
            
            .project-header, .project-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        /* Hamburger menu button - always visible */
.menu-toggle {
  display: block;
  background: none;
  border: none;
  color: white;
  font-size: 24px;
  cursor: pointer;
  z-index: 1001;
  padding: 5px 10px;
  position: relative; /* This makes positioning work with nav below */
}

/* Position nav BELOW the button */
nav {
  position: absolute;
  top: 60px; /* Adjust based on header height */
  right: 20px; /* Align with right side */
  width: 250px;
  background-color: rgba(0, 0, 0, 0.9);
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
  z-index: 1000;
}
a {
  text-decoration: none;
}

nav.active {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}


/* Vertical navigation list */
nav ul {
  display: flex;
  flex-direction: column; /* Stack vertically */
  list-style: none;
  padding: 15px 0;
  margin: 0;
}

nav ul li {
  margin: 0;
  width: 100%;
}

nav ul li a {
  font-family: 'Lato', sans-serif;
  font-weight: 400;
  font-size: 14px; /* Increased from 10px for better readability */
  letter-spacing: 2px;
  text-transform: uppercase;
  color: white;
  transition: 0.3s;
  display: block;
  padding: 12px 20px;
  border-left: 3px solid transparent;
}

nav ul li a:hover {
  color: #ffc107;
  background-color: rgba(255, 255, 255, 0.1);
  border-left: 3px solid #1a2b49;
}

/* Footer */
footer {
  background-color: #333;
  color: white;
  padding: 20px 2%;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  width: auto;
}

.footer-logo {
  margin-bottom: 1px;
}

.footer-logo img {
  height: 30px;
  width: auto;
}

.copyright {
  font-size: 14px;
  color: #aaa;
}


/* For larger screens, you might want to adjust the width */
@media (min-width: 1200px) {
  nav {
    width: 300px;
  }
}

/* For smaller screens, make sure everything fits */
@media (max-width: 768px) {
  header {
    padding: 10px 5%;
  }
  
  .logo img {
    height: 30px;
  }
  
  nav {
    width: 100%; /* Full width on mobile */
    right: 0;
  }
}

    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../assets/images/trivfinalnatalaga.png">
        </div>
        <div class="user-info">
            Welcome, <?= htmlspecialchars($userInfo['name']) ?>
               <button class="menu-toggle" aria-label="Toggle menu">☰</button>
   
        </div>
         <nav>
        <ul>
            <li><a href="../public/index.php">HOME</a></li>
            <li><a href="../public/developers.php">ABOUT US</a></li>
            <li><a href="../public/services.php">SERVICES</a></li>
            <li><a href="../public/projects.php">PROJECTS</a></li>
            <li><a href="../public/career.php">CAREERS</a></li>
            <li><a href="../public/contact.php">CONTACT US</a></li>
            <hr>
                 <?php if (Auth::isLoggedIn()): ?>
                     <li>
        <a href="../public/account.php"><i class="fas fa-user-cog"></i> ACCOUNT</a>
    </li>
                <li >
  <a href="../public/logout.php"><i class="fas fa-sign-out-alt"></i> LOGOUT</a></i>
</li>
                <?php if (Auth::isAdmin()): ?>
                    <li><a href="../admin/dashboard.php">ADMIN</a></li>

                <?php endif; ?>
            <?php else: ?>
                <li><a href="../public/login.php"><i class="fas fa-sign-in-alt"></i> LOGIN/SIGNUP</a></li>
<?php endif; ?>
        </ul>
    </nav>
    </header>

    <div class="container">
        <div class="welcome-card">
            <h1>Welcome to Your Client Portal</h1>
            <p>Access your projects, documents, and communicate with our team all in one place.</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs">
            <div class="tab <?= $activeTab === 'projects' ? 'active' : '' ?>" data-tab="projects">
                <i class="fas fa-clipboard-check"></i> Project Status
                <?php if (count($userInquiries) > 0): ?>
                    <span class="badge"><?= count($userInquiries) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Projects Tab -->
            <div class="tab-pane <?= $activeTab === 'projects' ? 'active' : '' ?>" id="projects">
                <h2 style="margin-bottom: 1.5rem;">Your Projects</h2>
                
                <?php if (empty($userInquiries)): ?>
                    <div class="empty-state">
                        <i class="fas fa-clipboard"></i>
                        <h3>No Projects Yet</h3>
                        <p>You don't have any active projects or inquiries at the moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($userInquiries as $inquiry): ?>
                        <div class="project-card">
                            <div class="project-header">
                                <div class="project-title">
                                    Inquiry #<?= $inquiry['id'] ?>: <?= htmlspecialchars($inquiry['subject'] ?? 'General Inquiry') ?>
                                </div>
                                <span class="project-status status-<?= $inquiry['status'] ?>">
                                    <?= ucfirst(str_replace('_', ' ', $inquiry['status'])) ?>
                                </span>
                            </div>
                            <div class="project-details">
                                <?= htmlspecialchars(substr($inquiry['message'], 0, 200)) ?><?= strlen($inquiry['message']) > 200 ? '...' : '' ?>
                            </div>
                            <div class="project-meta">
                                <span><i class="fas fa-calendar"></i> Submitted: <?= date('M j, Y', strtotime($inquiry['created_at'])) ?></span>
                                <?php if ($inquiry['updated_at'] !== $inquiry['created_at']): ?>
    
                                <?php endif; ?>
                                <?php if (!empty($inquiry['plan_file'])): ?>
                                    <span><i class="fas fa-paperclip"></i> File Attached</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuToggle = document.querySelector('.menu-toggle');
            const nav = document.querySelector('nav');
            
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    nav.classList.toggle('active');
                });
            }
            
            // Close menu when clicking on a link
            const navLinks = document.querySelectorAll('nav ul li a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    nav.classList.remove('active');
                });
            });
        });
    </script>
</body>
</html>