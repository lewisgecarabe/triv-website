<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers | TRIV Design & Construction</title>
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
            <li><a href="../public/careers.php" class="active">CAREERS</a></li>
        </ul>
    </nav>
</header>

<section class="hero careers-hero">
    <div class="hero-overlay"></div>
    <img src="../assets/images/careers.jpg" alt="Careers Background" class="hero-bg">
    <div class="hero-content">
        <h1>CAREERS AT TRIV</h1>
        <p>Join our passionate team and help us design the future.</p>
    </div>
</section>

<section class="job-listings">
    <div class="section-title">
        <h2>Current Job Openings</h2>
        <p>Explore the opportunities below and apply today.</p>
    </div>

    <div class="jobs-container">
        <div class="job-card">
            <h3>Architectural Designer</h3>
            <p><strong>Location:</strong> Rosario, Batangas</p>
            <p><strong>Type:</strong> Full-time</p>
            <p><strong>Qualifications:</strong></p>
            <ul>
                <li>Licensed Architect</li>
                <li>Proficient in AutoCAD, SketchUp, and Revit</li>
                <li>Strong attention to detail and design principles</li>
            </ul>
        </div>

        <div class="job-card">
            <h3>Site Engineer</h3>
            <p><strong>Location:</strong> Rosario, Batangas</p>
            <p><strong>Type:</strong> Full-time</p>
            <p><strong>Qualifications:</strong></p>
            <ul>
                <li>Bachelor's degree in Civil Engineering</li>
                <li>Licensed and with at least 2 years site experience</li>
                <li>Knowledge in project planning and supervision</li>
            </ul>
        </div>

        <div class="job-card">
            <h3>Front-End Web Developer</h3>
            <p><strong>Location:</strong> Remote / Hybrid</p>
            <p><strong>Type:</strong> Contract</p>
            <p><strong>Qualifications:</strong></p>
            <ul>
                <li>Proficient in HTML, CSS, JavaScript</li>
                <li>Experience with React or Vue.js</li>
                <li>Portfolio of past web projects</li>
            </ul>
        </div>
    </div>
</section>

<section class="job-application">
    <div class="section-title">
        <h2>Apply Now</h2>
        <p>Fill out the form below and we'll get back to you shortly.</p>
    </div>

    <form action="submit_application.php" method="POST" enctype="multipart/form-data" class="application-form">
        <div class="form-group">
            <label for="fullname">Full Name*</label>
            <input type="text" id="fullname" name="fullname" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address*</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="position">Position Applying For*</label>
            <select id="position" name="position" required>
                <option value="">Select a position</option>
                <option value="Architectural Designer">Architectural Designer</option>
                <option value="Site Engineer">Site Engineer</option>
                <option value="Front-End Web Developer">Front-End Web Developer</option>
            </select>
        </div>

        <div class="form-group">
            <label for="resume">Upload Resume (PDF only)*</label>
            <input type="file" id="resume" name="resume" accept=".pdf" required>
        </div>

        <div class="form-group">
            <label for="message">Message (Optional)</label>
            <textarea id="message" name="message" rows="5"></textarea>
        </div>

        <button type="submit" class="apply-btn">Submit Application</button>
    </form>
</section>

<footer>
    <div class="footer-logo">
        <img src="../assets/images/triv-logo.png" alt="TRIV Design & Construction">
    </div>
    <div class="copyright">
        <?php echo '© Copyright ' . date('Y') . ' TRIV Design & Construction | All Rights Reserved | Built by: Lance Bericio, Lewis Guicante, Noel Villanueva'; ?>
    </div>
</footer>

</body>
</html>
