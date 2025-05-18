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
                 <li><a href="../public/index.php">HOME</a></li>
                <li><a href="../public/services.php">SERVICES</a></li>
                <li><a href="../public/developers.php">DEVELOPERS</a></li>
                <li><a href="../public/contact.php">CONTACT US</a></li>
                 <li><a href="../public/career.php">CAREERS</a></li>
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
           
            <div class="right-side">
            <a href="../public/developers.php" class="btn-red">Learn more →</a>
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