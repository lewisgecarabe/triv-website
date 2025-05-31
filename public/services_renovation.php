<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renovation Services | TRIV Design and Construction</title>
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

    <main class="service-detail-main">
        <!-- Banner Section -->
        <section class="service-banner renovation-banner">
            <div class="service-banner-overlay"></div>
            <img src="../assets/images/services_renovation.jpg" alt="Renovation Banner" class="hero-bg">
            <div class="service-banner-content">
                <h1>Renovation</h1>
                <p>Breathe new life into old spaces with our modern renovation solutions.</p>
            </div>
        </section>

        <!-- Description Section -->
        <section class="service-description">
            <div class="service-description-container">
                <h2>Renovation Solutions</h2>
                <div class="service-description-content">
                    <div class="service-description-text">
                        <p>Breathe new life into old spaces with our modern renovation solutions. Transform your space with our thoughtful approach to renovations.</p>
                    </div>
                    <div class="service-description-image">
                        <img src="../assets/images/services_renovation.jpg" alt="Renovation project by TRIV">
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="service-process">
            <div class="service-process-container">
                <h2>Our Renovation Process</h2>
                <div class="process-steps">
                    <div class="process-step">
                        <div class="process-step-number">1</div>
                        <div class="process-step-content">
                            <h3>Assessment &amp; Consultation</h3>
                            <p>We begin with a thorough assessment of your existing space and an in-depth consultation to understand your renovation goals and requirements.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">2</div>
                        <div class="process-step-content">
                            <h3>Design &amp; Planning</h3>
                            <p>Our design team creates detailed renovation plans that address your needs while respecting the integrity of the original structure.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">3</div>
                        <div class="process-step-content">
                            <h3>Demolition &amp; Preparation</h3>
                            <p>We carefully remove outdated elements and prepare the space for renovation, ensuring proper disposal and recycling of materials.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">4</div>
                        <div class="process-step-content">
                            <h3>Renovation Execution</h3>
                            <p>Our skilled craftsmen implement the renovation plan with precision, addressing structural, mechanical, and aesthetic aspects of your project.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">5</div>
                        <div class="process-step-content">
                            <h3>Finishing &amp; Reveal</h3>
                            <p>We complete all finishing touches, conduct quality inspections, and reveal your beautifully renovated space, ready for immediate use.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="service-cta-container">
                <h2>Ready to Renovate?</h2>
                <p>Contact us today to discuss your renovation project and schedule a consultation.</p>
                <a href="../public/contact.php" class="cta-button">Start Your Renovation</a>
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