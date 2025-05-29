<?php
require_once '../classes/Auth.php';
require_once '../classes/Database.php';

// Ensure only admins can access this page
Auth::checkAdminAccess();

$db = new Database();
$conn = $db->connect();
$userObj = new User($conn);

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => $_POST['password'],
                    'role' => $_POST['role'],
                    'status' => $_POST['status']
                ];
                
                // Validate required fields
                if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                    $message = 'Please fill in all required fields.';
                    $messageType = 'error';
                } elseif (strlen($data['password']) < 6) {
                    $message = 'Password must be at least 6 characters long.';
                    $messageType = 'error';
                } elseif ($userObj->emailExists($data['email'])) {
                    $message = 'Email address already exists.';
                    $messageType = 'error';
                } elseif ($userObj->create($data)) {
                    $message = 'User created successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error creating user.';
                    $messageType = 'error';
                }
                break;
                
            case 'update':
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => $_POST['password'], // Can be empty
                    'role' => $_POST['role'],
                    'status' => $_POST['status']
                ];
                
                // Validate required fields
                if (empty($data['name']) || empty($data['email'])) {
                    $message = 'Please fill in all required fields.';
                    $messageType = 'error';
                } elseif (!empty($data['password']) && strlen($data['password']) < 6) {
                    $message = 'Password must be at least 6 characters long.';
                    $messageType = 'error';
                } elseif ($userObj->emailExists($data['email'], $_POST['user_id'])) {
                    $message = 'Email address already exists.';
                    $messageType = 'error';
                } elseif ($userObj->update($_POST['user_id'], $data)) {
                    $message = 'User updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating user. Cannot modify the last admin.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete':
                if ($userObj->delete($_POST['user_id'])) {
                    $message = 'User deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting user. Cannot delete the last admin.';
                    $messageType = 'error';
                }
                break;
                
            case 'update_status':
                if ($userObj->updateStatus($_POST['user_id'], $_POST['status'])) {
                    $message = 'User status updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating user status.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Handle search and filters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$roleFilter = isset($_GET['role']) ? $_GET['role'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Get users based on filters
if (!empty($search)) {
    $users = $userObj->searchUsers($search);
} elseif (!empty($roleFilter)) {
    $users = $userObj->getUsersByRole($roleFilter);
} elseif (!empty($statusFilter)) {
    $users = $userObj->getUsersByStatus($statusFilter);
} else {
    $users = $userObj->getAllUsers();
}

// Get user for editing if ID is provided
$editUser = null;
if (isset($_GET['edit'])) {
    $editUser = $userObj->getUserById($_GET['edit']);
}

// Get statistics
$totalUsers = $userObj->getCount();
$adminCount = $userObj->getAdminCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - TRIV Admin</title>
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
        
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        .stat-card h3 { color: #333; margin-bottom: 10px; }
        .stat-card .number { font-size: 2em; font-weight: bold; color: #007bff; }
        
        .message { padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .message.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        .controls { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px; }
        .controls-row { display: grid; grid-template-columns: 1fr auto auto; gap: 15px; align-items: end; }
        .search-group { display: flex; gap: 10px; }
        .search-group input { flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
        .filter-group { display: flex; gap: 10px; }
        
        .form-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .form-container h2 { margin-bottom: 20px; color: #333; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        
        .btn { display: inline-block; padding: 12px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 14px; transition: all 0.3s ease; }
        .btn:hover { background: #0056b3; transform: translateY(-2px); }
        .btn.btn-success { background: #28a745; }
        .btn.btn-success:hover { background: #1e7e34; }
        .btn.btn-danger { background: #dc3545; }
        .btn.btn-danger:hover { background: #c82333; }
        .btn.btn-secondary { background: #6c757d; }
        .btn.btn-secondary:hover { background: #545b62; }
        .btn.btn-warning { background: #ffc107; color: #212529; }
        .btn.btn-warning:hover { background: #e0a800; }
        
        .table-container { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .table th { background: #f8f9fa; font-weight: 600; color: #333; }
        .table tr:hover { background: #f8f9fa; }
        
        .status-badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        
        .role-badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .role-admin { background: #fff3cd; color: #856404; }
        .role-client { background: #d1ecf1; color: #0c5460; }
        
        .actions { display: flex; gap: 5px; }
        .actions .btn { padding: 6px 12px; font-size: 12px; }
        
        .quick-actions { display: flex; gap: 5px; margin-bottom: 10px; }
        .quick-actions .btn { padding: 4px 8px; font-size: 11px; }
        
        @media (max-width: 768px) {
            body { flex-direction: column; }
            aside { width: 100%; }
            .form-row, .controls-row { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: 1fr; }
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
            <h1><i class="fas fa-users"></i> Manage Users</h1>
            <p>Add, edit, and manage user accounts and permissions</p>
        </div>

        <!-- Statistics -->
        <div class="stats-row">
            <div class="stat-card">
                <h3><i class="fas fa-users"></i> Total Users</h3>
                <div class="number"><?= $totalUsers ?></div>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-user-shield"></i> Administrators</h3>
                <div class="number"><?= $adminCount ?></div>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-user-check"></i> Active Users</h3>
                <div class="number"><?= count(array_filter($users, function($u) { return $u['status'] === 'active'; })) ?></div>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Search and Filter Controls -->
        <div class="controls">
            <div class="controls-row">
                <div class="search-group">
                    <input type="text" id="searchInput" placeholder="Search users by name or email..." value="<?= htmlspecialchars($search) ?>">
                    <button type="button" onclick="performSearch()" class="btn">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
                <div class="filter-group">
                    <select id="roleFilter" onchange="applyFilter()">
                        <option value="">All Roles</option>
                        <option value="admin" <?= $roleFilter === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="client" <?= $roleFilter === 'client' ? 'selected' : '' ?>>Client</option>
                    </select>
                    <select id="statusFilter" onchange="applyFilter()">
                        <option value="">All Status</option>
                        <option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $statusFilter === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div>
                    <button type="button" onclick="clearFilters()" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            </div>
        </div>

        <!-- User Form -->
        <div class="form-container">
            <h2><?= $editUser ? 'Edit User' : 'Add New User' ?></h2>
            <form method="POST">
                <input type="hidden" name="action" value="<?= $editUser ? 'update' : 'create' ?>">
                <?php if ($editUser): ?>
                    <input type="hidden" name="user_id" value="<?= $editUser['id'] ?>">
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="<?= $editUser ? htmlspecialchars($editUser['name']) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="<?= $editUser ? htmlspecialchars($editUser['email']) : '' ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password <?= $editUser ? '(Leave empty to keep current)' : '*' ?></label>
                        <input type="password" id="password" name="password" <?= $editUser ? '' : 'required' ?> minlength="6">
                        <small style="color: #666;">Minimum 6 characters</small>
                    </div>
                    <div class="form-group">
                        <label for="role">Role *</label>
                        <select id="role" name="role" required>
                            <option value="client" <?= $editUser && $editUser['role'] === 'client' ? 'selected' : '' ?>>Client</option>
                            <option value="admin" <?= $editUser && $editUser['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="active" <?= $editUser && $editUser['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $editUser && $editUser['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> <?= $editUser ? 'Update User' : 'Create User' ?>
                    </button>
                    <?php if ($editUser): ?>
                        <a href="manage-users.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                <i class="fas fa-users" style="font-size: 2em; margin-bottom: 10px; display: block;"></i>
                                No users found
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($user['name']) ?></strong>
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <i class="fas fa-crown" style="color: #ffc107; margin-left: 5px;" title="Administrator"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="role-badge role-<?= $user['role'] ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?= $user['status'] ?>">
                                        <?= ucfirst($user['status']) ?>
                                    </span>
                                </td>
                                <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <?= $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?>
                                </td>
                                <td>
                                    <div class="quick-actions">
                                        <?php if ($user['status'] === 'active'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <input type="hidden" name="status" value="inactive">
                                                <button type="submit" class="btn btn-warning" title="Deactivate">
                                                    <i class="fas fa-pause"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="btn btn-success" title="Activate">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <div class="actions">
                                        <a href="?edit=<?= $user['id'] ?>" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <?php if ($adminCount > 1 || $user['role'] !== 'admin'): ?>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-danger" disabled title="Cannot delete the last administrator">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function performSearch() {
            const search = document.getElementById('searchInput').value;
            const url = new URL(window.location);
            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }
            // Clear other filters when searching
            url.searchParams.delete('role');
            url.searchParams.delete('status');
            window.location = url;
        }

        function applyFilter() {
            const role = document.getElementById('roleFilter').value;
            const status = document.getElementById('statusFilter').value;
            const url = new URL(window.location);
            
            // Clear search when filtering
            url.searchParams.delete('search');
            
            if (role) {
                url.searchParams.set('role', role);
            } else {
                url.searchParams.delete('role');
            }
            
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            
            window.location = url;
        }

        function clearFilters() {
            window.location = 'manage-users.php';
        }

        // Allow Enter key to trigger search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // Auto-focus search input if there's a search term
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput.value) {
                searchInput.focus();
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }
        });
    </script>
</body>
</html>