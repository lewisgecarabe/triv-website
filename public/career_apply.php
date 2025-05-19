<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply - TRIV Design & Construction</title>
    <link rel="stylesheet" href="../assets/css/public-style.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../assets/images/triv-logo.png" alt="TRIV Design & Construction">
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

    <section class="apply-hero">
        <div class="hero-overlay"></div>
        <img src="../assets/images/career_apply.jpg" alt="Construction Site" class="hero-bg">
        <div class="hero-content">
            <h1>JOIN OUR TEAM</h1>
        </div>
    </section>

    <section class="application-form">
        <div class="container">
            <a href="career.php" class="back-link"><span>←</span> Back to All Jobs</a>
            
            <?php
            // Get the job title from the URL parameter
            $job_title = isset($_GET['job']) ? urldecode($_GET['job']) : 'Position';
            ?>
            
            <div class="form-header">
                <h2>Apply for: <?php echo $job_title; ?></h2>
                <p>Please complete the form below to apply for this position. All fields marked with an asterisk (*) are required.</p>
            </div>
            
            <form action="#" method="post" enctype="multipart/form-data" id="job-application">
                <div class="form-section">
                    <h3>Personal Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address *</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Professional Information</h3>
                    
                    <div class="form-group">
                        <label for="resume">Resume/CV (PDF) *</label>
                        <input type="file" id="resume" name="resume" accept=".pdf" required>
                        <small>Maximum file size: 5MB</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="portfolio">Portfolio URL (if applicable)</label>
                        <input type="url" id="portfolio" name="portfolio" placeholder="https://your-portfolio-website.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="linkedin">LinkedIn Profile (if applicable)</label>
                        <input type="url" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/your-profile">
                    </div>
                    
                    <div class="form-group">
                        <label for="experience">Years of Experience *</label>
                        <select id="experience" name="experience" required>
                            <option value="">Select</option>
                            <option value="0-1">Less than 1 year</option>
                            <option value="1-3">1-3 years</option>
                            <option value="3-5">3-5 years</option>
                            <option value="5-10">5-10 years</option>
                            <option value="10+">10+ years</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Additional Information</h3>
                    
                    <div class="form-group">
                        <label for="cover_letter">Cover Letter / Why do you want to join TRIV? *</label>
                        <textarea id="cover_letter" name="cover_letter" rows="5" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date">Earliest Start Date *</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="salary">Expected Salary (PHP)</label>
                        <input type="text" id="salary" name="salary" placeholder="e.g., 50,000">
                    </div>
                    
                    <div class="form-group">
                        <label for="referral">How did you hear about us?</label>
                        <select id="referral" name="referral">
                            <option value="">Select</option>
                            <option value="website">Company Website</option>
                            <option value="jobsite">Job Board</option>
                            <option value="social">Social Media</option>
                            <option value="employee">Employee Referral</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group consent-checkbox">
                    <input type="checkbox" id="consent" name="consent" required>
                    <label for="consent">I consent to TRIV Design & Construction storing and processing my personal data for recruitment purposes. *</label>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                    <button type="reset" class="btn btn-outline">Clear Form</button>
                </div>
            </form>
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
        // Simple form validation
        document.getElementById('job-application').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, you would validate the form and submit it
            // For now, we'll just show an alert
            alert('Thank you for your application! We will review it and contact you soon.');
            
            // Optionally redirect back to careers page
            // window.location.href = 'career.php';
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