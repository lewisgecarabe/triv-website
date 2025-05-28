<?php
require_once '../classes/Database.php';

$db = new Database();
$conn = $db->connect();
$job = new Job($conn);

// Get job ID from URL
$job_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($job_id === 0) {
    header('Location: career.php');
    exit;
}

// Get job details
$jobDetails = $job->getById($job_id);

if (!$jobDetails) {
    header('Location: career.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details - TRIV Design & Construction</title>
    <link rel="stylesheet" href="../assets/css/public-style.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../assets/images/trivfinalnatalaga.png" alt="TRIV Design & Construction">
    </div>
    <!-- Make sure the button is OUTSIDE the nav element -->
    <button class="menu-toggle" aria-label="Toggle menu">☰</button>
    <nav>
        <ul>
            <li><a href="../public/index.php">HOME</a></li>
            <li><a href="../public/services.php">SERVICES</a></li>
            <li><a href="../public/developers.php">ABOUT US</a></li>
            <li><a href="../public/contact.php">CONTACT US</a></li>
            <li><a href="../public/career.php">CAREERS</a></li>
            <li><a href="../public/projects.php">PROJECTS</a></li>
        </ul>
    </nav>
</header>

<section class="job-details-hero" style="position: relative;">
    <img src="../assets/images/JOBBB.jpg" alt="Job Hero" style="width: 100%; height: auto; display: block;">

    <div class="job-details-hero-content" style="
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        text-align: center;
        z-index: 1;">
        <h1 style="font-size: 3rem; margin: 0;">JOB DETAILS</h1>
    </div>
</section>


   <section class="job-details-content">
    <div class="container">
        <a href="career.php" class="back-link"><span>←</span> Back to All Jobs</a>
        
        <div class="job-header">
            <h2><?= htmlspecialchars($jobDetails['title']) ?></h2>
            <div class="job-meta">
                <span class="department"><?= htmlspecialchars($jobDetails['department']) ?></span>
                <span class="location"><?= htmlspecialchars($jobDetails['location']) ?></span>
                <span class="employment-type"><?= ucfirst($jobDetails['employment_type']) ?></span>
            </div>
        </div>
        
        <div class="job-description">
            <p><?= htmlspecialchars($jobDetails['description']) ?></p>
        </div>
        
        <div class="job-section">
            <h3>Duties and Responsibilities</h3>
            <ul>
                <?php 
                $responsibilities = explode("\n", $jobDetails['responsibilities']);
                foreach ($responsibilities as $responsibility): 
                    $responsibility = trim($responsibility);
                    if (!empty($responsibility)):
                ?>
                    <li><?= htmlspecialchars($responsibility) ?></li>
                <?php 
                    endif;
                endforeach; 
                ?>
            </ul>
        </div>
        
        <div class="job-section">
            <h3>Qualifications</h3>
            <ul>
                <?php 
                $qualifications = explode("\n", $jobDetails['qualifications']);
                foreach ($qualifications as $qualification): 
                    $qualification = trim($qualification);
                    if (!empty($qualification)):
                ?>
                    <li><?= htmlspecialchars($qualification) ?></li>
                <?php 
                    endif;
                endforeach; 
                ?>
            </ul>
        </div>
        
        <?php if (!empty($jobDetails['schedule'])): ?>
        <div class="job-section">
            <h3>Work Schedule</h3>
            <p><?= htmlspecialchars($jobDetails['schedule']) ?></p>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($jobDetails['benefits'])): ?>
        <div class="job-section">
            <h3>Compensation and Benefits</h3>
            <ul>
                <?php 
                $benefits = explode("\n", $jobDetails['benefits']);
                foreach ($benefits as $benefit): 
                    $benefit = trim($benefit);
                    if (!empty($benefit)):
                ?>
                    <li><?= htmlspecialchars($benefit) ?></li>
                <?php 
                    endif;
                endforeach; 
                ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($jobDetails['salary_range'])): ?>
        <div class="job-section">
            <h3>Salary Range</h3>
            <p><?= htmlspecialchars($jobDetails['salary_range']) ?></p>
        </div>
        <?php endif; ?>
        
        <div class="job-apply">
            <a href="career_apply.php?job_id=<?= $jobDetails['id'] ?>" class="btn btn-primary">Apply for this Position</a>
        </div>
    </div>
</section>

<section class="company-contact">
        <div class="company-description">
            <h2>TRIV Design & Studio is a Filipino owned company specializing in design & construction services.</h2>
            <p>The company brings together a highly skilled technical staff to ensure that excellence in design services standards are achieved to the satisfaction of the clients and owners.</p>
        </div>
        
        <div class="contact-info">
            <div class="contact-item">
                <div class="icon">
                    <img src="../assets/images/email.png" alt="Email">
                </div>
                <p>nrvillanueva8@yahoo.com</p>
            </div>
            
            <div class="contact-item">
                <div class="icon">
                    <img src="../assets/images/phone.png" alt="Phone">
                </div>
                <p>0908-742-0857</p>
            </div>
            
            <div class="contact-item">
                <div class="icon">
                    <img src="../assets/images/location.jpg" alt="Location">
                </div>
                <p>322 National Highway,<br>Masaya, Rosario Batangas</p>
            </div>

            
        </div>
    </section>

   <footer>
        <div class="footer-logo">
            <img src="../assets/images/triv-logo.png" alt="TRIV Design & Construction">
        </div>
        <div class="copyright">
            <?php echo '© Copyright ' . date('Y') . ' TRIV Design & Construction | All Rights Reserved | Built by: Lance Bericio, Lewis Guicante, Noel Villanueva'; ?>
        </div>
    </footer>

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