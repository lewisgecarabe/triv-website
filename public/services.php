<?php
require_once '../classes/Database.php';

$db = new Database();
$conn = $db->connect();
$service = new Service($conn);

$services = $service->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | TRIV Design and Construction</title>
    <link rel="stylesheet" href="../assets/css/public-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>
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

    <section class="services-hero">
        <div class="hero-overlay"></div>
        <img src="../assets/images/services.jpg" alt="Construction Site" class="hero-bg">
        <div class="hero-content-services">
            <h1>SERVICES</h1>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="services-grid-container">
        <h2 class="services-section-title">Our Services</h2>
                    
        <div class="services-grid">
            <?php foreach ($services as $serv): ?>
            <div class="service-card" onclick="location.href='services_<?= $serv['slug'] ?>.php';">
                <div class="service-card-image">
                    <?php if ($serv['image']): ?>
                        <img src="../assets/images/<?= htmlspecialchars($serv['image']) ?>" alt="<?= htmlspecialchars($serv['title']) ?> Services">
                    <?php else: ?>
                        <img src="../assets/images/services_<?= $serv['slug'] ?>.jpg" alt="<?= htmlspecialchars($serv['title']) ?> Services">
                    <?php endif; ?>
                    <div class="service-overlay"></div>
                </div>
                <div class="service-card-content">
                    <h3><?= htmlspecialchars($serv['title']) ?></h3>
                    <p><?= htmlspecialchars($serv['short_description']) ?></p>
                    <a href="services_<?= $serv['slug'] ?>.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="service-cta-container">
                <h2>Ready to Expand Your Space?</h2>
                <p>Contact us today to discuss your extension project and schedule a site assessment.</p>
                <a href="../public/contact.php" class="cta-button">Start Your Extension Project</a>
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

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
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