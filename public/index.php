<?php include '../public/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIV Design & Construction</title>
    <link rel="stylesheet" href="../assets/css/public-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../assets/images/triv-logo.png" alt="TRIV Design & Construction">
        </div>
        <nav>
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="../public/services.php">SERVICES</a></li>
                <li><a href="../public/developers.php">DEVELOPERS</a></li>
                <li><a href="../public/contact.php">CONTACT US</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-overlay"></div>
        <img src="../assets/images/construction-bg.jpg" alt="Construction Site" class="hero-bg">
        <div class="hero-content">
            <h1>BUILDING DREAMS,<br>DESIGNING REALITIES</h1>
            <p>TRIV Design & Construction is a full-service firm dedicated to delivering top-quality architectural design, engineering, and construction solutions. Whether it's a dream home or a large-scale development, we approach every project with professionalism, creativity, and integrity.</p>
            <a href="../public/projects.php" class="btn">Know more</a>
        </div>
    </section>

    <section class="about">
        <div class="about-content">
            <div class="subtitle">ABOUT US</div>
            <h2>With our knowledge we guarente success</h2>
            <p>Fusce id hendrerit lectus. Morbi vitae tortor sed turpis feugiat congue</p>
            <p>Cras tincidunt tellus at mi tristique rhoncus. Etiam dapibus rutrum leo consectetur accumsan. Vivamus viverra ante turpis, dignissim condimentum elit egestas sit amet. Phasellus faucibus pellentesque</p>
            <a href="../public/developers.php" class="btn-red">Learn more →</a>
        </div>
        <div class="about-image">
            <img src="../assets/images/building-construction.jpg" alt="Construction site" class="main-image">
            <div class="video-overlay">
                <img src="../assets/images/notebook.jpg" alt="Construction plans" class="overlay-image">
                <div class="video-btn">▶</div>
            </div>
        </div>
    </section>

    <section class="company-info">
        <div class="sidebar">
            <h3>The Firm</h3>
            <ul>
                <li>People</li>
                <li>Inquiries</li>
                <li>Account</li>
            </ul>
        </div>
        <div class="main-content">
            <h2>TRIV Design & Construction</h2>
            <p class="founded">SINCE 2025.</p>
            
            <p>Guided by Engr. Noel R. Villanueva, passionate individuals, fueled by talent, the company has grown stronger with each new challenge</p>
            
            <div class="info-section">
                <h3>HISTORY</h3>
                <p>TRIV Design & Construction is a full service firm specializing in architecture, interior design, and construction management. We are committed to delivering solutions that perfectly balance aesthetics, function, and budget. Through expert craftsmanship and client collaboration, we ensure every project meets the highest standards. Our team combines creative design with technical expertise to deliver projects on time and within budget. At TRIV, we build not just structures – but lasting value and meaningful experiences.</p>
            </div>
            
            <div class="info-section">
                <h3>MISSION</h3>
                <p>To provide exceptional architectural and construction services that fuse innovative design, functionality, and sustainability. We are committed to exceeding client expectations through collaborative processes, high-quality workmanship, and ethical practices.</p>
            </div>
            
            <div class="info-section">
                <h3>VISION</h3>
                <p>To be a leading force in the design and construction industry, recognized for shaping spaces that inspire, endure, and elevate the way people live and work.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-logo">
            <img src="../assets/images/triv-logo.png" alt="TRIV Design & Construction">
        </div>
        <div class="copyright">
            <?php echo '© Copyright ' . date('Y') . ' TRIV Design & Construction | All Rights Reserved | Built by: Lewis Berrios, Lewis Guzman, Noel Villanueva'; ?>
        </div>
    </footer>

    <?php displayContactFormResults(); ?>
</body>
</html>