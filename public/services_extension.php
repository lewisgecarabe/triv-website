<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extension Services | TRIV Design and Construction</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="service-detail-main">
        <!-- Banner Section -->
        <section class="service-banner extension-banner">
            <div class="service-banner-overlay"></div>
            <div class="service-banner-content">
                <h1>Extension Services</h1>
                <p>Expand your space seamlessly while preserving your original structure's charm</p>
            </div>
        </section>

        <!-- Description Section -->
        <section class="service-description">
    <div class="service-description-container">
        <h2>Practical Space Expansion</h2>
        <div class="service-description-content">
            <div class="service-description-text">
                <p>TRIV Design and Construction specializes in creating practical extensions that add valuable space to your existing property. Based in Manila, we can also work on projects in other areas of the Philippines upon negotiation. Our extension services offer a cost-effective way to gain additional room without the hassle and expense of relocating.</p>
                
                <p>We approach each extension project with careful consideration of your existing building, ensuring that the new addition complements the original structure. Our team handles all aspects of the extension process, from initial design to final construction.</p>
                
                <p>Whether you need extra space for your growing family, additional room for your business, or want to maximize your property's potential, our team can help. As a new firm in the Philippines, we're committed to delivering quality extensions that seamlessly integrate with your existing structure while meeting local building requirements.</p>
            </div>
            <div class="service-description-image">
                <img src="../assets/images/extension-detail.jpg" alt="Building extension project by TRIV">
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
                            <h3>Site Analysis & Feasibility</h3>
                            <p>We begin with a thorough assessment of your property to determine the optimal extension approach, considering structural, regulatory, and aesthetic factors.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">2</div>
                        <div class="process-step-content">
                            <h3>Design & Planning</h3>
                            <p>Our architects create extension designs that seamlessly integrate with your existing structure while fulfilling your space requirements and design preferences.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">3</div>
                        <div class="process-step-content">
                            <h3>Permits & Approvals</h3>
                            <p>We handle all necessary permits and regulatory approvals, ensuring your extension project complies with local building codes and zoning regulations.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">4</div>
                        <div class="process-step-content">
                            <h3>Construction</h3>
                            <p>Our construction team executes the extension with minimal disruption to your existing space, implementing careful measures to protect your property during the process.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="process-step-number">5</div>
                        <div class="process-step-content">
                            <h3>Integration & Finishing</h3>
                            <p>We ensure seamless integration between the new extension and existing structure, completing all finishing work to create a cohesive and harmonious result.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="service-gallery">
            <div class="service-gallery-container">
                <h2>Extension Projects</h2>
                <div class="gallery-slider">
                    <div class="gallery-track">
                        <div class="gallery-slide">
                            <img src="../assets/images/extension-project1.jpg" alt="TRIV Extension Project 1">
                        </div>
                        <div class="gallery-slide">
                            <img src="../assets/images/extension-project2.jpg" alt="TRIV Extension Project 2">
                        </div>
                        <div class="gallery-slide">
                            <img src="../assets/images/extension-project3.jpg" alt="TRIV Extension Project 3">
                        </div>
                        <div class="gallery-slide">
                            <img src="../assets/images/extension-project4.jpg" alt="TRIV Extension Project 4">
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
                <h2>Client Testimonials</h2>
                <div class="testimonials-slider">
                    <div class="testimonial">
                        <div class="testimonial-content">
                            <p>"TRIV designed and built a two-story extension for our home that blends perfectly with the original structure. The additional space has transformed how we live, and the transition between old and new is seamless."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="../assets/images/client9.jpg" alt="Client Portrait">
                            <div class="testimonial-info">
                                <h4>Ricardo and Ana Fernandez</h4>
                                <p>Homeowners</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial">
                        <div class="testimonial-content">
                            <p>"Our retail store needed additional space, and TRIV created an extension that doubled our floor area without disrupting our business operations. The result is a cohesive space that looks like it was always part of the original building."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="../assets/images/client10.jpg" alt="Client Portrait">
                            <div class="testimonial-info">
                                <h4>Olivia Chen</h4>
                                <p>Business Owner, Urban Boutique</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="service-cta-container">
                <h2>Ready to Expand Your Space?</h2>
                <p>Contact us today to discuss your extension project and schedule a site assessment.</p>
                <a href="contact.php" class="cta-button">Start Your Extension Project</a>
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
