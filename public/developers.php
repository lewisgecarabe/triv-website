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
    <!-- Make sure the button is OUTSIDE the nav element -->
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
        <img src="../assets/images/codings.jpg" alt="Code Background" class="hero-bg">
        <div class="hero-content">
            <h1>FOUNDERS</h1>
        </div>
    </section>

    <section class="founders-section">
        <div class="founders-container">
            <div class="founder-card">
                <div class="founder-image">
                    <img src="images/user-icon.png" alt="Engr. Noel R. Villanueva">
                </div>
                <h3>Engr. Noel R. Villanueva</h3>
                <p class="founder-title">Civil Engineer</p>
                <p class="founder-bio">
                    a dedicated Software Engineer and Front-End Developer with a strong focus on building responsive, user-centric web applications. He earned his Bachelor of Science in Information Technology from the University of Santo Tomas, where he developed a solid foundation in software development and design principles. Passionate about clean code and elegant design, Noel excels in turning ideas into functional and visually appealing interfaces. His core skill set includes HTML, CSS, JavaScript, and modern frameworks like React and Vue.js.
                </p>
            </div>

            <div class="founder-card">
                <div class="founder-image">
                    <img src="images/user-icon.png" alt="Arch. Maria Alyza L. Villanueva">
                </div>
                <h3>Arch. Maria Alyza L. Villanueva</h3>
                <p class="founder-title">Software Engineer / Front-end Developer</p>
                <p class="founder-bio">
                    a dedicated Software Engineer and Front-End Developer with a strong focus on building responsive, user-centric web applications. She earned her Bachelor of Science in Information Technology from the University of Santo Tomas, where she developed a solid foundation in software development and design principles. Passionate about clean code and elegant design, Maria excels in turning ideas into functional and visually appealing interfaces. Her core skill set includes HTML, CSS, JavaScript, and modern frameworks like React and Vue.js.
                </p>
            </div>

            <div class="founder-card">
                <div class="founder-image">
                    <img src="images/user-icon.png" alt="Engr. Jan L. Villanueva">
                </div>
                <h3>Engr. Jan L. Villanueva</h3>
                <p class="founder-title">Software Engineer / Front-end Developer</p>
                <p class="founder-bio">
                    a dedicated Software Engineer and Front-End Developer with a strong focus on building responsive, user-centric web applications. He earned his Bachelor of Science in Information Technology from the University of Santo Tomas, where he developed a solid foundation in software development and design principles. Passionate about clean code and elegant design, Jan excels in turning ideas into functional and visually appealing interfaces. His core skill set includes HTML, CSS, JavaScript, and modern frameworks like React and Vue.js.
                </p>
            </div>
        </div>
    </section>

    <section class="company-contact">
        <div class="contact-info">
            <div class="contact-item">
                <div class="icon">
                    <img src="../assets/images/email.png" alt="Email">
                </div>
                <p>nrvillanueva8@yahoo.com</p>
            </div>
            
            <div class="contact-item">
                <div class="icon">
                    <img src="../assets/images/phone.png" alt="Phone">
                </div>
                <p>0908-742-0857</p>
            </div>
            
            <div class="contact-item">
                <div class="icon">
                    <img src="../assets/images/location.jpg" alt="Location">
                </div>
                <p>322 National Highway,<br>Masaya, Rosario Batangas</p>
            </div>
        </div>
        
        <div class="company-description">
            <h2>TRIV Design & Studio is a Filipino owned company specializing in design & construction services.</h2>
            <p>The company brings together a highly skilled technical staff to ensure that excellence in design services standards are achieved to the satisfaction of the clients and owners.</p>
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
</body>
</html>
