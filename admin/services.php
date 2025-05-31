<?php
require_once '../classes/Auth.php';
require_once '../classes/Database.php';

Auth::requireLogin();
Auth::requireRole('admin');

$db = new Database();
$conn = $db->connect();
$service = new Service($conn);

// Handle form submissions
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $slug = $service->generateSlug($_POST['title']);
                $image = null;
                $banner_image = null;
                
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $image = handleImageUpload($_FILES['image']);
                }
                if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === 0) {
                    $banner_image = handleImageUpload($_FILES['banner_image']);
                }
                
                if ($service->create($_POST['title'], $_POST['description'], $_POST['short_description'], $slug, $image, $banner_image, $_POST['display_order'], $_POST['status'])) {
                    $pageMessage = $_POST['status'] === 'active' ? ' Page file "services_' . $slug . '.php" has been generated.' : '';
                    $message = 'Service created successfully!' . $pageMessage;
                    $messageType = 'success';
                } else {
                    $message = 'Error creating service.';
                    $messageType = 'error';
                }
                break;
                
            case 'update':
                $oldService = $service->getById($_POST['id']);
                $slug = $service->generateSlug($_POST['title']);
                $image = null;
                $banner_image = null;
                
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $image = handleImageUpload($_FILES['image']);
                }
                if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === 0) {
                    $banner_image = handleImageUpload($_FILES['banner_image']);
                }
                
                if ($service->update($_POST['id'], $_POST['title'], $_POST['description'], $_POST['short_description'], $slug, $image, $banner_image, $_POST['display_order'], $_POST['status'])) {
                    $pageMessage = '';
                    if ($_POST['status'] === 'active') {
                        if ($oldService && $oldService['slug'] !== $slug) {
                            $pageMessage = ' Old page "services_' . $oldService['slug'] . '.php" deleted and new page "services_' . $slug . '.php" created.';
                        } else {
                            $pageMessage = ' Page "services_' . $slug . '.php" updated.';
                        }
                    } else {
                        $pageMessage = ' Page file has been removed from public view.';
                    }
                    $message = 'Service updated successfully!' . $pageMessage;
                    $messageType = 'success';
                } else {
                    $message = 'Error updating service.';
                    $messageType = 'error';
                }
                break;
                
            case 'toggle_status':
                $serviceData = $service->getById($_POST['id']);
                $newStatus = $serviceData['status'] === 'active' ? 'inactive' : 'active';
                
                if ($service->updateStatus($_POST['id'], $newStatus)) {
                    $pageMessage = $newStatus === 'active' 
                        ? ' Page file "services_' . $serviceData['slug'] . '.php" has been generated.'
                        : ' Page file "services_' . $serviceData['slug'] . '.php" has been removed from public view.';
                    
                    $message = 'Service status updated to ' . ucfirst($newStatus) . ' successfully!' . $pageMessage;
                    $messageType = 'success';
                } else {
                    $message = 'Error updating service status.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get all services
$services = $service->getAll();

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
    <title>Services Management - TRIV Admin</title>
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
        img {
      max-width: 100%;
       height: 40px;
}
        main { flex: 1; padding: 20px; overflow-y: auto; }
        header { background: white; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; border-radius: 8px; }
        .btn { display: inline-block; background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; margin: 5px; font-size: 12px; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .btn-info { background: #17a2b8; }
        .btn-info:hover { background: #138496; }
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
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        .action-buttons { display: flex; gap: 5px; flex-wrap: wrap; }
        .page-info { background: #e7f3ff; padding: 10px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #007bff; }
        .page-filename { font-family: monospace; background: #f8f9fa; padding: 2px 6px; border-radius: 3px; }
        .filter-controls { display: flex; gap: 10px; margin-bottom: 15px; align-items: center; }
        .filter-controls select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .status-count { display: flex; gap: 15px; margin-bottom: 15px; }
        .status-count-item { padding: 8px 15px; border-radius: 4px; display: flex; align-items: center; }
        .status-count-item i { margin-right: 8px; }
        .status-count-active { background: #d4edda; color: #155724; }
        .status-count-inactive { background: #f8d7da; color: #721c24; }
        .status-count-all { background: #e2e3e5; color: #383d41; }
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
            <h1>Services Management</h1>
            <button class="btn btn-success" onclick="openModal('createModal')">
                <i class="fas fa-plus"></i> Add New Service
            </button>
        </header>

        <div class="page-info">
            <strong><i class="fas fa-info-circle"></i> Auto Page Generation:</strong> 
            When you create or update an active service, a PHP page file is automatically generated in the public folder. 
            Inactive services are only visible in the admin panel.
        </div>

        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php
            // Count services by status
            $activeCount = 0;
            $inactiveCount = 0;
            foreach ($services as $serv) {
                if ($serv['status'] === 'active') {
                    $activeCount++;
                } else {
                    $inactiveCount++;
                }
            }
            $totalCount = count($services);
        ?>

        <div class="status-count">
            <div class="status-count-item status-count-all" onclick="filterServices('all')">
                <i class="fas fa-list"></i> All Services: <?= $totalCount ?>
            </div>
            <div class="status-count-item status-count-active" onclick="filterServices('active')">
                <i class="fas fa-check-circle"></i> Active: <?= $activeCount ?>
            </div>
            <div class="status-count-item status-count-inactive" onclick="filterServices('inactive')">
                <i class="fas fa-archive"></i> Archived: <?= $inactiveCount ?>
            </div>
        </div>

        <div class="filter-controls">
            <label for="status-filter">Filter by status:</label>
            <select id="status-filter" onchange="filterServices(this.value)">
                <option value="all">All Services</option>
                <option value="active">Active Only</option>
                <option value="inactive">Archived Only</option>
            </select>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Page File</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $serv): ?>
                <tr class="service-row" data-status="<?= $serv['status'] ?>">
                    <td><?= $serv['id'] ?></td>
                    <td>
                        <?php if ($serv['image']): ?>
                            <img src="../assets/images/<?= htmlspecialchars($serv['image']) ?>" alt="Service Image">
                        <?php else: ?>
                            <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #ccc;"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($serv['title']) ?></td>
                    <td>
                        <span class="page-filename">services_<?= $serv['slug'] ?>.php</span>
                        <?php if ($serv['status'] === 'active'): ?>
                            <?php if (file_exists("../public/services_" . $serv['slug'] . ".php")): ?>
                                <i class="fas fa-check-circle" style="color: green; margin-left: 5px;" title="File exists"></i>
                            <?php else: ?>
                                <i class="fas fa-exclamation-triangle" style="color: orange; margin-left: 5px;" title="File missing"></i>
                            <?php endif; ?>
                        <?php else: ?>
                            <i class="fas fa-archive" style="color: #6c757d; margin-left: 5px;" title="Archived - no public page"></i>
                        <?php endif; ?>
                    </td>
                    <td><?= $serv['display_order'] ?></td>
                    <td>
                        <span class="status-badge status-<?= $serv['status'] ?>">
                            <?= $serv['status'] === 'active' ? 'Active' : 'Archived' ?>
                        </span>
                    </td>
                    <td><?= date('M j, Y', strtotime($serv['created_at'])) ?></td>
                    <td>
                        <div class="action-buttons">
                            <?php if ($serv['status'] === 'active'): ?>
                            <a href="../public/services_<?= $serv['slug'] ?>.php" target="_blank" class="btn btn-info" title="View Page">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php endif; ?>
                            <button class="btn btn-warning" onclick="editService(<?= htmlspecialchars(json_encode($serv)) ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form style="display: inline;" method="POST" onsubmit="return confirm('Are you sure you want to <?= $serv['status'] === 'active' ? 'archive' : 'activate' ?> this service? <?= $serv['status'] === 'active' ? 'It will be removed from public view but remain in the admin panel.' : 'It will be visible on the public website.' ?>')">
                                <input type="hidden" name="action" value="toggle_status">
                                <input type="hidden" name="id" value="<?= $serv['id'] ?>">
                                <button type="submit" class="btn <?= $serv['status'] === 'active' ? 'btn-danger' : 'btn-success' ?>" title="<?= $serv['status'] === 'active' ? 'Archive' : 'Activate' ?>">
                                    <i class="fas <?= $serv['status'] === 'active' ? 'fa-archive' : 'fa-check-circle' ?>"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Create Service Modal -->
        <div id="createModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('createModal')">&times;</span>
                <h2>Add New Service</h2>
                <p style="margin-bottom: 15px; color: #666;">
                    <i class="fas fa-magic"></i> A PHP page file will be automatically created when you save this service as active.
                </p>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required>
                        <small>This will create: <span id="preview-filename">services_[slug].php</span></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="short_description">Short Description:</label>
                        <textarea id="short_description" name="short_description" required placeholder="Brief description for service cards"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Full Description:</label>
                        <textarea id="description" name="description" required style="height: 150px;" placeholder="Detailed description for service page. Use line breaks to separate paragraphs."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Service Card Image:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <small>Image for service cards on main services page</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="banner_image">Banner Image:</label>
                        <input type="file" id="banner_image" name="banner_image" accept="image/*">
                        <small>Hero banner image for service page</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="display_order">Display Order:</label>
                        <input type="number" id="display_order" name="display_order" value="0" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Archived</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Create Service</button>
                </form>
            </div>
        </div>

        <!-- Edit Service Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editModal')">&times;</span>
                <h2>Edit Service</h2>
                <p style="margin-bottom: 15px; color: #666;">
                    <i class="fas fa-sync"></i> The PHP page file will be automatically updated when you save changes if the service is active.
                </p>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="form-group">
                        <label for="edit_title">Title:</label>
                        <input type="text" id="edit_title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_short_description">Short Description:</label>
                        <textarea id="edit_short_description" name="short_description" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_description">Full Description:</label>
                        <textarea id="edit_description" name="description" required style="height: 150px;"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_image">Service Card Image (leave empty to keep current):</label>
                        <input type="file" id="edit_image" name="image" accept="image/*">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_banner_image">Banner Image (leave empty to keep current):</label>
                        <input type="file" id="edit_banner_image" name="banner_image" accept="image/*">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_display_order">Display Order:</label>
                        <input type="number" id="edit_display_order" name="display_order" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_status">Status:</label>
                        <select id="edit_status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Archived</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Update Service</button>
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

        function editService(service) {
            document.getElementById('edit_id').value = service.id;
            document.getElementById('edit_title').value = service.title;
            document.getElementById('edit_short_description').value = service.short_description;
            document.getElementById('edit_description').value = service.description;
            document.getElementById('edit_display_order').value = service.display_order;
            document.getElementById('edit_status').value = service.status;
            openModal('editModal');
        }

        // Preview filename generation
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title.toLowerCase().replace(/[^a-z0-9-]+/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('preview-filename').textContent = 'services_' + slug + '.php';
        });

        // Filter services by status
        function filterServices(status) {
            if (!status) {
                status = document.getElementById('status-filter').value;
            } else {
                document.getElementById('status-filter').value = status;
            }
            
            const rows = document.querySelectorAll('.service-row');
            
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || rowStatus === status) {
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

        // Initialize the filter
        document.addEventListener('DOMContentLoaded', function() {
            filterServices('all');
        });
    </script>
</body>
</html>
