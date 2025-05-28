<?php
class Database {
    private $host = "localhost";
    private $db_name = "triv_db";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db_name",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}

class Project {
    private $conn;
    private $table = 'projects';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all projects
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all projects for a given category
    public function getByCategory($category) {
        $sql = "SELECT * FROM " . $this->table . " WHERE category = :category ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// Get single project by ID
    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
// Create new project
    public function create($title, $description, $location, $category, $image = null) {
        $sql = "INSERT INTO " . $this->table . " (title, description, location, category, image, created_at) 
                VALUES (:title, :description, :location, :category, :image, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':image', $image);
        
        return $stmt->execute();
    }
// Update project
    public function update($id, $title, $description, $location, $category, $image = null) {
        if ($image) {
            $sql = "UPDATE " . $this->table . " 
                    SET title = :title, description = :description, location = :location, 
                        category = :category, image = :image, updated_at = NOW() 
                    WHERE id = :id";
        } else {
            $sql = "UPDATE " . $this->table . " 
                    SET title = :title, description = :description, location = :location, 
                        category = :category, updated_at = NOW() 
                    WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':category', $category);
        
        if ($image) {
            $stmt->bindParam(':image', $image);
        }
        
        return $stmt->execute();
    }

    // Delete project
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Get project count
    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}

class Service {
    private $conn;
    private $table = 'services';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all services
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY display_order ASC, created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single service by ID
    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get service by slug
    public function getBySlug($slug) {
        $sql = "SELECT * FROM " . $this->table . " WHERE slug = :slug AND status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new service
    public function create($title, $description, $short_description, $slug, $image = null, $banner_image = null, $display_order = 0, $status = 'active') {
        $sql = "INSERT INTO " . $this->table . " (title, description, short_description, slug, image, banner_image, display_order, status, created_at) 
                VALUES (:title, :description, :short_description, :slug, :image, :banner_image, :display_order, :status, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':short_description', $short_description);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':banner_image', $banner_image);
        $stmt->bindParam(':display_order', $display_order);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()) {
            // Generate the PHP page file
            $this->generateServicePage($title, $description, $short_description, $slug, $image, $banner_image);
            return true;
        }
        return false;
    }

    // Update service
    public function update($id, $title, $description, $short_description, $slug, $image = null, $banner_image = null, $display_order = 0, $status = 'active') {
        // Get old service data for file management
        $oldService = $this->getById($id);
        
        $sql = "UPDATE " . $this->table . " 
                SET title = :title, description = :description, short_description = :short_description, 
                    slug = :slug, display_order = :display_order, status = :status, updated_at = NOW()";
        
        if ($image) {
            $sql .= ", image = :image";
        }
        if ($banner_image) {
            $sql .= ", banner_image = :banner_image";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':short_description', $short_description);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':display_order', $display_order);
        $stmt->bindParam(':status', $status);
        
        if ($image) {
            $stmt->bindParam(':image', $image);
        }
        if ($banner_image) {
            $stmt->bindParam(':banner_image', $banner_image);
        }
        
        if ($stmt->execute()) {
            // Delete old page file if slug changed
            if ($oldService && $oldService['slug'] !== $slug) {
                $this->deleteServicePage($oldService['slug']);
            }
            
            // Generate updated page file
            $finalImage = $image ? $image : $oldService['image'];
            $finalBannerImage = $banner_image ? $banner_image : $oldService['banner_image'];
            $this->generateServicePage($title, $description, $short_description, $slug, $finalImage, $finalBannerImage);
            return true;
        }
        return false;
    }

    // Delete service
    public function delete($id) {
        // Get service data before deletion
        $serviceData = $this->getById($id);
        
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            // Delete the associated page file
            if ($serviceData) {
                $this->deleteServicePage($serviceData['slug']);
            }
            return true;
        }
        return false;
    }

    // Get service count
    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    // Generate slug from title
    public function generateSlug($title) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        return $slug;
    }

    // Generate service page file
    public function generateServicePage($title, $description, $short_description, $slug, $image = null, $banner_image = null) {
        $fileName = "services_" . $slug . ".php";
        $filePath = "../public/" . $fileName;
        
        // Define process steps based on service type
        $processSteps = $this->getProcessSteps($slug);
        $ctaData = $this->getCTAData($slug);
        
        // Generate PHP file content
        $content = $this->generatePageContent($title, $description, $short_description, $slug, $image, $banner_image, $processSteps, $ctaData);
        
        // Write file
        file_put_contents($filePath, $content);
    }

    // Delete service page file
    public function deleteServicePage($slug) {
        $fileName = "services_" . $slug . ".php";
        $filePath = "../public/" . $fileName;
        
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Get process steps for different service types
    private function getProcessSteps($slug) {
        $processSteps = [
            'construction' => [
                ['title' => 'Planning & Design', 'description' => 'We begin with thorough planning and design, working closely with architects and engineers to create detailed blueprints and construction schedules.'],
                ['title' => 'Permits & Approvals', 'description' => 'Our team handles all necessary permits and regulatory approvals, ensuring your project complies with local building codes and regulations.'],
                ['title' => 'Site Preparation', 'description' => 'We prepare the construction site with proper excavation, foundation work, and utility installations to create a solid base for your structure.'],
                ['title' => 'Construction', 'description' => 'Our skilled construction team executes the building process with precision, following the approved plans while maintaining quality and safety standards.'],
                ['title' => 'Finishing & Handover', 'description' => 'We complete all finishing touches, conduct thorough quality inspections, and hand over your completed project with full documentation and support.']
            ],
            'renovation' => [
                ['title' => 'Assessment & Consultation', 'description' => 'We begin with a thorough assessment of your existing space and an in-depth consultation to understand your renovation goals and requirements.'],
                ['title' => 'Design & Planning', 'description' => 'Our design team creates detailed renovation plans that address your needs while respecting the integrity of the original structure.'],
                ['title' => 'Demolition & Preparation', 'description' => 'We carefully remove outdated elements and prepare the space for renovation, ensuring proper disposal and recycling of materials.'],
                ['title' => 'Renovation Execution', 'description' => 'Our skilled craftsmen implement the renovation plan with precision, addressing structural, mechanical, and aesthetic aspects of your project.'],
                ['title' => 'Finishing & Reveal', 'description' => 'We complete all finishing touches, conduct quality inspections, and reveal your beautifully renovated space, ready for immediate use.']
            ],
            'architectural-design' => [
                ['title' => 'Conceptualization', 'description' => 'We begin with understanding your vision, requirements, and constraints to develop initial design concepts that capture the essence of your project.'],
                ['title' => 'Schematic Design', 'description' => 'We refine the selected concept into schematic drawings that outline spatial relationships, scale, and form, providing a clear direction for the project.'],
                ['title' => 'Design Development', 'description' => 'We develop detailed drawings that specify materials, finishes, and systems, creating a comprehensive vision of the final design.'],
                ['title' => 'Construction Documentation', 'description' => 'We prepare detailed construction drawings and specifications that provide all the information needed for permitting, bidding, and construction.'],
                ['title' => 'Construction Administration', 'description' => 'We oversee the construction process to ensure that the design is executed according to specifications, addressing any issues that arise during building.']
            ],
            'interior-design' => [
                ['title' => 'Consultation & Brief', 'description' => 'We begin with an in-depth consultation to understand your style preferences, functional requirements, and budget considerations for your interior project.'],
                ['title' => 'Concept Development', 'description' => 'Our designers create concept boards and preliminary designs that capture the essence of your vision while introducing innovative ideas and solutions.'],
                ['title' => 'Design Specification', 'description' => 'We develop detailed design specifications, including furniture layouts, material selections, color schemes, lighting plans, and custom elements.'],
                ['title' => 'Implementation', 'description' => 'Our team coordinates with contractors and suppliers to implement the design, overseeing all aspects of the installation process to ensure quality execution.'],
                ['title' => 'Styling & Finishing', 'description' => 'We complete your interior with careful styling and finishing touches, arranging accessories and ensuring every detail contributes to the overall design vision.']
            ]
        ];

        return isset($processSteps[$slug]) ? $processSteps[$slug] : [
            ['title' => 'Consultation', 'description' => 'We begin with understanding your needs and requirements.'],
            ['title' => 'Planning', 'description' => 'We create detailed plans for your project.'],
            ['title' => 'Execution', 'description' => 'We implement the project with precision and quality.'],
            ['title' => 'Completion', 'description' => 'We deliver your completed project on time.']
        ];
    }

    // Get CTA data for different service types
    private function getCTAData($slug) {
        $ctaData = [
            'construction' => ['title' => 'Ready to Build Your Dream Project?', 'description' => 'Contact us today to discuss your construction needs and get a detailed quote.', 'button' => 'Request a Quote'],
            'renovation' => ['title' => 'Ready to Renovate?', 'description' => 'Contact us today to discuss your renovation project and schedule a consultation.', 'button' => 'Start Your Renovation'],
            'architectural-design' => ['title' => 'Ready to Design Your Dream Space?', 'description' => 'Contact us today to schedule a consultation with our architectural design team.', 'button' => 'Start Your Design Journey'],
            'interior-design' => ['title' => 'Ready to Transform Your Interior?', 'description' => 'Contact us today to schedule a consultation with our interior design team.', 'button' => 'Begin Your Interior Journey']
        ];

        return isset($ctaData[$slug]) ? $ctaData[$slug] : [
            'title' => 'Ready to Start Your Project?',
            'description' => 'Contact us today to discuss your project needs.',
            'button' => 'Get Started'
        ];
    }

    // Generate the complete PHP page content
    private function generatePageContent($title, $description, $short_description, $slug, $image, $banner_image, $processSteps, $ctaData) {
        $content = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($title) . ' Services | TRIV Design and Construction</title>
    <link rel="stylesheet" href="../assets/css/public-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>

<div class="return-services-container">
    <a href="../public/services.php" class="return-services-button">
        <i class="fas fa-arrow-left"></i> Return to Services
    </a>
</div>

    <div class="logo">
        <img src="../assets/images/trivfinalnatalaga.png" alt="TRIV Design & Construction">
    </div>
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

    <main class="service-detail-main">
        <!-- Banner Section -->
        <section class="service-banner ' . $slug . '-banner">
            <div class="service-banner-overlay"></div>';
            
        if ($banner_image) {
            $content .= '
            <img src="../assets/images/' . htmlspecialchars($banner_image) . '" alt="' . htmlspecialchars($title) . ' Banner" class="hero-bg">';
        }
        
        $content .= '
            <div class="service-banner-content">
                <h1>' . htmlspecialchars($title) . '</h1>
                <p>' . htmlspecialchars($short_description) . '</p>
            </div>
        </section>

        <!-- Description Section -->
        <section class="service-description">
            <div class="service-description-container">
                <h2>' . htmlspecialchars($title) . ' Solutions</h2>
                <div class="service-description-content">
                    <div class="service-description-text">';
                    
        // Split description into paragraphs
        $paragraphs = explode("\n", $description);
        foreach ($paragraphs as $paragraph) {
            if (trim($paragraph)) {
                $content .= '
                        <p>' . htmlspecialchars(trim($paragraph)) . '</p>';
            }
        }
        
        $content .= '
                    </div>
                    <div class="service-description-image">';
                    
        if ($image) {
            $content .= '
                        <img src="../assets/images/' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($title) . ' project by TRIV">';
        } else {
            $content .= '
                        <img src="../assets/images/services_' . $slug . '.jpg" alt="' . htmlspecialchars($title) . ' project by TRIV">';
        }
        
        $content .= '
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="service-process">
            <div class="service-process-container">
                <h2>Our ' . htmlspecialchars($title) . ' Process</h2>
                <div class="process-steps">';
                
        foreach ($processSteps as $index => $step) {
            $content .= '
                    <div class="process-step">
                        <div class="process-step-number">' . ($index + 1) . '</div>
                        <div class="process-step-content">
                            <h3>' . htmlspecialchars($step['title']) . '</h3>
                            <p>' . htmlspecialchars($step['description']) . '</p>
                        </div>
                    </div>';
        }
        
        $content .= '
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="service-cta">
            <div class="service-cta-container">
                <h2>' . htmlspecialchars($ctaData['title']) . '</h2>
                <p>' . htmlspecialchars($ctaData['description']) . '</p>
                <a href="../public/contact.php" class="cta-button">' . htmlspecialchars($ctaData['button']) . '</a>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener(\'DOMContentLoaded\', function() {
            // Mobile menu toggle
            const menuToggle = document.querySelector(\'.menu-toggle\');
            const nav = document.querySelector(\'nav\');
            
            if (menuToggle) {
                menuToggle.addEventListener(\'click\', function() {
                    nav.classList.toggle(\'active\');
                });
            }
            
            // Close menu when clicking on a link
            const navLinks = document.querySelectorAll(\'nav ul li a\');
            navLinks.forEach(link => {
                link.addEventListener(\'click\', function() {
                    nav.classList.remove(\'active\');
                });
            });
        });
    </script>
</body>
</html>';

        return $content;
    }
}


class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $password, $role = 'client') {
        try {
            // Check if email already exists
            $checkStmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = ?");
            $checkStmt->execute([$email]);
            
            if ($checkStmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Email already registered'];
            }

            // Validate password strength
            if (strlen($password) < 6) {
                return ['success' => false, 'message' => 'Password must be at least 6 characters long'];
            }

            // Hash password and insert user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name, email, password, role, status, created_at) VALUES (?, ?, ?, ?, 'active', NOW())");
            
            if ($stmt->execute([$name, $email, $hashedPassword, $role])) {
                return ['success' => true, 'message' => 'Registration successful'];
            }
            
            return ['success' => false, 'message' => 'Registration failed'];
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Registration failed. Please try again.'];
        }
    }

    public function login($email, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = ? AND status = 'active'");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Update last login
                $updateStmt = $this->conn->prepare("UPDATE {$this->table} SET last_login = NOW() WHERE id = ?");
                $updateStmt->execute([$user['id']]);
                
                return [
                    'success' => true,
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ]
                ];
            }

            return ['success' => false, 'message' => 'Invalid email or password'];
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Login failed. Please try again.'];
        }
    }

    public function getUserById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get user error: " . $e->getMessage());
            return false;
        }
    }

    public function getCount() {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM {$this->table}");
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Get count error: " . $e->getMessage());
            return 0;
        }
    }

    public function getAllUsers() {
        try {
            $stmt = $this->conn->prepare("SELECT id, name, email, role, status, created_at, last_login FROM {$this->table} ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get all users error: " . $e->getMessage());
            return [];
        }
    }

    // NEW METHODS FOR ADMIN MANAGEMENT

    public function create($data) {
        try {
            // Check if email already exists
            $checkStmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = ?");
            $checkStmt->execute([$data['email']]);
            
            if ($checkStmt->rowCount() > 0) {
                return false;
            }

            // Hash password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name, email, password, role, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            
            return $stmt->execute([
                $data['name'],
                $data['email'],
                $hashedPassword,
                $data['role'],
                $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("Create user error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        try {
            // Check if email already exists for other users
            $checkStmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = ? AND id != ?");
            $checkStmt->execute([$data['email'], $id]);
            
            if ($checkStmt->rowCount() > 0) {
                return false;
            }

            $sql = "UPDATE {$this->table} SET name = ?, email = ?, role = ?, status = ?";
            $params = [$data['name'], $data['email'], $data['role'], $data['status']];

            // Only update password if provided
            if (!empty($data['password'])) {
                $sql .= ", password = ?";
                $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            $sql .= " WHERE id = ?";
            $params[] = $id;

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Update user error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            // Don't allow deletion of the last admin
            $adminCount = $this->getAdminCount();
            $user = $this->getUserById($id);
            
            if ($user['role'] === 'admin' && $adminCount <= 1) {
                return false; // Cannot delete the last admin
            }

            $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete user error: " . $e->getMessage());
            return false;
        }
    }

    public function updateStatus($id, $status) {
        try {
            $stmt = $this->conn->prepare("UPDATE {$this->table} SET status = ? WHERE id = ?");
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            error_log("Update status error: " . $e->getMessage());
            return false;
        }
    }

    public function updateRole($id, $role) {
        try {
            // Don't allow changing the last admin's role
            $adminCount = $this->getAdminCount();
            $user = $this->getUserById($id);
            
            if ($user['role'] === 'admin' && $adminCount <= 1 && $role !== 'admin') {
                return false; // Cannot change the last admin's role
            }

            $stmt = $this->conn->prepare("UPDATE {$this->table} SET role = ? WHERE id = ?");
            return $stmt->execute([$role, $id]);
        } catch (PDOException $e) {
            error_log("Update role error: " . $e->getMessage());
            return false;
        }
    }

    public function getAdminCount() {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM {$this->table} WHERE role = 'admin'");
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Get admin count error: " . $e->getMessage());
            return 0;
        }
    }

    public function searchUsers($search) {
        try {
            $searchTerm = "%{$search}%";
            $stmt = $this->conn->prepare("SELECT id, name, email, role, status, created_at, last_login FROM {$this->table} WHERE name LIKE ? OR email LIKE ? ORDER BY created_at DESC");
            $stmt->execute([$searchTerm, $searchTerm]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Search users error: " . $e->getMessage());
            return [];
        }
    }

    public function getUsersByRole($role) {
        try {
            $stmt = $this->conn->prepare("SELECT id, name, email, role, status, created_at, last_login FROM {$this->table} WHERE role = ? ORDER BY created_at DESC");
            $stmt->execute([$role]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get users by role error: " . $e->getMessage());
            return [];
        }
    }

    public function getUsersByStatus($status) {
        try {
            $stmt = $this->conn->prepare("SELECT id, name, email, role, status, created_at, last_login FROM {$this->table} WHERE status = ? ORDER BY created_at DESC");
            $stmt->execute([$status]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get users by status error: " . $e->getMessage());
            return [];
        }
    }

    public function getRecentUsers($limit = 5) {
        try {
            $stmt = $this->conn->prepare("SELECT id, name, email, role, status, created_at FROM {$this->table} ORDER BY created_at DESC LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get recent users error: " . $e->getMessage());
            return [];
        }
    }

    public function emailExists($email, $excludeId = null) {
        try {
            if ($excludeId) {
                $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = ? AND id != ?");
                $stmt->execute([$email, $excludeId]);
            } else {
                $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = ?");
                $stmt->execute([$email]);
            }
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Email exists check error: " . $e->getMessage());
            return false;
        }
    }
}

class ContactInquiry {
    private $conn;
    private $table = 'contact_inquiries';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($userId, $name, $email, $mobile, $message, $planFile = null) {
        try {
            $sql = "INSERT INTO {$this->table} (user_id, name, email, mobile, message, plan_file, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$userId, $name, $email, $mobile, $message, $planFile]);
        } catch (PDOException $e) {
            error_log("Contact inquiry creation error: " . $e->getMessage());
            return false;
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT ci.*, u.name as user_name, u.email as user_email 
                    FROM {$this->table} ci 
                    LEFT JOIN users u ON ci.user_id = u.id 
                    ORDER BY ci.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get inquiries error: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT ci.*, u.name as user_name, u.email as user_email 
                    FROM {$this->table} ci 
                    LEFT JOIN users u ON ci.user_id = u.id 
                    WHERE ci.id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get inquiry error: " . $e->getMessage());
            return false;
        }
    }

    public function updateStatus($id, $status) {
        try {
            $sql = "UPDATE {$this->table} SET status = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            error_log("Update status error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete inquiry error: " . $e->getMessage());
            return false;
        }
    }

    public function getCount() {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Get count error: " . $e->getMessage());
            return 0;
        }
    }

    public function getPendingCount() {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'pending'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Get pending count error: " . $e->getMessage());
            return 0;
        }
    }

    public function getRecentInquiries($limit = 5) {
        try {
            $sql = "SELECT ci.*, u.name as user_name 
                    FROM {$this->table} ci 
                    LEFT JOIN users u ON ci.user_id = u.id 
                    ORDER BY ci.created_at DESC 
                    LIMIT ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get recent inquiries error: " . $e->getMessage());
            return [];
        }
    }

    public function getInquiriesByUser($userId) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get user inquiries error: " . $e->getMessage());
            return [];
        }
    }
}

class Job {
    private $conn;
    private $table = 'jobs';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getActive() {
        $sql = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByDepartment($department) {
        $sql = "SELECT * FROM " . $this->table . " WHERE department = :department AND status = 'active' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':department', $department);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO " . $this->table . " 
                (title, department, location, employment_type, description, responsibilities, 
                 qualifications, schedule, benefits, salary_range, status) 
                VALUES (:title, :department, :location, :employment_type, :description, 
                        :responsibilities, :qualifications, :schedule, :benefits, :salary_range, :status)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $sql = "UPDATE " . $this->table . " 
                SET title = :title, department = :department, location = :location, 
                    employment_type = :employment_type, description = :description, 
                    responsibilities = :responsibilities, qualifications = :qualifications, 
                    schedule = :schedule, benefits = :benefits, salary_range = :salary_range, 
                    status = :status, updated_at = NOW() 
                WHERE id = :id";
        
        $data['id'] = $id;
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }
}

class JobApplication {
    private $conn;
    private $table = 'job_applications';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT ja.*, j.title as job_title, j.department 
                FROM " . $this->table . " ja 
                LEFT JOIN jobs j ON ja.job_id = j.id 
                ORDER BY ja.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT ja.*, j.title as job_title, j.department 
                FROM " . $this->table . " ja 
                LEFT JOIN jobs j ON ja.job_id = j.id 
                WHERE ja.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO " . $this->table . " 
                (job_id, first_name, last_name, email, phone, address, resume_file, 
                 portfolio_url, linkedin_url, experience, cover_letter, start_date, 
                 expected_salary, referral_source, status) 
                VALUES (:job_id, :first_name, :last_name, :email, :phone, :address, 
                        :resume_file, :portfolio_url, :linkedin_url, :experience, 
                        :cover_letter, :start_date, :expected_salary, :referral_source, :status)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function updateStatus($id, $status, $notes = '') {
        $sql = "UPDATE " . $this->table . " 
                SET status = :status, notes = :notes, updated_at = NOW() 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'status' => $status,
            'notes' => $notes
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }

    public function getPendingCount() {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE status = 'pending'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }

    public function getRecentApplications($limit = 5) {
        $sql = "SELECT ja.*, j.title as job_title 
                FROM " . $this->table . " ja 
                LEFT JOIN jobs j ON ja.job_id = j.id 
                ORDER BY ja.created_at DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

class Developer {
    private $conn;
    private $table = 'developers';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all developers
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY order_position ASC, name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get active developers
    public function getActive() {
        $sql = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY order_position ASC, name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get developer by ID
    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new developer
    public function create($data) {
        $sql = "INSERT INTO " . $this->table . " 
                (name, position, bio, image, email, github, linkedin, order_position, status) 
                VALUES (:name, :position, :bio, :image, :email, :github, :linkedin, :order_position, :status)";
        
        $stmt = $this->conn->prepare($sql);
        
        // Clean and bind data
        $name = htmlspecialchars(strip_tags($data['name']));
        $position = htmlspecialchars(strip_tags($data['position']));
        $bio = htmlspecialchars(strip_tags($data['bio']));
        $image = htmlspecialchars(strip_tags($data['image']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $github = htmlspecialchars(strip_tags($data['github']));
        $linkedin = htmlspecialchars(strip_tags($data['linkedin']));
        $order_position = (int)$data['order_position'];
        $status = htmlspecialchars(strip_tags($data['status']));
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':github', $github);
        $stmt->bindParam(':linkedin', $linkedin);
        $stmt->bindParam(':order_position', $order_position);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        
        return false;
    }

    // Update developer
    public function update($id, $data) {
        $sql = "UPDATE " . $this->table . " 
                SET name = :name, position = :position, bio = :bio, 
                    email = :email, github = :github, linkedin = :linkedin, 
                    order_position = :order_position, status = :status";
        
        // Only update image if provided
        if (!empty($data['image'])) {
            $sql .= ", image = :image";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        
        // Clean and bind data
        $name = htmlspecialchars(strip_tags($data['name']));
        $position = htmlspecialchars(strip_tags($data['position']));
        $bio = htmlspecialchars(strip_tags($data['bio']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $github = htmlspecialchars(strip_tags($data['github']));
        $linkedin = htmlspecialchars(strip_tags($data['linkedin']));
        $order_position = (int)$data['order_position'];
        $status = htmlspecialchars(strip_tags($data['status']));
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':github', $github);
        $stmt->bindParam(':linkedin', $linkedin);
        $stmt->bindParam(':order_position', $order_position);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        
        // Bind image if provided
        if (!empty($data['image'])) {
            $image = htmlspecialchars(strip_tags($data['image']));
            $stmt->bindParam(':image', $image);
        }
        
        return $stmt->execute();
    }

    // Delete developer
    public function delete($id) {
        // First get the image filename to delete the file
        $developer = $this->getById($id);
        
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            // Return the image filename so we can delete the file if needed
            return $developer['image'] ?? null;
        }
        
        return false;
    }

    // Get count of developers
    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}

class TeamMember {
    private $conn;
    private $table = 'team_members';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all team members
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY order_position ASC, name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get active team members
    public function getActive() {
        $sql = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY order_position ASC, name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get team member by ID
    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new team member
    public function create($data) {
        $sql = "INSERT INTO " . $this->table . " 
                (name, position, bio, image, email, phone, linkedin, specialization, years_experience, order_position, status) 
                VALUES (:name, :position, :bio, :image, :email, :phone, :linkedin, :specialization, :years_experience, :order_position, :status)";
        
        $stmt = $this->conn->prepare($sql);
        
        // Clean and bind data
        $name = htmlspecialchars(strip_tags($data['name']));
        $position = htmlspecialchars(strip_tags($data['position']));
        $bio = htmlspecialchars(strip_tags($data['bio']));
        $image = htmlspecialchars(strip_tags($data['image']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $phone = htmlspecialchars(strip_tags($data['phone']));
        $linkedin = htmlspecialchars(strip_tags($data['linkedin']));
        $specialization = htmlspecialchars(strip_tags($data['specialization']));
        $years_experience = (int)$data['years_experience'];
        $order_position = (int)$data['order_position'];
        $status = htmlspecialchars(strip_tags($data['status']));
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':linkedin', $linkedin);
        $stmt->bindParam(':specialization', $specialization);
        $stmt->bindParam(':years_experience', $years_experience);
        $stmt->bindParam(':order_position', $order_position);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        
        return false;
    }

    // Update team member
    public function update($id, $data) {
        $sql = "UPDATE " . $this->table . " 
                SET name = :name, position = :position, bio = :bio, 
                    email = :email, phone = :phone, linkedin = :linkedin, 
                    specialization = :specialization, years_experience = :years_experience,
                    order_position = :order_position, status = :status";
        
        // Only update image if provided
        if (!empty($data['image'])) {
            $sql .= ", image = :image";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        
        // Clean and bind data
        $name = htmlspecialchars(strip_tags($data['name']));
        $position = htmlspecialchars(strip_tags($data['position']));
        $bio = htmlspecialchars(strip_tags($data['bio']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $phone = htmlspecialchars(strip_tags($data['phone']));
        $linkedin = htmlspecialchars(strip_tags($data['linkedin']));
        $specialization = htmlspecialchars(strip_tags($data['specialization']));
        $years_experience = (int)$data['years_experience'];
        $order_position = (int)$data['order_position'];
        $status = htmlspecialchars(strip_tags($data['status']));
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':linkedin', $linkedin);
        $stmt->bindParam(':specialization', $specialization);
        $stmt->bindParam(':years_experience', $years_experience);
        $stmt->bindParam(':order_position', $order_position);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        
        // Bind image if provided
        if (!empty($data['image'])) {
            $image = htmlspecialchars(strip_tags($data['image']));
            $stmt->bindParam(':image', $image);
        }
        
        return $stmt->execute();
    }

    // Delete team member
    public function delete($id) {
        // First get the image filename to delete the file
        $teamMember = $this->getById($id);
        
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            // Return the image filename so we can delete the file if needed
            return $teamMember['image'] ?? null;
        }
        
        return false;
    }

    // Get count of team members
    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    // Get team members by specialization
    public function getBySpecialization($specialization) {
        $sql = "SELECT * FROM " . $this->table . " WHERE specialization LIKE :specialization AND status = 'active' ORDER BY order_position ASC";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = '%' . $specialization . '%';
        $stmt->bindParam(':specialization', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
