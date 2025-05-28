<?php
require_once '../classes/Database.php';

$db = new Database();
$conn = $db->connect();
$job = new Job($conn);

// Get all active jobs
$jobs = $job->getActive();

// Get filter parameter
$departmentFilter = $_GET['department'] ?? 'all';

// Filter jobs if department is specified
if ($departmentFilter !== 'all') {
    $jobs = $job->getByDepartment($departmentFilter);
}

// Get unique departments for filter
$allJobs = $job->getActive();
$departments = array_unique(array_column($allJobs, 'department'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers - TRIV Design & Construction</title>
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

    <section class="career-hero">
        <div class="hero-overlay"></div>
        <img src="../assets/images/career1.jpg" alt="Construction Site" class="hero-bg">
        <div class="hero-content">
            <h1>CAREER</h1>
        </div>
    </section>

    <section class="work-culture">
        <div class="container">
            <h2>Why Join TRIV Design & Construction?</h2>
            <div class="culture-content">
                <div class="culture-text">
                    <p>At TRIV Design & Construction, we're more than just a company—we're a community of innovators, creators, and problem-solvers dedicated to transforming spaces and building dreams.</p>
                    
                    <h3>Our Values</h3>
                    <ul>
                        <li><strong>Excellence:</strong> We pursue perfection in every project, no matter the size.</li>
                        <li><strong>Innovation:</strong> We embrace new ideas and technologies to stay ahead.</li>
                        <li><strong>Integrity:</strong> We build on a foundation of honesty and transparency.</li>
                        <li><strong>Collaboration:</strong> We believe great achievements come from great teamwork.</li>
                    </ul>
                    
                    <h3>Growth Opportunities</h3>
                    <p>Join us and grow your career with continuous learning, mentorship programs, and clear advancement paths. We invest in our team because your success is our success.</p>
                </div>
                <div class="culture-image">
                    <img src="../assets/images/career_jd.jpg" alt="TRIV Team Working Together">
                </div>
            </div>
        </div>
    </section>

    <section class="job-listings">
        <div class="container">
            <h2>Current Openings</h2>
            <div class="job-filters">
                <form method="GET">
                    <select name="department" id="department-filter" onchange="this.form.submit()">
                        <option value="all" <?= $departmentFilter === 'all' ? 'selected' : '' ?>>All Departments</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= htmlspecialchars($dept) ?>" <?= $departmentFilter === $dept ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dept) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            
            <div class="jobs-container">
                <?php if (empty($jobs)): ?>
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <h3>No job openings available at the moment</h3>
                        <p>Please check back later for new opportunities.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($jobs as $jobItem): ?>
                        <div class="job-card">
                            <div class="job-header">
                                <h3><?= htmlspecialchars($jobItem['title']) ?></h3>
                                <span class="job-department"><?= htmlspecialchars($jobItem['department']) ?></span>
                            </div>
                            <div class="job-details">
                                <p class="job-location">
                                    <img src="../assets/images/jobLocation.png" alt="Location"> 
                                    <?= htmlspecialchars($jobItem['location']) ?>
                                </p>
                                <p class="job-description">
                                    <?= htmlspecialchars(substr($jobItem['description'], 0, 150)) ?>
                                    <?= strlen($jobItem['description']) > 150 ? '...' : '' ?>
                                </p>
                                <div class="job-actions">
                                    <a href="career_jobdetails.php?id=<?= $jobItem['id'] ?>" class="btn btn-outline">View Details</a>
                                    <a href="career_apply.php?job_id=<?= $jobItem['id'] ?>" class="btn btn-primary">Apply Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
            // Simple filter functionality for job listings
            document.getElementById('department-filter').addEventListener('change', function() {
                const selectedDepartment = this.value.trim().toLowerCase();
                const jobCards = document.querySelectorAll('.job-card');
                
                jobCards.forEach(card => {
                    const department = card.querySelector('.job-department').textContent.trim().toLowerCase();
                    
                    if (selectedDepartment === 'all' || department === selectedDepartment) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        </script>

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