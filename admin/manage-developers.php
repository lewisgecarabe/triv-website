<?php
require_once '../classes/Auth.php';
require_once '../classes/Database.php';

// Ensure only admins can access this page
Auth::checkAdminAccess();

$db = new Database();
$conn = $db->connect();
$developerObj = new Developer($conn);

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                // Handle image upload
                $image = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../assets/images/';
                    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $fileName = 'developer_' . uniqid() . '.' . $fileExtension;
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $image = $fileName;
                    }
                }
                
                $data = [
                    'name' => $_POST['name'],
                    'position' => $_POST['position'],
                    'bio' => $_POST['bio'],
                    'image' => $image,
                    'email' => $_POST['email'],
                    'github' => $_POST['github'],
                    'linkedin' => $_POST['linkedin'],
                    'order_position' => $_POST['order_position'],
                    'status' => $_POST['status']
                ];
                
                if ($developerObj->create($data)) {
                    $message = 'Developer added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding developer.';
                    $messageType = 'error';
                }
                break;
                
            case 'update':
                $data = [
                    'name' => $_POST['name'],
                    'position' => $_POST['position'],
                    'bio' => $_POST['bio'],
                    'email' => $_POST['email'],
                    'github' => $_POST['github'],
                    'linkedin' => $_POST['linkedin'],
                    'order_position' => $_POST['order_position'],
                    'status' => $_POST['status']
                ];
                
                // Handle image upload if new image is provided
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../assets/images/';
                    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $fileName = 'developer_' . uniqid() . '.' . $fileExtension;
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $data['image'] = $fileName;
                        
                        // Delete old image if exists
                        $oldDeveloper = $developerObj->getById($_POST['developer_id']);
                        if ($oldDeveloper && !empty($oldDeveloper['image'])) {
                            $oldImagePath = $uploadDir . $oldDeveloper['image'];
                            if (file_exists($oldImagePath) && $oldDeveloper['image'] !== 'noelv.jpg' && 
                                $oldDeveloper['image'] !== 'lanceb.jpg' && $oldDeveloper['image'] !== 'lewisg.jpeg') {
                                unlink($oldImagePath);
                            }
                        }
                    }
                }
                
                if ($developerObj->update($_POST['developer_id'], $data)) {
                    $message = 'Developer updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating developer.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete':
                $imageFile = $developerObj->delete($_POST['developer_id']);
                
                if ($imageFile) {
                    $message = 'Developer deleted successfully!';
                    $messageType = 'success';
                    
                    // Delete image file if it's not one of the original images
                    if (!empty($imageFile) && $imageFile !== 'noelv.jpg' && 
                        $imageFile !== 'lanceb.jpg' && $imageFile !== 'lewisg.jpeg') {
                        $imagePath = '../assets/images/' . $imageFile;
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                } else {
                    $message = 'Error deleting developer.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get all developers
$developers = $developerObj->getAll();

// Get developer for editing if ID is provided
$editDeveloper = null;
if (isset($_GET['edit'])) {
    $editDeveloper = $developerObj->getById($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Developers - TRIV Admin</title>
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
        
        .header { background: white; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 25px; border-radius: 12px; border-left: 4px solid #007bff; }
        .header h1 { color: #333; font-size: 1.8em; margin-bottom: 5px; }
        .header p { color: #666; font-size: 1em; }
        
        .message { padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .message.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        .form-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .form-container h2 { margin-bottom: 20px; color: #333; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        
        .btn { display: inline-block; padding: 12px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 14px; transition: all 0.3s ease; }
        .btn:hover { background: #0056b3; transform: translateY(-2px); }
        .btn.btn-success { background: #28a745; }
        .btn.btn-success:hover { background: #1e7e34; }
        .btn.btn-danger { background: #dc3545; }
        .btn.btn-danger:hover { background: #c82333; }
        .btn.btn-secondary { background: #6c757d; }
        .btn.btn-secondary:hover { background: #545b62; }
        
        .table-container { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .table th { background: #f8f9fa; font-weight: 600; color: #333; }
        .table tr:hover { background: #f8f9fa; }
        
        .status-badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        
        .actions { display: flex; gap: 10px; }
        .actions .btn { padding: 6px 12px; font-size: 12px; }
        
        .preview-image { max-width: 100px; max-height: 100px; margin-top: 10px; border-radius: 5px; }
        
        @media (max-width: 768px) {
            body { flex-direction: column; }
            aside { width: 100%; }
            .form-row { grid-template-columns: 1fr; }
        }

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
        <div class="header">
            <h1><i class="fas fa-code"></i> Manage Developers</h1>
            <p>Add, edit, and manage developers displayed on the About Us page</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Developer Form -->
        <div class="form-container">
            <h2><?= $editDeveloper ? 'Edit Developer' : 'Add New Developer' ?></h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?= $editDeveloper ? 'update' : 'create' ?>">
                <?php if ($editDeveloper): ?>
                    <input type="hidden" name="developer_id" value="<?= $editDeveloper['id'] ?>">
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" value="<?= $editDeveloper ? htmlspecialchars($editDeveloper['name']) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="position">Position *</label>
                        <input type="text" id="position" name="position" value="<?= $editDeveloper ? htmlspecialchars($editDeveloper['position']) : '' ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio"><?= $editDeveloper ? htmlspecialchars($editDeveloper['bio']) : '' ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="image">Profile Image <?= $editDeveloper ? '(Leave empty to keep current image)' : '' ?></label>
                        <input type="file" id="image" name="image" accept="image/*" <?= $editDeveloper ? '' : 'required' ?>>
                        <?php if ($editDeveloper && !empty($editDeveloper['image'])): ?>
                            <p style="margin-top: 5px;">Current image:</p>
                            <img src="../assets/images/<?= htmlspecialchars($editDeveloper['image']) ?>" alt="Current profile" class="preview-image">
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="order_position">Display Order</label>
                        <input type="number" id="order_position" name="order_position" value="<?= $editDeveloper ? htmlspecialchars($editDeveloper['order_position']) : '0' ?>" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= $editDeveloper ? htmlspecialchars($editDeveloper['email']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="active" <?= $editDeveloper && $editDeveloper['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $editDeveloper && $editDeveloper['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="github">GitHub Username</label>
                        <input type="text" id="github" name="github" value="<?= $editDeveloper ? htmlspecialchars($editDeveloper['github']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="linkedin">LinkedIn Username</label>
                        <input type="text" id="linkedin" name="linkedin" value="<?= $editDeveloper ? htmlspecialchars($editDeveloper['linkedin']) : '' ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> <?= $editDeveloper ? 'Update Developer' : 'Add Developer' ?>
                    </button>
                    <?php if ($editDeveloper): ?>
                        <a href="manage-developers.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Developers Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($developers as $developer): ?>
                        <tr>
                            <td>
                                <?php if (!empty($developer['image'])): ?>
                                    <img src="../assets/images/<?= htmlspecialchars($developer['image']) ?>" alt="<?= htmlspecialchars($developer['name']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                    <div style="width: 50px; height: 50px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user" style="color: #aaa;"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($developer['name']) ?></td>
                            <td><?= htmlspecialchars($developer['position']) ?></td>
                            <td><?= $developer['order_position'] ?></td>
                            <td>
                                <span class="status-badge status-<?= $developer['status'] ?>">
                                    <?= ucfirst($developer['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="?edit=<?= $developer['id'] ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this developer?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="developer_id" value="<?= $developer['id'] ?>">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Preview image before upload
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Remove any existing preview
                            const existingPreview = document.querySelector('.preview-image-new');
                            if (existingPreview) {
                                existingPreview.remove();
                            }
                            
                            // Create new preview
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = 'Image preview';
                            img.className = 'preview-image preview-image-new';
                            imageInput.parentNode.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</body>
</html>