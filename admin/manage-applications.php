<?php
require_once '../classes/Database.php';
require_once '../classes/Auth.php';

// Ensure only admins can access this page
Auth::checkAdminAccess();

$db = new Database();
$conn = $db->connect();
$jobApplication = new JobApplication($conn);
$job = new Job($conn);

$message = '';
$messageType = '';

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_status':
                if ($jobApplication->updateStatus($_POST['application_id'], $_POST['status'], $_POST['notes'])) {
                    $message = 'Application status updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating application status.';
                    $messageType = 'error';
                }
                break;
                
            case 'delete':
                if ($jobApplication->delete($_POST['application_id'])) {
                    $message = 'Application deleted successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error deleting application.';
                    $messageType = 'error';
                }
                break;
        }
    }
}

// Get all applications
$applications = $jobApplication->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications - TRIV Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        body { display: flex; height: 100vh; background: #f4f6f8; }
        
        aside { width: 250px; background: #20232a; color: white; padding: 20px; box-shadow: 2px 0 5px rgba(0,0,0,0.1); }
        aside h2 { margin-bottom: 30px; text-align: center; color: #61dafb; font-size: 1.5em; }
        aside ul { list-style: none; }
        aside ul li { margin: 15px 0; }
        aside ul li a { color: white; text-decoration: none; display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; transition: all 0.3s ease; }
        aside ul li a:hover { background: rgba(97, 218, 251, 0.1); transform: translateX(5px); }
        aside ul li a i { margin-right: 12px; width: 20px; text-align: center; }
        aside ul li a.active { background: #007bff; box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3); }
        
        main { flex: 1; padding: 20px; overflow-y: auto; }
        
        .header { background: white; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 25px; border-radius: 12px; border-left: 4px solid #007bff; }
        .header h1 { color: #333; font-size: 1.8em; margin-bottom: 5px; }
        .header p { color: #666; font-size: 1em; }
        
        .message { padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .message.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        .btn { display: inline-block; padding: 10px 16px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 14px; transition: all 0.3s ease; }
        .btn:hover { background: #0056b3; transform: translateY(-2px); }
        .btn.btn-success { background: #28a745; }
        .btn.btn-success:hover { background: #1e7e34; }
        .btn.btn-danger { background: #dc3545; }
        .btn.btn-danger:hover { background: #c82333; }
        
        .table-container { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        .table th { background: #f8f9fa; font-weight: 600; color: #333; }
        .table tr:hover { background: #f8f9fa; }
        
        .status-badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-reviewing { background: #cce5ff; color: #004085; }
        .status-shortlisted { background: #d1ecf1; color: #0c5460; }
        .status-interviewed { background: #e2e3e5; color: #383d41; }
        .status-hired { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        
        .actions { display: flex; gap: 5px; }
        .actions .btn { padding: 5px 10px; font-size: 12px; }
        
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 5% auto; padding: 30px; width: 80%; max-width: 600px; border-radius: 12px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h2 { color: #333; }
        .close { font-size: 28px; font-weight: bold; cursor: pointer; color: #aaa; }
        .close:hover { color: #000; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
        .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
        
        @media (max-width: 768px) {
            body { flex-direction: column; }
            aside { width: 100%; }
            .modal-content { width: 95%; margin: 2% auto; }
        }
    </style>
</head>
<body>
    <aside>
        <h2><i class="fas fa-building"></i> TRIV Admin</h2>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="manage-jobs.php"><i class="fas fa-briefcase"></i> Jobs</a></li>
            <li><a href="manage-applications.php" class="active"><i class="fas fa-file-alt"></i> Applications</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <main>
        <div class="header">
            <h1><i class="fas fa-file-alt"></i> Manage Job Applications</h1>
            <p>Review and manage job applications</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Applications Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Job Position</th>
                        <th>Email</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th>Applied Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td><?= htmlspecialchars($application['first_name'] . ' ' . $application['last_name']) ?></td>
                            <td><?= htmlspecialchars($application['job_title'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($application['email']) ?></td>
                            <td><?= htmlspecialchars($application['experience']) ?></td>
                            <td>
                                <span class="status-badge status-<?= $application['status'] ?>">
                                    <?= ucfirst($application['status']) ?>
                                </span>
                            </td>
                            <td><?= date('M j, Y', strtotime($application['created_at'])) ?></td>
                            <td>
                                <div class="actions">
                                    <button onclick="updateStatus(<?= $application['id'] ?>, '<?= $application['status'] ?>')" class="btn btn-success">
                                        <i class="fas fa-edit"></i> Status
                                    </button>
                                    <?php if ($application['resume_file']): ?>
                                        <a href="../uploads/resumes/<?= $application['resume_file'] ?>" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-download"></i> Resume
                                        </a>
                                    <?php endif; ?>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this application?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="application_id" value="<?= $application['id'] ?>">
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

    <!-- Update Status Modal -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Application Status</h2>
                <span class="close" onclick="closeModal('statusModal')">&times;</span>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="application_id" id="statusApplicationId">
                
                <div class="form-group">
                    <label for="statusSelect">Status</label>
                    <select id="statusSelect" name="status">
                        <option value="pending">Pending</option>
                        <option value="reviewing">Reviewing</option>
                        <option value="shortlisted">Shortlisted</option>
                        <option value="interviewed">Interviewed</option>
                        <option value="hired">Hired</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="statusNotes">Notes (Optional)</label>
                    <textarea id="statusNotes" name="notes" rows="4"></textarea>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">Update Status</button>
                    <button type="button" onclick="closeModal('statusModal')" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateStatus(id, currentStatus) {
            document.getElementById('statusApplicationId').value = id;
            document.getElementById('statusSelect').value = currentStatus;
            document.getElementById('statusModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const statusModal = document.getElementById('statusModal');
            if (event.target === statusModal) {
                statusModal.style.display = 'none';
            }
        }
    </script>
</body>
</html>