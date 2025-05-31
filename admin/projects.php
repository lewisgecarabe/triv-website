<?php
require_once '../classes/Auth.php';
require_once '../classes/Database.php';

Auth::requireLogin();
Auth::requireRole('admin');

$db = new Database();
$conn = $db->connect();
$project = new Project($conn);

// Handle form submissions
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $imageName = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $imageName = handleImageUpload($_FILES['image']);
                }
                
                if ($project->create($_POST['title'], $_POST['description'], $_POST['location'], $_POST['category'], $imageName, $_POST['status'])) {
                    $message = 'Project created successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error creating project.';
                    $messageType = 'error';
                }
                break;
                
            case 'update':
                $imageName = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $imageName = handleImageUpload($_FILES['image']);
                }
                
                if ($project->update($_POST['id'], $_POST['title'], $_POST['description'], $_POST['location'], $_POST['category'], $imageName, $_POST['status'])) {
                    $message = 'Project updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating project.';
                    $messageType = 'error';
                }
                break;
                
            case 'toggle_status':
                $projectData = $project->getById($_POST['id']);
                $newStatus = $projectData['status'] === 'active' ? 'inactive' : 'active';
                
                if ($project->updateStatus($_POST['id'], $newStatus)) {
                    $message = 'Project status updated to ' . ucfirst($newStatus) . ' successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating project status.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get all projects
$projects = $project->getAll();

// Handle image upload
function handleImageUpload($file) {
    $uploadDir = '../assets/images/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($file['type'], $allowedTypes)) {
        return null;
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $extension;
    $uploadPath = $uploadDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return $fileName;
    }
    
    return null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Management - TRIV Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
font-family: 'Lato', sans-serif;
}
    
    body { 
      display: flex; 
      height: 100vh; 
     color: #333;
    }
    
    aside { 
      width: 250px; 
      background: #1a2b49; 
      color: white; 
      padding: 20px; 
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    
    aside h2 { 
      margin-bottom: 30px; 
      text-align: center;
      color: #ffc107;
      font-size: 1.5em;
    }
    
    aside ul { 
      list-style: none; 
    }
    
    aside ul li { 
      margin: 15px 0; 
    }
    
    aside ul li a { 
      color: white; 
      text-decoration: none; 
      display: flex; 
      align-items: center; 
      padding: 12px 15px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    aside ul li a:hover {
      background: rgba(97, 218, 251, 0.1);
      transform: translateX(5px);
    }
    
    aside ul li a i { 
      margin-right: 12px; 
      width: 20px;
      text-align: center;
    }
    
    aside ul li a.active { 
      background: #ffc107; 
      box-shadow: 0 2px 10px rgba(83, 86, 88, 0.3);
    }
    
    .logout-btn {
      margin-top: 30px !important;
      border-top: 1px solid #333;
      padding-top: 20px !important;
    }
    
    .logout-btn a {
      color: #ff6b6b !important;
    }
        main { flex: 1; padding: 20px; overflow-y: auto; }
        header { background: white; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; border-radius: 8px; }
        .btn { display: inline-block; background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; margin: 5px; font-size: 12px; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-warning:hover { background: #e0a800; }
        .table { width: 100%; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .table th { background: #f8f9fa; font-weight: bold; }
        .table img { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 5% auto; padding: 20px; width: 80%; max-width: 600px; border-radius: 8px; max-height: 80vh; overflow-y: auto; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close:hover { color: black; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .form-group textarea { height: 100px; resize: vertical; }
        .message { padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .message.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .project-image { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        .action-buttons { display: flex; gap: 5px; flex-wrap: wrap; }
        .filter-controls { display: flex; gap: 10px; margin-bottom: 15px; align-items: center; }
        .filter-controls select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .status-count { display: flex; gap: 15px; margin-bottom: 15px; }
        .status-count-item { padding: 8px 15px; border-radius: 4px; display: flex; align-items: center; cursor: pointer; transition: all 0.3s ease; }
        .status-count-item:hover { transform: translateY(-2px); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .status-count-item i { margin-right: 8px; }
        .status-count-active { background: #d4edda; color: #155724; }
        .status-count-inactive { background: #f8d7da; color: #721c24; }
        .status-count-all { background: #e2e3e5; color: #383d41; }
        .page-info { background: #e7f3ff; padding: 10px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #007bff; }
            img {
      max-width: 100%;
       height: 40px;
}
    </style>
</head>
<body>
     <aside>
    <h2><img src = ../assets/images/trivfinalnatalaga.png></h2>
    <ul>
      <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
      <li><a href="projects.php"><i class="fas fa-tools"></i> Projects</a></li>
      <li><a href="manage-users.php"><i class="fas fa-users"></i> Users</a></li>
      <li><a href="services.php"><i class="fas fa-concierge-bell"></i> Services</a></li>
       <li><a href="manage-jobs.php"><i class="fas fa-briefcase"></i> Jobs</a></li>
            <li><a href="manage-applications.php"><i class="fas fa-file-alt"></i> Applications</a></li>
            <li><a href="manage-team.php"><i class="fas fa-users-cog"></i> Team Members</a></li>
            <li><a href="manage-developers.php"><i class="fas fa-code"></i> Developers</a></li>
            <li><a href="manage-inquiries.php"><i class="fas fa-envelope"></i> Inquiries</a></li>
      <li class="logout-btn"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </aside>

    <main>
        <header>
            <h1>Projects Management</h1>
            <button class="btn btn-success" onclick="openModal('createModal')">
                <i class="fas fa-plus"></i> Add New Project
            </button>
        </header>

        <div class="page-info">
            <strong><i class="fas fa-info-circle"></i> Project Archive System:</strong> 
            Projects can be set as active (visible on public website) or archived (only visible in admin panel). 
            Archived projects are preserved for reference but hidden from public view.
        </div>

        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php
            // Count projects by status
            $activeCount = 0;
            $inactiveCount = 0;
            foreach ($projects as $proj) {
                if ($proj['status'] === 'active') {
                    $activeCount++;
                } else {
                    $inactiveCount++;
                }
            }
            $totalCount = count($projects);
        ?>

        <div class="status-count">
            <div class="status-count-item status-count-all" onclick="filterProjects('all')">
                <i class="fas fa-list"></i> All Projects: <?= $totalCount ?>
            </div>
            <div class="status-count-item status-count-active" onclick="filterProjects('active')">
                <i class="fas fa-check-circle"></i> Active: <?= $activeCount ?>
            </div>
            <div class="status-count-item status-count-inactive" onclick="filterProjects('inactive')">
                <i class="fas fa-archive"></i> Archived: <?= $inactiveCount ?>
            </div>
        </div>

        <div class="filter-controls">
            <label for="status-filter">Filter by status:</label>
            <select id="status-filter" onchange="filterProjects(this.value)">
                <option value="all">All Projects</option>
                <option value="active">Active Only</option>
                <option value="inactive">Archived Only</option>
            </select>
            
            <label for="category-filter" style="margin-left: 20px;">Filter by category:</label>
            <select id="category-filter" onchange="filterByCategory()">
                <option value="all">All Categories</option>
                <option value="construction">Construction</option>
                <option value="architectural-design">Architectural Design</option>
                <option value="renovation">Renovation</option>
                <option value="interior-design">Interior Design</option>
            </select>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $proj): ?>
                <tr class="project-row" data-status="<?= $proj['status'] ?>" data-category="<?= $proj['category'] ?>">
                    <td><?= $proj['id'] ?></td>
                    <td>
                        <?php if ($proj['image']): ?>
                            <img src="../assets/images/<?= htmlspecialchars($proj['image']) ?>" alt="Project Image" class="project-image">
                        <?php else: ?>
                            <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #ccc;"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($proj['title']) ?></td>
                    <td><?= htmlspecialchars($proj['category']) ?></td>
                    <td><?= htmlspecialchars($proj['location']) ?></td>
                    <td>
                        <span class="status-badge status-<?= $proj['status'] ?>">
                            <?= $proj['status'] === 'active' ? 'Active' : 'Archived' ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars(substr($proj['description'], 0, 100)) ?>...</td>
                    <td><?= date('M j, Y', strtotime($proj['created_at'])) ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-warning" onclick="editProject(<?= htmlspecialchars(json_encode($proj)) ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form style="display: inline;" method="POST" onsubmit="return confirm('Are you sure you want to <?= $proj['status'] === 'active' ? 'archive' : 'activate' ?> this project? <?= $proj['status'] === 'active' ? 'It will be removed from public view but remain in the admin panel.' : 'It will be visible on the public website.' ?>')">
                                <input type="hidden" name="action" value="toggle_status">
                                <input type="hidden" name="id" value="<?= $proj['id'] ?>">
                                <button type="submit" class="btn <?= $proj['status'] === 'active' ? 'btn-danger' : 'btn-success' ?>" title="<?= $proj['status'] === 'active' ? 'Archive' : 'Activate' ?>">
                                    <i class="fas <?= $proj['status'] === 'active' ? 'fa-archive' : 'fa-check-circle' ?>"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Create Project Modal -->
        <div id="createModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('createModal')">&times;</span>
                <h2>Add New Project</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="construction">Construction</option>
                            <option value="architectural-design">Architectural Design</option>
                            <option value="renovation">Renovation</option>
                            <option value="interior-design">Interior Design</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" id="location" name="location" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Archived</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Create Project</button>
                </form>
            </div>
        </div>

        <!-- Edit Project Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editModal')">&times;</span>
                <h2>Edit Project</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="form-group">
                        <label for="edit_title">Title:</label>
                        <input type="text" id="edit_title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_category">Category:</label>
                        <select id="edit_category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="construction">Construction</option>
                            <option value="architectural-design">Architectural Design</option>
                            <option value="renovation">Renovation</option>
                            <option value="interior-design">Interior Design</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_location">Location:</label>
                        <input type="text" id="edit_location" name="location" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_description">Description:</label>
                        <textarea id="edit_description" name="description" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_image">Image (leave empty to keep current):</label>
                        <input type="file" id="edit_image" name="image" accept="image/*">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_status">Status:</label>
                        <select id="edit_status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Archived</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Update Project</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function editProject(project) {
            document.getElementById('edit_id').value = project.id;
            document.getElementById('edit_title').value = project.title;
            document.getElementById('edit_category').value = project.category;
            document.getElementById('edit_location').value = project.location;
            document.getElementById('edit_description').value = project.description;
            document.getElementById('edit_status').value = project.status;
            openModal('editModal');
        }

        // Filter projects by status
        function filterProjects(status) {
            if (!status) {
                status = document.getElementById('status-filter').value;
            } else {
                document.getElementById('status-filter').value = status;
            }
            
            applyFilters();
        }

        // Filter projects by category
        function filterByCategory() {
            applyFilters();
        }

        // Apply both status and category filters
        function applyFilters() {
            const statusFilter = document.getElementById('status-filter').value;
            const categoryFilter = document.getElementById('category-filter').value;
            const rows = document.querySelectorAll('.project-row');
            
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                const rowCategory = row.getAttribute('data-category');
                
                const statusMatch = statusFilter === 'all' || rowStatus === statusFilter;
                const categoryMatch = categoryFilter === 'all' || rowCategory === categoryFilter;
                
                if (statusMatch && categoryMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }

        // Initialize the filters
        document.addEventListener('DOMContentLoaded', function() {
            applyFilters();
        });
    </script>
</body>
</html>
