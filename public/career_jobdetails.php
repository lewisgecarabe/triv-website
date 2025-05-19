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
            <li><a href="../public/developers.php">DEVELOPERS</a></li>
            <li><a href="../public/contact.php">CONTACT US</a></li>
            <li><a href="../public/career.php">CAREERS</a></li>
            <li><a href="../public/projects.php">PROJECTS</a></li>
        </ul>
    </nav>
</header>

    <section class="job-details-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>JOB DETAILS</h1>
        </div>
    </section>

    <section class="job-details-content">
        <div class="container">
            <a href="career.php" class="back-link"><span>←</span> Back to All Jobs</a>
            
            <?php
            // In a real implementation, you would fetch job details from a database
            // For now, we'll use a simple switch statement based on the ID parameter
            $job_id = isset($_GET['id']) ? $_GET['id'] : 1;
            
            switch($job_id) {
                case 1:
                    $job_title = "Senior Architect";
                    $department = "Architecture";
                    $location = "Manila, Philippines (On-site)";
                    $description = "Lead architectural design projects from concept to completion, collaborating with clients and construction teams to deliver innovative, sustainable building solutions.";
                    $responsibilities = [
                        "Develop architectural designs and concepts for residential, commercial, and mixed-use projects",
                        "Prepare detailed drawings, specifications, and construction documents",
                        "Coordinate with engineers, contractors, and clients throughout the project lifecycle",
                        "Ensure compliance with building codes, regulations, and sustainability standards",
                        "Manage project timelines and budgets",
                        "Mentor junior architects and lead design teams"
                    ];
                    $qualifications = [
                        "Bachelor's or Master's degree in Architecture",
                        "Licensed architect with 5+ years of professional experience",
                        "Proficiency in AutoCAD, Revit, SketchUp, and other design software",
                        "Strong portfolio demonstrating design excellence and technical expertise",
                        "Excellent communication and leadership skills",
                        "Experience with sustainable design principles and practices"
                    ];
                    $schedule = "Monday to Friday, 9:00 AM - 6:00 PM";
                    $benefits = [
                        "Competitive salary package",
                        "Health insurance coverage",
                        "Professional development opportunities",
                        "Performance bonuses",
                        "Paid time off and holidays"
                    ];
                    break;
                    
                case 2:
                    $job_title = "Civil Engineer";
                    $department = "Engineering";
                    $location = "Manila, Philippines (On-site)";
                    $description = "Design and oversee construction projects ensuring structural integrity, safety compliance, and efficient execution while coordinating with architects and contractors.";
                    $responsibilities = [
                        "Develop detailed engineering designs and calculations for construction projects",
                        "Prepare technical specifications and construction documents",
                        "Conduct site inspections and quality control assessments",
                        "Coordinate with architects, contractors, and other stakeholders",
                        "Ensure compliance with building codes and safety regulations",
                        "Manage project timelines and technical resources"
                    ];
                    $qualifications = [
                        "Bachelor's degree in Civil Engineering",
                        "Licensed Civil Engineer with 3+ years of experience",
                        "Proficiency in AutoCAD, STAAD Pro, and other engineering software",
                        "Strong analytical and problem-solving skills",
                        "Experience with construction management and site supervision",
                        "Excellent communication and teamwork abilities"
                    ];
                    $schedule = "Monday to Friday, 8:00 AM - 5:00 PM";
                    $benefits = [
                        "Competitive salary package",
                        "Health insurance coverage",
                        "Professional development allowance",
                        "Performance bonuses",
                        "Paid time off and holidays"
                    ];
                    break;
                    
                case 3:
                    $job_title = "Interior Designer";
                    $department = "Interior Design";
                    $location = "Manila, Philippines (Hybrid)";
                    $description = "Create stunning, functional interior spaces that reflect clients' visions and needs, selecting materials, colors, and furnishings while managing project timelines and budgets.";
                    $responsibilities = [
                        "Develop interior design concepts and space planning solutions",
                        "Select appropriate materials, finishes, furniture, and accessories",
                        "Create mood boards, renderings, and presentation materials",
                        "Coordinate with architects, contractors, and vendors",
                        "Manage project budgets and timelines",
                        "Ensure client satisfaction throughout the design process"
                    ];
                    $qualifications = [
                        "Bachelor's degree in Interior Design or related field",
                        "3+ years of professional interior design experience",
                        "Proficiency in AutoCAD, SketchUp, and Adobe Creative Suite",
                        "Strong portfolio demonstrating design versatility and creativity",
                        "Knowledge of materials, finishes, and furniture sourcing",
                        "Excellent communication and client management skills"
                    ];
                    $schedule = "Monday to Friday, 9:00 AM - 6:00 PM (2 days remote option)";
                    $benefits = [
                        "Competitive salary package",
                        "Health insurance coverage",
                        "Flexible work arrangements",
                        "Professional development opportunities",
                        "Paid time off and holidays"
                    ];
                    break;
                    
                case 4:
                    $job_title = "Construction Project Manager";
                    $department = "Construction";
                    $location = "Manila, Philippines (On-site)";
                    $description = "Oversee construction projects from planning to completion, managing timelines, budgets, resources, and teams to ensure quality, safety, and client satisfaction.";
                    $responsibilities = [
                        "Plan, coordinate, and supervise construction projects from start to finish",
                        "Develop and manage project schedules, budgets, and resources",
                        "Coordinate with architects, engineers, contractors, and clients",
                        "Ensure compliance with safety standards and building regulations",
                        "Resolve issues and conflicts that arise during construction",
                        "Monitor and report on project progress and performance"
                    ];
                    $qualifications = [
                        "Bachelor's degree in Construction Management, Civil Engineering, or related field",
                        "5+ years of construction project management experience",
                        "Strong knowledge of construction methods, materials, and regulations",
                        "Proficiency in project management software and MS Office",
                        "Excellent leadership, communication, and problem-solving skills",
                        "PMP certification preferred"
                    ];
                    $schedule = "Monday to Saturday, 8:00 AM - 5:00 PM (site visits required)";
                    $benefits = [
                        "Competitive salary package",
                        "Health insurance coverage",
                        "Transportation allowance",
                        "Performance bonuses",
                        "Paid time off and holidays"
                    ];
                    break;
                    
                case 5:
                    $job_title = "Marketing Specialist";
                    $department = "Administration";
                    $location = "Manila, Philippines (Hybrid)";
                    $description = "Develop and implement marketing strategies to promote TRIV's services, manage social media presence, create compelling content, and build client relationships.";
                    $responsibilities = [
                        "Develop and execute marketing campaigns for architectural and construction services",
                        "Create engaging content for website, social media, and marketing materials",
                        "Manage company social media accounts and online presence",
                        "Coordinate with design team to produce visual marketing assets",
                        "Track and analyze marketing performance metrics",
                        "Represent the company at industry events and networking opportunities"
                    ];
                    $qualifications = [
                        "Bachelor's degree in Marketing, Communications, or related field",
                        "2+ years of marketing experience, preferably in architecture/construction",
                        "Strong writing and content creation skills",
                        "Proficiency in digital marketing tools and social media platforms",
                        "Knowledge of graphic design principles and Adobe Creative Suite",
                        "Excellent communication and interpersonal skills"
                    ];
                    $schedule = "Monday to Friday, 9:00 AM - 6:00 PM (3 days remote option)";
                    $benefits = [
                        "Competitive salary package",
                        "Health insurance coverage",
                        "Flexible work arrangements",
                        "Professional development opportunities",
                        "Paid time off and holidays"
                    ];
                    break;
                    
                default:
                    $job_title = "Position Not Found";
                    $department = "";
                    $location = "";
                    $description = "The job position you're looking for doesn't exist or has been removed.";
                    $responsibilities = [];
                    $qualifications = [];
                    $schedule = "";
                    $benefits = [];
            }
            ?>
            
            <div class="job-header">
                <h2><?php echo $job_title; ?></h2>
                <div class="job-meta">
                    <span class="department"><?php echo $department; ?></span>
                    <span class="location"><?php echo $location; ?></span>
                </div>
            </div>
            
            <div class="job-description">
                <p><?php echo $description; ?></p>
            </div>
            
            <div class="job-section">
                <h3>Duties and Responsibilities</h3>
                <ul>
                    <?php foreach($responsibilities as $responsibility): ?>
                        <li><?php echo $responsibility; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="job-section">
                <h3>Qualifications</h3>
                <ul>
                    <?php foreach($qualifications as $qualification): ?>
                        <li><?php echo $qualification; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="job-section">
                <h3>Work Schedule</h3>
                <p><?php echo $schedule; ?></p>
            </div>
            
            <div class="job-section">
                <h3>Compensation and Benefits</h3>
                <ul>
                    <?php foreach($benefits as $benefit): ?>
                        <li><?php echo $benefit; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="job-apply">
                <a href="apply.php?job=<?php echo urlencode($job_title); ?>" class="btn btn-primary">Apply for this Position</a>
            </div>
        </div>
    </section>

    <section class="company-contact-info">
        <div class="contact-info-container">
            <div class="contact-details">
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
                    <p>0919-670-9187</p> 
                </div>
                
                <div class="contact-item">
                    <div class="icon">
                        <img src="../assets/images/location.jpg" alt="Location">
                    </div>
                    <p>322 National Highway,<br>Masaya, Rosario Batangas</p>
                </div>
            </div>
            
            <div class="company-description">
                <h2>TRIV Design & Studio is a Filipino owned company specializing in design & construction services.</h2>
                <p>The company brings together a highly skilled technical staff to ensure that excellence in design services standards are achieved to the satisfaction of the clients and owners.</p>
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