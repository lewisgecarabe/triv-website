<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | TRIV Design and Construction</title>
    <link rel="stylesheet" href="../assets/css/public-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <li><a href="../public/developers.php">DEVELOPERS</a></li>
            <li><a href="../public/contact.php">CONTACT US</a></li>
            <li><a href="../public/career.php">CAREERS</a></li>
            <li><a href="../public/projects.php">PROJECTS</a></li>
        </ul>
    </nav>
</header>

    <section class="career-hero">
        <div class="hero-overlay"></div>
        <img src="../assets/images/services.jpg" alt="Construction Site" class="hero-bg">
        <div class="hero-content">
            <h1>SERVICES</h1>
        </div>
    </section>
       
        <!-- Services Grid -->
        <section class="services-grid-container">
            <h2 class="services-section-title">Our Services</h2>
            
            <div class="services-grid">
                <!-- Construction -->
                <div class="service-card" onclick="location.href='services_construction.php';">
                    <div class="service-card-image construction-img">
                        <div class="service-overlay"></div>
                    </div>
                    <div class="service-card-content">
                        <h3>Construction</h3>
                        <p>From foundation to finishing, we build durable structures that last for generations.</p>
                        <a href="services_construction.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Renovation -->
                <div class="service-card" onclick="location.href='services_renovation.php';">
                    <div class="service-card-image renovation-img">
                        <div class="service-overlay"></div>
                    </div>
                    <div class="service-card-content">
                        <h3>Renovation</h3>
                        <p>Breathe new life into old spaces with our modern renovation solutions.</p>
                        <a href="services_renovation.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Architectural Design -->
                <div class="service-card" onclick="location.href='services_architecturalDesign.php';">
                    <div class="service-card-image architectural-img">
                        <div class="service-overlay"></div>
                    </div>
                    <div class="service-card-content">
                        <h3>Architectural Design</h3>
                        <p>Innovative and sustainable designs crafted to inspire and function.</p>
                        <a href="services_architecturalDesign.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Interior Design -->
                <div class="service-card" onclick="location.href='services_interiorDesign.php';">
                    <div class="service-card-image interior-img">
                        <div class="service-overlay"></div>
                    </div>
                    <div class="service-card-content">
                        <h3>Interior Design</h3>
                        <p>Creating elegant interiors that reflect your personality and lifestyle.</p>
                        <a href="services_interiorDesign.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Extension -->
                <div class="service-card" onclick="location.href='services_extension.php';">
                    <div class="service-card-image extension-img">
                        <div class="service-overlay"></div>
                    </div>
                    <div class="service-card-content">
                        <h3>Extension</h3>
                        <p>Expand your space seamlessly while preserving your original structure's charm.</p>
                        <a href="services_extension.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="services-cta">
            <div class="services-cta-content">
                <h2>Ready to Start Your Project?</h2>
                <p>Contact us today for a free consultation and quote.</p>
                <a href="../public/contact.php" class="cta-button">Get in Touch</a>
            </div>
        </section>
    </main>

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
        // Add scroll animation for service cards
        document.addEventListener('DOMContentLoaded', function() {
            const serviceCards = document.querySelectorAll('.service-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                    }
                });
            }, { threshold: 0.1 });
            
            serviceCards.forEach(card => {
                observer.observe(card);
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
