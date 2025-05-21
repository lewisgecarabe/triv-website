<?php include 'functions.php'; ?>
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
        <img src="../assets/images/trivfinalnatalaga.png" alt="TRIV Design & Construction">
    </div>
    <!-- Hamburger menu that shows nav on hover -->
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

    <section class="hero developers-hero">
        <div class="hero-overlay"></div>
        <img src="../assets/images/FINAL P1 - Copy.jpg" alt="Code Background" class="hero-bg">
        <div class="hero-content-project">
            <h1>PROJECTS</h1>
        </div>
    </section>


    <section class="projects-portfolio">
    <div class="projects-page">
        <?php
        $projects = [
            ["title" => "Quilib Rosario, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/FINAL P1 - Copy.jpg"],
             ["title" => "Masaya Rosario, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/3RD.jpg"],
              ["title" => "San Miguel Padre Garcia, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/VIEW0010EDITED.jpg"],
              ["title" => "Romblon, Romblon", "type" => "RESIDENTIAL AND COMMERCIAL", "img" => "../assets/images/project5.JPG  "],
        ];

        foreach ($projects as $project) {
         echo '<div class="project-card-page">';
          echo '  <img src="' . $project["img"] . '" alt="">';
          echo '  <div class="overlay">';
          echo '    <p>' . $project["type"] . '</p>';
          echo '    <h3>' . $project["title"] . '</h3>';
          echo '  </div>';
          echo '</div>';
        }
        ?>
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