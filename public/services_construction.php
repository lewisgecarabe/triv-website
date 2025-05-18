<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Construction Services | TRIV Design and Construction</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="service-detail-main">
        <!-- Banner Section -->
        <section class="service-banner construction-banner">
            <div class="service-banner-overlay"></div>
            <div class="service-banner-content">
                <h1>Construction Services</h1>
                <p>Building dreams into reality with precision and excellence</p>
            </div>
        </section>

        <!-- Description Section -->
        <section class="service-description">
            <div class="service-description-container">
                <h2>Expert Construction Solutions</h2>
                <div class="service-description-content">
                    <div class="service-description-text">
                        <p>At TRIV Design and Construction, we offer quality construction services for residential and commercial projects in Manila and beyond. While we're based in Manila, we're willing to take on projects in other locations throughout the Philippines upon negotiation. Our team combines technical knowledge with practical skills to ensure your building project is completed to the highest standards.</p>
                        
                        <p>We use quality materials sourced from trusted local suppliers and follow proper construction techniques to create buildings that are built to last. Whether you're planning a home renovation or a small commercial space, we bring the same dedication to every project.</p>
                        
                        <p>Safety and quality are our priorities. We follow building codes and regulations while working efficiently to deliver your project on time and within budget. As a new firm in Manila, we're committed to building our reputation through excellent workmanship and customer satisfaction.</p>
                    </div>
                    <div class="service-description-image">
                        <img src="images/construction-detail.jpg" alt="Construction workers at a TRIV project site">
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="service-process">
            <div class="service-process-container">
                <h2>Our Construction Process</h2>
                <div class="process-steps">
                    <div class="process-step">
                        <div class="process-step-number">1</div>
                        <div class="process-step-content">
                            <h3>Planning & Design</h3>
                            <p>We begin with thorough planning and design, working closely with architects and engineers to create detailed blueprints and construction schedules.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">2</div>
                        <div class="process-step-content">
                            <h3>Permits & Approvals</h3>
                            <p>Our team handles all necessary permits and regulatory approvals, ensuring your project complies with local building codes and regulations.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">3</div>
                        <div class="process-step-content">
                            <h3>Site Preparation</h3>
                            <p>We prepare the construction site with proper excavation, foundation work, and utility installations to create a solid base for your structure.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">4</div>
                        <div class="process-step-content">
                            <h3>Construction</h3>
                            <p>Our skilled construction team executes the building process with precision, following the approved plans while maintaining quality and safety standards.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">5</div>
                        <div class="process-step-content">
                            <h3>Finishing & Handover</h3>
                            <p>We complete all finishing touches, conduct thorough quality inspections, and hand over your completed project with full documentation and support.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="service-gallery">
            <div class="service-gallery-container">
                <h2>Our Construction Projects</h2>
                <div class="gallery-slider">
                    <div class="gallery-track">
                        <div class="gallery-slide">
                            <img src="images/construction-project1.jpg" alt="TRIV Construction Project 1">
                        </div>
                        <div class="gallery-slide">
                            <img src="images/construction-project2.jpg" alt="TRIV Construction Project 2">
                        </div>
                        <div class="gallery-slide">
                            <img src="images/construction-project3.jpg" alt="TRIV Construction Project 3">
                        </div>
                        <div class="gallery-slide">
                            <img src="images/construction-project4.jpg" alt="TRIV Construction Project 4">
                        </div>
                    </div>
                    <button class="gallery-prev"><i class="fas fa-chevron-left"></i></button>
                    <button class="gallery-next"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="service-testimonials">
            <div class="service-testimonials-container">
                <h2>What Our Clients Say</h2>
                <div class="testimonials-slider">
                    <div class="testimonial">
                        <div class="testimonial-content">
                            <p>"TRIV Construction delivered our office building on time and within budget. Their attention to detail and quality workmanship exceeded our expectations."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="images/client1.jpg" alt="Client Portrait">
                            <div class="testimonial-info">
                                <h4>Maria Santos</h4>
                                <p>CEO, Innovate Solutions</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial">
                        <div class="testimonial-content">
                            <p>"The construction team at TRIV was professional, skilled, and responsive throughout our project. The final result is a beautiful and sturdy structure that will serve us for years to come."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="images/client2.jpg" alt="Client Portrait">
                            <div class="testimonial-info">
                                <h4>Antonio Reyes</h4>
                                <p>Property Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="service-cta-container">
                <h2>Ready to Build Your Dream Project?</h2>
                <p>Contact us today to discuss your construction needs and get a detailed quote.</p>
                <a href="contact.php" class="cta-button">Request a Quote</a>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

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
</body>
</html>
