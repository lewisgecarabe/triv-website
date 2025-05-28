<?php include 'functions.php'; ?>
<?php
require_once '../classes/Database.php';
require_once '../classes/Auth.php';

// Start session
Auth::startSession();

$db = new Database();
$conn = $db->connect();

$contactInquiry = new ContactInquiry($conn);
$message = '';
$messageType = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!Auth::isLoggedIn()) {
        // Redirect to login with return URL
        $currentUrl = urlencode($_SERVER['REQUEST_URI']);
        header("Location: login.php?redirect=" . $currentUrl . "&message=login_required");
        exit();
    }

    // Validate and process form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $messageText = trim($_POST['message'] ?? '');
    $userId = Auth::getUserId();

    $errors = [];

    // Validation
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($mobile)) $errors[] = "Mobile number is required";
    if (empty($messageText)) $errors[] = "Message is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";

    // Handle file upload
    $planFile = null;
    if (isset($_FILES['plan']) && $_FILES['plan']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/plans/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileExtension = strtolower(pathinfo($_FILES['plan']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'dwg', 'dxf'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $fileName = 'plan_' . $userId . '_' . time() . '.' . $fileExtension;
            $uploadPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['plan']['tmp_name'], $uploadPath)) {
                $planFile = $fileName;
            } else {
                $errors[] = "Failed to upload plan file";
            }
        } else {
            $errors[] = "Invalid file type. Allowed: PDF, JPG, PNG, DWG, DXF";
        }
    }

    if (empty($errors)) {
        if ($contactInquiry->create($userId, $name, $email, $mobile, $messageText, $planFile)) {
            $message = "Your inquiry has been submitted successfully! We'll get back to you soon.";
            $messageType = 'success';
            
            // Clear form data
            $name = $email = $mobile = $messageText = '';
        } else {
            $message = "Failed to submit inquiry. Please try again.";
            $messageType = 'error';
        }
    } else {
        $message = implode('<br>', $errors);
        $messageType = 'error';
    }
}

// Check for login required message
if (isset($_GET['message']) && $_GET['message'] === 'login_required') {
    $message = "Please log in to submit a contact inquiry.";
    $messageType = 'info';
}
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
            <?php if (Auth::isLoggedIn()): ?>
                <li><a href="../public/logout.php">LOGOUT</a></li>
                <?php if (Auth::isAdmin()): ?>
                    <li><a href="../admin/dashboard.php">ADMIN</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="../public/login.php">LOGIN</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

    <section class="contact-hero">
        <div class="hero-overlay"></div>
        <img src="../assets/images/construction-bg.jpg" alt="Construction Site" class="hero-bg">
        <div class="hero-content-contact">
            <h1>CONTACT US</h1>
        </div>
    </section>

   <section class="contact-main">
    <div class="contact-container">
        <div class="contact-form-section">
            <?php if (!empty($message)): ?>
                <div class="form-message <?= $messageType ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <?php if (Auth::isLoggedIn()): ?>
                <div class="user-info">
                    <strong>Logged in as:</strong> <?= htmlspecialchars(Auth::getUserName()) ?> (<?= htmlspecialchars(Auth::getUserEmail()) ?>)
                    <a href="../public/logout.php" class="logout-link" style="float: right;">Logout</a>
                </div>

                <form action="contact.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Name:" value="<?= htmlspecialchars($name ?? Auth::getUserName()) ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email:" value="<?= htmlspecialchars($email ?? Auth::getUserEmail()) ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="mobile" placeholder="Mobile:" value="<?= htmlspecialchars($mobile ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" rows="6" required><?= htmlspecialchars($messageText ?? '') ?></textarea>
                    </div>
                    <div class="form-group file-upload">
                        <label for="plan-upload" class="file-label">
                            <span>Drop Plan Here (Optional)</span>
                            <input type="file" id="plan-upload" name="plan" class="file-input" accept=".pdf,.jpg,.jpeg,.png,.dwg,.dxf">
                        </label>
                        <small>Accepted formats: PDF, JPG, PNG, DWG, DXF</small>
                    </div>
                    <button type="submit" class="submit-btn">Submit Inquiry</button>
                </form>
            <?php else: ?>
                <div class="login-prompt">
                    <h3>Login Required</h3>
                    <p>You need to be logged in to submit a contact inquiry.</p>
                    <p>
                        <a href="login.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>">Login</a> or 
                        <a href="register.php">Create an Account</a>
                    </p>
                </div>
                
                <!-- Show form but disabled -->
                <form style="opacity: 0.5; pointer-events: none;">
                    <div class="form-group">
                        <input type="text" placeholder="Name:" disabled>
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="Email:" disabled>
                    </div>
                    <div class="form-group">
                        <input type="tel" placeholder="Mobile:" disabled>
                    </div>
                    <div class="form-group">
                        <textarea placeholder="Your Message" rows="6" disabled></textarea>
                    </div>
                    <div class="form-group file-upload">
                        <label class="file-label">
                            <span>Drop Plan Here</span>
                            <input type="file" disabled>
                        </label>
                    </div>
                    <button type="button" class="submit-btn" disabled>Login Required</button>
                </form>
            <?php endif; ?>
        </div>
        
        <div class="contact-info-section">
            <h2>TRIV Design & Construction</h2>
            
            <div class="contact-detail">
                <div class="contact-icon">
                    <img src="../assets/images/location.jpg" alt="Location">
                </div>
                <p>322 National Highway, Masaya Rosario, Batangas</p>
            </div>
            
            <div class="contact-detail">
                <div class="contact-icon">
                    <img src="../assets/images/phone.png" alt="Phone">
                </div>
                <p>09087420857</p>
            </div>
        </div>
    </div>
</section>

    <section class="company-contact">
        <div class="company-description">
            <h2>TRIV Design & Studio is a Filipino owned company specializing in design & construction services.</h2>
            <p>The company brings together a highly skilled technical staff to ensure that excellence in design services standards are achieved to the satisfaction of the clients and owners.</p>
        </div>
        
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
         // File upload preview
        const fileInput = document.getElementById('plan-upload');
        const fileLabel = document.querySelector('.file-label span');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileLabel.textContent = this.files[0].name;
                } else {
                    fileLabel.textContent = 'Drop Plan Here (Optional)';
                }
            });
        }
    });
    </script>
</body>
</html>