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
        <img src="../assets/images/trivfinalnatalaga.png" alt="TRIV Design & Construction">
    </div>
    <!-- Make sure the button is OUTSIDE the nav element -->
    <button class="menu-toggle" aria-label="Toggle menu">☰</button>
    <nav>
        <ul>
            <li><a href="../public/index.php">HOME</a></li>
            <li><a href="../public/services.php">SERVICES</a></li>
            <li><a href="../public/developers.php">ABOUT US</a></li>
            <li><a href="../public/contact.php">CONTACT US</a></li>
            <li><a href="../public/career.php">CAREERS</a></li>
            <li><a href="../public/register.php">PROJECTS</a></li>
            <hr>
             <li><a href="../public/projects.php">Log in / Sign Up </a></li>
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
            <h1>ABOUT US</h1>
            <h2>With our knowledge we guarantee success</h2>
            <p>Fusce id hendrerit lectus. Morbi vitae tortor sed turpis feugiat congue</p>
    </div>



            <div class="right-side">
                <p>Guided by Engr. Noel R. Villanueva, passionate individuals, fueled by talent, the  company  has grown stronger with each new challenge</p>
            <a href="../public/developers.php" class="btn-red">Learn more →</a>
            </div>

    </section>

    <hr class="horizon-rule">

    <section class="projects-homepage">
            <div class="header">
      <h2>FEATURED PROJECTS</h2>
      <a href="../public/projects.php" class="view-project">View Projects →</a>
    </div>

    <div class="projects">
        <?php
        $projects = [
            ["title" => "Quilib Rosario, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/FINAL P1 - Copy.jpg"],
             ["title" => "Masaya Rosario, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/3RD.jpg"],
              ["title" => "San Miguel Padre Garcia, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/a.jpg"],
              ["title" => "Romblon, Romblon", "type" => "RESIDENTIAL AND COMMERCIAL", "img" => "../assets/images/project5.JPG  "],
            

        ];

        foreach ($projects as $project) {
         echo '<div class="project-card">';
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



  <section class="soc-med">
    <div class="soc-med-content">
      <h1>FOLLOW US ON OUR SOCIAL MEDIA!</h1>
      <a href="https://web.facebook.com/profile.php?id=61572135853188" class="myfacebook" target="_blank">
        <div class="fbdatcom-wrapper">
          <img src="../assets/images/fbdatcom.webp" alt="Facebook" class="fbdatcom">
        </div>
        <span class="fb">Message us on Facebook!</span>
        <!-- Facebook icon using Unicode -->
        <span style="font-size: 20px;">&#xf39e;</span>
      </a>
      
      <div class="decorative-lines">
        <div class="line line-gold"></div>
        <div class="line line-white"></div>
        <div class="line line-gold"></div>
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