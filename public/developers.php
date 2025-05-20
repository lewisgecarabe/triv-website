<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIV Design & Construction</title>
    <link rel="stylesheet" href="../assets/css/public-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
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

    <section class="hero developers-hero">
        <div class="hero-overlay"></div>
        <img src="../assets/images/codings.jpg" alt="Code Background" class="hero-bg">
        <div class="hero-content">
            <h1>ABOUT US</h1>
        </div>
    </section>

<section class="main-content">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#" class="menu-item active" data-target="firm">The Firm</a></li>
                <li><a href="#" class="menu-item" data-target="people">People</a></li>
                <li><a href="#" class="menu-item" data-target="inquiries">Inquiries</a></li>
                <li><a href="#" class="menu-item" data-target="account">Account</a></li>
            </ul>
        </aside>

        <div class="content-area">
            <!-- The Firm Section -->
            <div id="firm-section" class="content-section">
                <h2 class="content-title">TRIV Design & Construction</h2>
                <p class="content-text">SINCE 2025.</p>
                <p class="content-text">Guided by Engr. Noel R. Villanueva, passionate individuals, fueled by talent, the company has grown stronger with each new challenge.</p>
                
                <h3 class="content-subtitle">HISTORY</h3>
                <p class="content-text">TRIV Design & Construction is a full-service firm specializing in architecture, interior design, and construction management. We are committed to transforming ideas into functional and visually compelling spaces. With a focus on quality craftsmanship and client collaboration, we ensure every project meets the highest standards. Our team combines creative design with technical expertise to deliver projects on time and within budget. At TRIV, we build not just structures—but lasting value and meaningful experiences.</p>
                
                <h3 class="content-subtitle">MISSION</h3>
                <p class="content-text">To provide exceptional architectural and construction services that fuse innovative design, functionality, and sustainability. We are committed to exceeding client expectations through collaborative processes, high-quality workmanship, and ethical practices.</p>
                
                <h3 class="content-subtitle">VISION</h3>
                <p class="content-text">To be a leading force in the design and construction industry, recognized for shaping spaces that inspire, endure, and elevate the way people live and work.</p>
            </div>

            <!-- People Section -->
            <div id="people-section" class="content-section people-section">
                <h2 class="content-title">Our Team</h2>
                <p class="content-text">Meet the talented individuals who make TRIV Design & Construction a leader in the industry.</p>
                
                <div class="people-grid">
                    <div class="person-card">
                        <div class="person-image" style="background-image: url('/placeholder.svg?height=250&width=250');"></div>
                        <div class="person-details">
                            <h3 class="person-name">Engr. Noel R. Villanueva</h3>
                            <p class="person-position">Founder & CEO</p>
                            <p class="person-bio">With over 20 years of experience in construction and design, Noel founded TRIV with a vision to create spaces that transform lives.</p>
                        </div>
                    </div>
                    
                    <div class="person-card">
                        <div class="person-image" style="background-image: url('/placeholder.svg?height=250&width=250');"></div>
                        <div class="person-details">
                            <h3 class="person-name">Arch. Maria Santos</h3>
                            <p class="person-position">Principal Architect</p>
                            <p class="person-bio">Maria brings innovative design solutions and a keen eye for detail to every project, specializing in sustainable architecture.</p>
                        </div>
                    </div>
                    
                    <div class="person-card">
                        <div class="person-image" style="background-image: url('/placeholder.svg?height=250&width=250');"></div>
                        <div class="person-details">
                            <h3 class="person-name">Engr. James Rodriguez</h3>
                            <p class="person-position">Construction Manager</p>
                            <p class="person-bio">James ensures that every project is executed with precision, quality, and efficiency, maintaining the highest standards.</p>
                        </div>
                    </div>
                    
                    <div class="person-card">
                        <div class="person-image" style="background-image: url('/placeholder.svg?height=250&width=250');"></div>
                        <div class="person-details">
                            <h3 class="person-name">Diana Lee</h3>
                            <p class="person-position">Interior Designer</p>
                            <p class="person-bio">Diana creates functional and aesthetically pleasing interior spaces that reflect each client's unique vision and lifestyle.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inquiries Section -->
            <div id="inquiries-section" class="content-section people-section">
                <h2 class="content-title">Inquiries</h2>
                <p class="content-text">Interested in working with us? Fill out the form below and we'll get back to you as soon as possible.</p>
                
                <form action="process_inquiry.php" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label for="name" style="display: block; margin-bottom: 5px; font-weight: 500;">Name</label>
                            <input type="text" id="name" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div>
                            <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
                            <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="subject" style="display: block; margin-bottom: 5px; font-weight: 500;">Subject</label>
                        <input type="text" id="subject" name="subject" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="message" style="display: block; margin-bottom: 5px; font-weight: 500;">Message</label>
                        <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                    </div>
                    
                    <button type="submit" class="btn" style="border: none; cursor: pointer;">Submit Inquiry</button>
                </form>
            </div>

            <!-- Account Section -->
            <div id="account-section" class="content-section people-section">
                <h2 class="content-title">Account</h2>
                <p class="content-text">Access your client portal to view project updates, documents, and communicate with our team.</p>
                
                <form action="login.php" method="POST" style="max-width: 400px; margin-top: 30px;">
                    <div style="margin-bottom: 20px;">
                        <label for="username" style="display: block; margin-bottom: 5px; font-weight: 500;">Username</label>
                        <input type="text" id="username" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="password" style="display: block; margin-bottom: 5px; font-weight: 500;">Password</label>
                        <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    
                    <button type="submit" class="btn" style="border: none; cursor: pointer;">Login</button>
                    
                    <p style="margin-top: 20px; font-size: 0.9rem;">
                        <a href="#" style="color: #1a2b49; text-decoration: none;">Forgot password?</a> | 
                        <a href="#" style="color: #1a2b49; text-decoration: none;">Request an account</a>
                    </p>
                </form>
            </div>
        </div>
    </section>

    <section class="company-contact">
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
        
        <div class="company-description">
            <h2>TRIV Design & Studio is a Filipino owned company specializing in design & construction services.</h2>
            <p>The company brings together a highly skilled technical staff to ensure that excellence in design services standards are achieved to the satisfaction of the clients and owners.</p>
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

     <?php
    // This would be in process_inquiry.php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        // Process the form data (e.g., send email, store in database)
        // This is just a placeholder
        // mail("contact@trivdesign.com", "New Inquiry: $subject", $message, "From: $email");
        
        // Redirect back with success message
        // header("Location: index.php?inquiry=success");
    }
    
    // This would be in login.php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Authenticate user (connect to database, check credentials)
        // This is just a placeholder
        
        // If successful, start session and redirect to dashboard
        // session_start();
        // $_SESSION['user'] = $username;
        // header("Location: dashboard.php");
    }
    ?>

    <script>
        // JavaScript to handle the sidebar menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.menu-item');
            const sections = document.querySelectorAll('.content-section');
            
            // Show only the active section
            function showSection(targetId) {
                sections.forEach(section => {
                    if (section.id === targetId + '-section') {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }
            
            // Set active menu item
            function setActiveMenuItem(item) {
                menuItems.forEach(menuItem => {
                    menuItem.classList.remove('active');
                });
                item.classList.add('active');
            }
            
            // Add click event to menu items
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-target');
                    showSection(target);
                    setActiveMenuItem(this);
                });
            });
            
            // Initialize with the first section visible
            showSection('firm');
        });
    </script>
</body>
</html>
