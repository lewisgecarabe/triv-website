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
            <h1>ABOUT US</h1>
            <h2>With our knowledge<br> we guarantee success</h2>
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
      <a href="public/projects.php" class="view-project">View Projects →</a>
    </div>

    <div class="projects">
        <?php
        $projects = [
            ["title" => "Quilib Rosario, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/FINAL P1 - Copy.jpg"],
             ["title" => "Masaya Rosario, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/3RD.jpg"],
              ["title" => "San Miguel Padre Garcia, Batangas", "type" => "RESIDENTIAL", "img" => "../assets/images/PERSP 1.JPG"],
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