<?php
require_once '../classes/Database.php';
require_once '../classes/Auth.php';

// Ensure only admins can access this page
Auth::checkAdminAccess();

$db = new Database();
$conn = $db->connect();

$contactInquiry = new ContactInquiry($conn);
$message = '';
$messageType = '';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $inquiryId = $_POST['inquiry_id'] ?? '';

    switch ($action) {
        case 'update_status':
            $status = $_POST['status'] ?? '';
            if ($contactInquiry->updateStatus($inquiryId, $status)) {
                $message = "Status updated successfully!";
                $messageType = 'success';
            } else {
                $message = "Failed to update status.";
                $messageType = 'error';
            }
            break;

        case 'delete':
            if ($contactInquiry->delete($inquiryId)) {
                $message = "Inquiry deleted successfully!";
                $messageType = 'success';
            } else {
                $message = "Failed to delete inquiry.";
                $messageType = 'error';
            }
            break;
    }
}

$inquiries = $contactInquiry->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inquiries - TRIV Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .inquiries-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .inquiry-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .inquiry-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: between;
            align-items: center;
        }
        .inquiry-info {
            flex: 1;
        }
        .inquiry-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-in-progress {
            background: #cce5ff;
            color: #004085;
        }
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        .inquiry-body {
            padding: 20px;
        }
        .inquiry-actions {
            padding: 15px 20px;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9em;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .file-link {
            color: #007bff;
            text-decoration: none;
        }
        .file-link:hover {
            text-decoration: underline;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #007bff;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="inquiries-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1>Contact Inquiries Management</h1>
            <a href="dashboard.php" class="btn btn-primary">← Back to Dashboard</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="stats-grid">
            <?php
            $totalInquiries = count($inquiries);
            $pendingInquiries = count(array_filter($inquiries, fn($i) => $i['status'] === 'pending'));
            $completedInquiries = count(array_filter($inquiries, fn($i) => $i['status'] === 'completed'));
            ?>
            <div class="stat-card">
                <div class="stat-number"><?= $totalInquiries ?></div>
                <div>Total Inquiries</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $pendingInquiries ?></div>
                <div>Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $completedInquiries ?></div>
                <div>Completed</div>
            </div>
        </div>

        <!-- Inquiries List -->
        <?php if (empty($inquiries)): ?>
            <div class="inquiry-card">
                <div class="inquiry-body">
                    <p style="text-align: center; color: #666; margin: 40px 0;">No inquiries found.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($inquiries as $inquiry): ?>
                <div class="inquiry-card">
                    <div class="inquiry-header">
                        <div class="inquiry-info">
                            <strong><?= htmlspecialchars($inquiry['name']) ?></strong>
                            <span style="color: #666; margin-left: 10px;">
                                <?= htmlspecialchars($inquiry['email']) ?>
                            </span>
                            <span style="color: #666; margin-left: 10px;">
                                <?= htmlspecialchars($inquiry['mobile']) ?>
                            </span>
                        </div>
                        <div>
                            <span class="inquiry-status status-<?= $inquiry['status'] ?>">
                                <?= ucfirst($inquiry['status']) ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="inquiry-body">
                        <div style="margin-bottom: 15px;">
                            <strong>User:</strong> <?= htmlspecialchars($inquiry['user_name'] ?? 'Unknown') ?>
                            <span style="color: #666;">(<?= htmlspecialchars($inquiry['user_email'] ?? 'No email') ?>)</span>
                        </div>
                        
                        <div style="margin-bottom: 15px;">
                            <strong>Message:</strong><br>
                            <?= nl2br(htmlspecialchars($inquiry['message'])) ?>
                        </div>
                        
                        <?php if ($inquiry['plan_file']): ?>
                            <div style="margin-bottom: 15px;">
                                <strong>Attached Plan:</strong>
                                <a href="../uploads/plans/<?= htmlspecialchars($inquiry['plan_file']) ?>" 
                                   target="_blank" class="file-link">
                                    📎 <?= htmlspecialchars($inquiry['plan_file']) ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div style="color: #666; font-size: 0.9em;">
                            <strong>Submitted:</strong> <?= date('M j, Y g:i A', strtotime($inquiry['created_at'])) ?>
                            <?php if ($inquiry['updated_at']): ?>
                                <br><strong>Last Updated:</strong> <?= date('M j, Y g:i A', strtotime($inquiry['updated_at'])) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="inquiry-actions">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="inquiry_id" value="<?= $inquiry['id'] ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" <?= $inquiry['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="in-progress" <?= $inquiry['status'] === 'in-progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="completed" <?= $inquiry['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= $inquiry['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </form>
                        
                        <a href="mailto:<?= htmlspecialchars($inquiry['email']) ?>?subject=Re: Your Inquiry&body=Dear <?= htmlspecialchars($inquiry['name']) ?>,%0A%0AThank you for your inquiry..." 
                           class="btn btn-success">Reply via Email</a>
                        
                        <form method="POST" style="display: inline;" 
                              onsubmit="return confirm('Are you sure you want to delete this inquiry?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="inquiry_id" value="<?= $inquiry['id'] ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>