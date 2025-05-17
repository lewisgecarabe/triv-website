<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - TRIV Design & Construction</title>
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

    <section class="contact-hero">
        <div class="hero-overlay"></div>
        <img src="construction-bg.jpg" alt="Construction Site" class="hero-bg">
        <div class="hero-content">
            <h1>CONTACT US</h1>
        </div>
    </section>

    <section class="contact-main">
        <div class="contact-container">
            <div class="contact-form-section">
                <form action="contact.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Name:" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email:" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="mobile" placeholder="Mobile:" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
                    </div>
                    <div class="form-group file-upload">
                        <label for="plan-upload" class="file-label">
                            <span>Drop Plan Here</span>
                            <input type="file" id="plan-upload" name="plan" class="file-input">
                        </label>
                    </div>
                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
            
            <div class="contact-info-section">
                <h2>TRIV Design & Construction</h2>
                
                <div class="contact-detail">
                    <div class="contact-icon">
                        <img src="location.jpg" alt="Location">
                    </div>
                    <p>322 National Highway, Masaya Rosario, Batangas</p>
                </div>
                
                <div class="contact-detail">
                    <div class="contact-icon">
                        <img src="phone.png" alt="Phone">
                    </div>
                    <p>09087420857</p>
                </div>
            </div>
        </div>
    </section>

    <section class="company-contact-info">
        <div class="contact-info-container">
            <div class="contact-details">
                <div class="contact-item">
                    <div class="icon">
                        <img src="email.png" alt="Email">
                    </div>
                    <p>nrvillanueva8@yahoo.com</p>
                </div>
                
                <div class="contact-item">
                    <div class="icon">
                        <img src="phone.png" alt="Phone">
                    </div>
                    <p>0908-742-0857</p>
                </div>
                
                <div class="contact-item">
                    <div class="icon">
                        <img src="location.jpg" alt="Location">
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