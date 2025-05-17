<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - TRIV Design & Construction</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="triv-logo.png" alt="TRIV Design & Construction">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="services.php">SERVICES</a></li>
                <li><a href="developers.php">DEVELOPERS</a></li>
                <li><a href="contact.php">CONTACT US</a></li>
            </ul>
        </nav>
    </header>

    <section class="services-hero">
        <div class="hero-overlay"></div>
        <img src="construction-bg.jpg" alt="Construction Site" class="hero-bg">
        <div class="services-content">
            <div class="services-info">
                <h1>TRIV Construction Services</h1>
                <div class="services-image">
                    <img src="codings.jpg" alt="Construction Workers">
                </div>
                <p class="services-description">
                    With years of experience in the construction industry, RMJE Construction Services Corporation has gained the expertise and technical knowledge needed to deliver exceptional quality across all the services we offer.
                </p>
                <p class="services-description">
                    We provide a wide range of construction services in the Philippines, including architectural, project planning, estimating, scheduling, design, project management, and full project execution. From initial planning to the final turnover of your new home or building, we are committed to managing every stage of the construction process with professionalism and care.
                </p>
            </div>
            
            <div class="contact-form-container">
                <div class="contact-form">
                    <h3>Let's discuss what you've got planned</h3>
                    <p>Tell us about your construction project, your goals & how we can help! We're here to make it happen.</p>
                    <form action="services.php" method="post">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Phone" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="service-cards">
        <div class="cards-container">
            <?php
            // Array of service cards to avoid repetition
            $serviceCards = [
                ['title' => 'Project Management', 'image' => 'project-management.jpg'],
                ['title' => 'Project Management', 'image' => 'project-management.jpg'],
                ['title' => 'Project Management', 'image' => 'project-management.jpg'],
                ['title' => 'Project Management', 'image' => 'project-management.jpg'],
                ['title' => 'Project Management', 'image' => 'project-management.jpg'],
                ['title' => 'Project Management', 'image' => 'project-management.jpg']
            ];
            
            foreach ($serviceCards as $card) {
                echo '<div class="service-card">';
                echo '<div class="card-image">';
                echo '<img src="images/' . $card['image'] . '" alt="' . $card['title'] . '">';
                echo '</div>';
                echo '<div class="card-content">';
                echo '<h3>' . $card['title'] . '</h3>';
                echo '<p>From start to finish, our construction management group oversees the planning, construction, and delivery results in a project that meets your budget, deadline and quality standards. We provide pre-planning, design, and project management services with a dedicated team that delivers the best possible results.</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-overlay"></div>
        <img src="images/construction-equipment.jpg" alt="Construction Equipment" class="cta-bg">
        <div class="cta-content">
            <h2>Ensure your project's success with TRIV Design & Construction — your reliable partner in design and construction project management.</h2>
            <p>Ready to build your project? Let's talk about your plans.</p>
            <a href="contact.php" class="cta-button">REQUEST AN APPOINTMENT NOW</a>
        </div>
    </section>

    <footer>
        <div class="footer-logo">
            <img src="images/triv-logo.png" alt="TRIV Design & Construction">
        </div>
        <div class="copyright">
            <?php echo '© Copyright ' . date('Y') . ' TRIV Design & Construction | All Rights Reserved | Built by: Lance Bericio, Lewis Guicante, Noel Villanueva'; ?>
        </div>
    </footer>

    <?php 
    // Process the contact form if submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $result = processContactForm();
        if ($result) {
            echo '<div class="form-message ' . ($result['success'] ? 'success' : 'error') . '">';
            if ($result['success']) {
                echo $result['message'];
            } else {
                echo '<ul>';
                foreach ($result['errors'] as $error) {
                    echo '<li>' . $error . '</li>';
                }
                echo '</ul>';
            }
            echo '</div>';
        }
    }
    ?>
</body>
</html>
