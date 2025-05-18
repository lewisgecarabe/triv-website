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
            <img src="../assets/images/triv-logo.png" alt="TRIV Design & Construction">
        </div>
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