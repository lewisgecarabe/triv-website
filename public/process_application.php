<?php
require_once '../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: career.php');
    exit;
}

$db = new Database();
$conn = $db->connect();
$jobApplication = new JobApplication($conn);

// Handle file upload
$resumeFile = null;
if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/resumes/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Validate file type
    $allowedTypes = ['application/pdf'];
    $fileType = $_FILES['resume']['type'];
    
    if (!in_array($fileType, $allowedTypes)) {
        header('Location: career_apply.php?job_id=' . $_POST['job_id'] . '&error=invalid_file');
        exit;
    }
    
    // Validate file size (5MB max)
    if ($_FILES['resume']['size'] > 5 * 1024 * 1024) {
        header('Location: career_apply.php?job_id=' . $_POST['job_id'] . '&error=file_too_large');
        exit;
    }
    
    $fileExtension = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
    $uploadPath = $uploadDir . $fileName;
    
    if (move_uploaded_file($_FILES['resume']['tmp_name'], $uploadPath)) {
        $resumeFile = $fileName;
    } else {
        header('Location: career_apply.php?job_id=' . $_POST['job_id'] . '&error=upload_failed');
        exit;
    }
}

// Prepare application data
$applicationData = [
    'job_id' => (int)$_POST['job_id'],
    'first_name' => trim($_POST['first_name']),
    'last_name' => trim($_POST['last_name']),
    'email' => trim($_POST['email']),
    'phone' => trim($_POST['phone']),
    'address' => trim($_POST['address']),
    'resume_file' => $resumeFile,
    'portfolio_url' => !empty($_POST['portfolio']) ? trim($_POST['portfolio']) : null,
    'linkedin_url' => !empty($_POST['linkedin']) ? trim($_POST['linkedin']) : null,
    'experience' => $_POST['experience'],
    'cover_letter' => trim($_POST['cover_letter']),
    'start_date' => $_POST['start_date'],
    'expected_salary' => !empty($_POST['salary']) ? trim($_POST['salary']) : null,
    'referral_source' => !empty($_POST['referral']) ? $_POST['referral'] : null,
    'status' => 'pending'
];

// Validate required fields
$requiredFields = ['job_id', 'first_name', 'last_name', 'email', 'phone', 'address', 'experience', 'cover_letter', 'start_date'];
foreach ($requiredFields as $field) {
    if (empty($applicationData[$field])) {
        header('Location: career_apply.php?job_id=' . $_POST['job_id'] . '&error=missing_fields');
        exit;
    }
}

// Validate email format
if (!filter_var($applicationData['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: career_apply.php?job_id=' . $_POST['job_id'] . '&error=invalid_email');
    exit;
}

// Check if resume was uploaded
if (!$resumeFile) {
    header('Location: career_apply.php?job_id=' . $_POST['job_id'] . '&error=no_resume');
    exit;
}

// Save application to database
if ($jobApplication->create($applicationData)) {
    // Redirect with success message
    header('Location: career_apply.php?job_id=' . $_POST['job_id'] . '&success=1');
} else {
    // Redirect with error message
    header('Location: career_apply.php?job_id=' . $_POST['job_id'] . '&error=database_error');
}
exit;
?>