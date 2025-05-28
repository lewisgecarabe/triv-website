<?php
require_once '../classes/Auth.php';
require_once '../classes/Database.php';

// Ensure only admins can access this page
Auth::checkAdminAccess();

$db = new Database();
$conn = $db->connect();
$job = new Job($conn);

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $data = [
                    'title' => $_POST['title'],
                    'department' => $_POST['department'],
                    'location' => $_POST['location'],
                    'employment_type' => $_POST['employment_type'],
                    'description' => $_POST['description'],
                    'responsibilities' => $_POST['responsibilities'],
                    'qualifications' => $_POST['qualifications'],
                    'schedule' => $_POST['schedule'],
                    'benefits' => $_POST['benefits'],
                    'salary_range' => $_POST['salary_range'],
                    'status' => $_POST['status']
                ];
                
                if ($job->create($data)) {
                    $message = 'Job created successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error creating job.';
                    $messageType = 'error';
                }
                break;
                
            case 'update':
                $data = [
                    'title' => $_POST['title'],
                    'department' => $_POST['department'],
                    'location' => $_POST['location'],
                    'employment_type' => $_POST['employment_type'],
                    'description' => $_POST['description'],
                    'responsibilities' => $_POST['responsibilities'],
                    'qualifications' => $_POST['qualifications'],
                    'schedule' => $_POST['schedule'],
                    'benefits' => $_POST['benefits'],
                    'salary_range' => $_POST['salary_range'],
                    'status' => $_POST['status']
                ];
                
                if ($job->update($_POST['job_id'], $data)) {
                    $message = 'Job updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating job.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete':
                if ($job->delete($_POST['job_id'])) {
                    $message = 'Job deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting job.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get all jobs
$jobs = $job->getAll();

// Get job for editing if ID is provided
$editJob = null;
if (isset($_GET['edit'])) {
    $editJob = $job->getById($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs - TRIV Admin</title>
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
        .status-closed { background: #e2e3e5; color: #383d41; }
        
        .actions { display: flex; gap: 10px; }
        .actions .btn { padding: 6px 12px; font-size: 12px; }
        
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
            <h1><i class="fas fa-briefcase"></i> Manage Jobs</h1>
            <p>Create, edit, and manage job postings</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Job Form -->
        <div class="form-container">
            <h2><?= $editJob ? 'Edit Job' : 'Create New Job' ?></h2>
            <form method="POST">
                <input type="hidden" name="action" value="<?= $editJob ? 'update' : 'create' ?>">
                <?php if ($editJob): ?>
                    <input type="hidden" name="job_id" value="<?= $editJob['id'] ?>">
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Job Title *</label>
                        <input type="text" id="title" name="title" value="<?= $editJob ? htmlspecialchars($editJob['title']) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="department">Department *</label>
                        <select id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Architecture" <?= $editJob && $editJob['department'] === 'Architecture' ? 'selected' : '' ?>>Architecture</option>
                            <option value="Engineering" <?= $editJob && $editJob['department'] === 'Engineering' ? 'selected' : '' ?>>Engineering</option>
                            <option value="Construction" <?= $editJob && $editJob['department'] === 'Construction' ? 'selected' : '' ?>>Construction</option>
                            <option value="Interior Design" <?= $editJob && $editJob['department'] === 'Interior Design' ? 'selected' : '' ?>>Interior Design</option>
                            <option value="Administration" <?= $editJob && $editJob['department'] === 'Administration' ? 'selected' : '' ?>>Administration</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="location">Location *</label>
                        <input type="text" id="location" name="location" value="<?= $editJob ? htmlspecialchars($editJob['location']) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="employment_type">Employment Type *</label>
                        <select id="employment_type" name="employment_type" required>
                            <option value="full-time" <?= $editJob && $editJob['employment_type'] === 'full-time' ? 'selected' : '' ?>>Full-time</option>
                            <option value="part-time" <?= $editJob && $editJob['employment_type'] === 'part-time' ? 'selected' : '' ?>>Part-time</option>
                            <option value="contract" <?= $editJob && $editJob['employment_type'] === 'contract' ? 'selected' : '' ?>>Contract</option>
                            <option value="internship" <?= $editJob && $editJob['employment_type'] === 'internship' ? 'selected' : '' ?>>Internship</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Job Description *</label>
                    <textarea id="description" name="description" required><?= $editJob ? htmlspecialchars($editJob['description']) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="responsibilities">Responsibilities *</label>
                    <textarea id="responsibilities" name="responsibilities" required><?= $editJob ? htmlspecialchars($editJob['responsibilities']) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="qualifications">Qualifications *</label>
                    <textarea id="qualifications" name="qualifications" required><?= $editJob ? htmlspecialchars($editJob['qualifications']) : '' ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="schedule">Work Schedule</label>
                        <input type="text" id="schedule" name="schedule" value="<?= $editJob ? htmlspecialchars($editJob['schedule']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="salary_range">Salary Range</label>
                        <input type="text" id="salary_range" name="salary_range" value="<?= $editJob ? htmlspecialchars($editJob['salary_range']) : '' ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="benefits">Benefits</label>
                        <textarea id="benefits" name="benefits"><?= $editJob ? htmlspecialchars($editJob['benefits']) : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="active" <?= $editJob && $editJob['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $editJob && $editJob['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="closed" <?= $editJob && $editJob['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> <?= $editJob ? 'Update Job' : 'Create Job' ?>
                    </button>
                    <?php if ($editJob): ?>
                        <a href="manage-jobs.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Jobs Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Department</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jobs as $jobItem): ?>
                        <tr>
                            <td><?= htmlspecialchars($jobItem['title']) ?></td>
                            <td><?= htmlspecialchars($jobItem['department']) ?></td>
                            <td><?= htmlspecialchars($jobItem['location']) ?></td>
                            <td><?= ucfirst($jobItem['employment_type']) ?></td>
                            <td>
                                <span class="status-badge status-<?= $jobItem['status'] ?>">
                                    <?= ucfirst($jobItem['status']) ?>
                                </span>
                            </td>
                            <td><?= date('M j, Y', strtotime($jobItem['created_at'])) ?></td>
                            <td>
                                <div class="actions">
                                    <a href="?edit=<?= $jobItem['id'] ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this job?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="job_id" value="<?= $jobItem['id'] ?>">
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
</body>
</html>