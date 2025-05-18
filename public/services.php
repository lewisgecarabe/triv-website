<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | TRIV Design and Construction</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="services-main">
        <!-- Hero Section -->
        <section class="services-hero">
            <div class="services-hero-content">
                <h1>What We Do</h1>
                <p class="services-tagline">Building Beyond Limits</p>
                <p class="services-intro">At TRIV Design and Construction, we offer a range of building and design services to meet your needs in Manila and throughout the Philippines. While we're based in Manila, we're open to projects in other locations upon negotiation. As a new firm, we're committed to delivering quality work and building lasting relationships with our clients.</p>
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
                <a href="contact.php" class="cta-button">Get in Touch</a>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

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
</body>
</html>
