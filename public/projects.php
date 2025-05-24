<?php include 'functions.php'; ?>
<?php
require_once '../classes/Database.php';

$db = new Database();
$conn = $db->connect();

$project = new Project($conn);

$constructionProjects = $project->getByCategory('construction');
$architecturalProjects = $project->getByCategory('architectural-design');
$renovationProjects = $project->getByCategory('renovation');
$interiorProjects = $project->getByCategory('interior-design');
?>

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


<section class="main-content-projects">
    <aside class="sidebar-projects">
        <ul class="sidebar-menu-projects">
            <li><a href="#" class="menu-item-projects active-projects" data-target="construction">Construction</a></li>
            <li><a href="#" class="menu-item-projects" data-target="architectural-design">Architectural Design</a></li>
            <li><a href="#" class="menu-item-projects" data-target="renovation">Renovation</a></li>
            <li><a href="#" class="menu-item-projects" data-target="interior-design">Interior Design</a></li>
        </ul>
    </aside>

    <div class="content-area-projects">
        <!-- Construction Section -->
        <div id="construction-section" class="content-section-projects">
            <h2 class="content-title-projects">Construction</h2>
            <p class="content-text-projects"></p>
            <p class="content-text-projects">Our construction services deliver exceptional quality and craftsmanship for both residential and commercial projects.</p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects">TRIV Design & Construction specializes in delivering high-quality construction services for a wide range of projects. From residential homes to commercial complexes, our team brings technical expertise and attention to detail to every project. We manage the entire construction process, ensuring timely delivery, cost efficiency, and superior craftsmanship.</p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects">Our construction approach combines innovative building techniques with traditional craftsmanship. We utilize the latest technologies and sustainable materials to create structures that are both beautiful and durable. Our team of experienced professionals works closely with clients to understand their needs and deliver results that exceed expectations.</p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects"></p>

            <div class="projects-grid">
<?php foreach ($constructionProjects as $proj): ?>
    <div class="project-card">
        <div class="project-image" style="background-image: url(../assets/images/<?= htmlspecialchars($proj['image']) ?>);"></div>
        <div class="project-details">
            <h3 class="project-name"><?= htmlspecialchars($proj['title']) ?></h3>
            <p class="project-position"><?= htmlspecialchars($proj['location']) ?></p>
            <p class="project-bio"><?= htmlspecialchars($proj['description']) ?></p>
        </div>
    </div>
<?php endforeach; ?>   
           
            </div>
        </div>

        <!-- Architectural Design Section -->
        <div id="architectural-design-section" class="content-section-projects hidden-projects">
            <h2 class="content-title-projects">Architectural Design</h2>
            <p class="content-text-projects">INNOVATIVE SPACES.</p>
            <p class="content-text-projects">Our architectural design services blend creativity with functionality to create spaces that inspire and endure.</p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects">Our design process is collaborative and iterative. We begin with a thorough understanding of our client's vision and requirements, followed by conceptual design, detailed development, and final documentation. Throughout this journey, we maintain open communication with our clients, ensuring their input is valued and incorporated.</p>
            
            <h3 class="content-subtitle-projects">PORTFOLIO</h3>
            <p class="content-text-projects">Our architectural portfolio showcases a diverse range of projects, each reflecting our commitment to innovative design and excellence in execution.</p>
            
            <div class="projects-grid">
<?php foreach ($architecturalProjects as $proj): ?>
    <div class="project-card">
        <div class="project-image" style="background-image: url(../assets/images/<?= htmlspecialchars($proj['image']) ?>);"></div>
        <div class="project-details">
            <h3 class="project-name"><?= htmlspecialchars($proj['title']) ?></h3>
            <p class="project-position"><?= htmlspecialchars($proj['location']) ?></p>
            <p class="project-bio"><?= htmlspecialchars($proj['description']) ?></p>
        </div>
    </div>
<?php endforeach; ?>
  </div>
        </div>

        <!-- Renovation Section -->
        <div id="renovation-section" class="content-section-projects hidden-projects">
            <h2 class="content-title-projects">Renovation</h2>
            <p class="content-text-projects">TRANSFORMING SPACES.</p>
            <p class="content-text-projects">Our renovation services breathe new life into existing structures, enhancing both form and function.</p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects">Our renovation approach begins with a thorough assessment of the existing structure, identifying both challenges and opportunities. We then develop a comprehensive plan that respects the original character of the building while incorporating modern improvements and design elements.</p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects">Our renovation services include structural upgrades, space reconfiguration, facade improvements, and systems modernization. We specialize in both residential and commercial renovations, with particular expertise in historic building restoration and adaptive reuse projects.</p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects"></p>
            
            <div class="projects-grid">
<?php foreach ($renovationProjects as $proj): ?>
    <div class="project-card">
        <div class="project-image" style="background-image: url(../assets/images/<?= htmlspecialchars($proj['image']) ?>);"></div>
        <div class="project-details">
            <h3 class="project-name"><?= htmlspecialchars($proj['title']) ?></h3>
            <p class="project-position"><?= htmlspecialchars($proj['location']) ?></p>
            <p class="project-bio"><?= htmlspecialchars($proj['description']) ?></p>
        </div>
    </div>
<?php endforeach; ?>


            </div>
        </div>

        <!-- Interior Design Section -->
        <div id="interior-design-section" class="content-section-projects hidden-projects">
            <h2 class="content-title-projects">Interior Design</h2>
            <p class="content-text-projects">CRAFTING EXPERIENCES.</p>
            <p class="content-text-projects">Our interior design services create beautiful, functional spaces that reflect your unique style and needs.</p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects"></p>
            
            <h3 class="content-subtitle-projects"></h3>
            <p class="content-text-projects">Our design process begins with understanding our clients' needs, preferences, and budget. We then develop concept designs, select materials and furnishings, and oversee implementation to ensure the final result aligns with the original vision. Throughout this process, we maintain close collaboration with our clients.</p>

            <h3 class="content-subtitle-projects">PORTFOLIO</h3>
            <p class="content-text-projects">Our interior design portfolio spans residential, commercial, hospitality, and retail projects, each showcasing our attention to detail and commitment to creating spaces that inspire.</p>
            
            <div class="projects-grid">
<?php foreach ($interiorProjects as $proj): ?>
    <div class="project-card">
        <div class="project-image" style="background-image: url(../assets/images/<?= htmlspecialchars($proj['image']) ?>);"></div>
        <div class="project-details">
            <h3 class="project-name"><?= htmlspecialchars($proj['title']) ?></h3>
            <p class="project-position"><?= htmlspecialchars($proj['location']) ?></p>
            <p class="project-bio"><?= htmlspecialchars($proj['description']) ?></p>
        </div>
    </div>
<?php endforeach; ?>

                
            
            </div>
        </div>
    </div>
</section>
     
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all menu items
    const menuItems = document.querySelectorAll('.menu-item-projects');
    
    // Add click event to each menu item
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all menu items
            menuItems.forEach(i => i.classList.remove('active-projects'));
            
            // Add active class to clicked menu item
            this.classList.add('active-projects');
            
            // Get the target section
            const target = this.getAttribute('data-target');
            
            // Hide all content sections
            document.querySelectorAll('.content-section-projects').forEach(section => {
                section.classList.add('hidden-projects');
            });
            
            // Show the target content section
            document.getElementById(target + '-section').classList.remove('hidden-projects');
        });
    });
});
</script>

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