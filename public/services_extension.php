
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extension Services | TRIV Design and Construction</title>
    <link rel="stylesheet" href="../assets/css/public-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>

<div class="return-services-container">
    <a href="../public/services.php" class="return-services-button">
        <i class="fas fa-arrow-left"></i> Return to Services
    </a>
</div>

    <div class="logo">
        <img src="../assets/images/trivfinalnatalaga.png" alt="TRIV Design & Construction">
    </div>
    <!-- Make sure the button is OUTSIDE the nav element -->
    <button class="menu-toggle" aria-label="Toggle menu">☰</button>
    <nav>
        <ul>
            <li><a href="../public/index.php">HOME</a></li>
            <li><a href="../public/developers.php">ABOUT US</a></li>
            <li><a href="../public/services.php">SERVICES</a></li>
            <li><a href="../public/projects.php">PROJECTS</a></li>
            <li><a href="../public/career.php">CAREERS</a></li>
            <li><a href="../public/contact.php">CONTACT US</a></li>
            <hr>
        </ul>
    </nav>
</header>
</header>

    <main class="service-detail-main">
        <!-- Banner Section -->
        <section class="service-banner extension-banner">
            <div class="service-banner-overlay"></div>
            <img src="../assets/images/services_extension.jpg" alt="Extension Banner" class="hero-bg">
            <div class="service-banner-content">
                <h1>Extension</h1>
                <p>Expand your space seamlessly while preserving your original structure&#039;s charm.</p>
            </div>
        </section>

        <!-- Description Section -->
        <section class="service-description">
            <div class="service-description-container">
                <h2>Extension Solutions</h2>
                <div class="service-description-content">
                    <div class="service-description-text">
                        <p>Expand your space seamlessly while preserving your original structure&#039;s charm. Our extension services offer a cost-effective way to gain additional room.</p>
                    </div>
                    <div class="service-description-image">
                        <img src="../assets/images/services_extension.jpg" alt="Extension project by TRIV">
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="service-process">
            <div class="service-process-container">
                <h2>Our Extension Process</h2>
                <div class="process-steps">
                    <div class="process-step">
                        <div class="process-step-number">1</div>
                        <div class="process-step-content">
                            <h3>Consultation</h3>
                            <p>We begin with understanding your needs and requirements.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">2</div>
                        <div class="process-step-content">
                            <h3>Planning</h3>
                            <p>We create detailed plans for your project.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">3</div>
                        <div class="process-step-content">
                            <h3>Execution</h3>
                            <p>We implement the project with precision and quality.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">4</div>
                        <div class="process-step-content">
                            <h3>Completion</h3>
                            <p>We deliver your completed project on time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="service-cta-container">
                <h2>Ready to Start Your Project?</h2>
                <p>Contact us today to discuss your project needs.</p>
                <a href="../public/contact.php" class="cta-button">Get Started</a>
            </div>
        </section>
    </main>

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