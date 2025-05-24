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

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $password, $role = 'client') {
    // 1. Check if email already exists
    $check = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        return false;  // Email already registered
    }

    // 2. If not, proceed to insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $hashed_password, $role]);
}


    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}

?>
