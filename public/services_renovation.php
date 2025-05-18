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

    <main class="service-detail-main">
        <!-- Banner Section -->
        <section class="service-banner renovation-banner">
            <div class="service-banner-overlay"></div>
            <div class="service-banner-content">
                <h1>Renovation Services</h1>
                <p>Breathe new life into old spaces with our modern renovation solutions</p>
            </div>
        </section>

        <!-- Description Section -->
        <section class="service-description">
            <div class="service-description-container">
                <h2>Transform Your Space</h2>
                <div class="service-description-content">
                    <div class="service-description-text">
                        <p>TRIV Design and Construction offers practical renovation services to refresh and improve existing structures in Manila and other locations throughout the Philippines. Based in Manila, we're willing to travel for projects upon negotiation. Whether you need to update your home, optimize your office space, or revitalize a commercial property, our renovation team is ready to help.</p>
                        
                        <p>We take a thoughtful approach to renovations, balancing your vision with practical solutions. We carefully assess your space, discuss your needs and budget, and develop renovation plans that make the most of what you already have.</p>
                        
                        <p>As a new firm in the Philippines, we're eager to showcase our skills through renovation projects that make a real difference to our clients. We work efficiently to minimize disruption and focus on delivering quality results that improve both the appearance and functionality of your space.</p>
                    </div>
                    <div class="service-description-image">
                        <img src="../assets/images/renovation-detail.jpg" alt="Before and after of a TRIV renovation project">
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
                            <h3>Assessment & Consultation</h3>
                            <p>We begin with a thorough assessment of your existing space and an in-depth consultation to understand your renovation goals and requirements.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">2</div>
                        <div class="process-step-content">
                            <h3>Design & Planning</h3>
                            <p>Our design team creates detailed renovation plans that address your needs while respecting the integrity of the original structure.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">3</div>
                        <div class="process-step-content">
                            <h3>Demolition & Preparation</h3>
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
                            <h3>Finishing & Reveal</h3>
                            <p>We complete all finishing touches, conduct quality inspections, and reveal your beautifully renovated space, ready for immediate use.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="service-gallery">
            <div class="service-gallery-container">
                <h2>Renovation Transformations</h2>
                <div class="gallery-slider">
                    <div class="gallery-track">
                        <div class="gallery-slide">
                            <img src="../assets/images/renovation-project1.jpg" alt="TRIV Renovation Project 1">
                        </div>
                        <div class="gallery-slide">
                            <img src="../assets/images/renovation-project2.jpg" alt="TRIV Renovation Project 2">
                        </div>
                        <div class="gallery-slide">
                            <img src="../assets/images/renovation-project3.jpg" alt="TRIV Renovation Project 3">
                        </div>
                        <div class="gallery-slide">
                            <img src="../assets/images/renovation-project4.jpg" alt="TRIV Renovation Project 4">
                        </div>
                    </div>
                    <button class="gallery-prev"><i class="fas fa-chevron-left"></i></button>
                    <button class="gallery-next"><i class="fas fa-chevron-right"></i></button>
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
        // Gallery Slider Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.querySelector('.gallery-track');
            const slides = document.querySelectorAll('.gallery-slide');
            const nextButton = document.querySelector('.gallery-next');
            const prevButton = document.querySelector('.gallery-prev');
            
            let currentIndex = 0;
            const slideWidth = slides[0].getBoundingClientRect().width;
            
            // Set initial position
            track.style.transform = `translateX(0px)`;
            
            // Next button click
            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            });
            
            // Previous button click
            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            });
            
            // Auto slide every 5 seconds
            setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            }, 5000);
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
