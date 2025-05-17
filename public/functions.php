<?php
// Process contact form
function processContactForm() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        
        // Validate inputs
        $errors = [];
        
        if (empty($name)) {
            $errors[] = "Name is required";
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required";
        }
        
        if (empty($message)) {
            $errors[] = "Message is required";
        }
        
        // If no errors, process the form
        if (empty($errors)) {
            // In a real application, you would:
            // 1. Send an email
            // 2. Store in database
            // 3. Log the inquiry
            
            return [
                'success' => true,
                'message' => "Thank you for contacting us, $name! We will get back to you soon."
            ];
        } else {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }
    }
    
    return null;
}

// Display contact form results
function displayContactFormResults() {
    $result = processContactForm();
    
    if ($result) {
        if ($result['success']) {
            echo '<div class="success-message">' . $result['message'] . '</div>';
        } else {
            echo '<div class="error-message"><ul>';
            foreach ($result['errors'] as $error) {
                echo '<li>' . $error . '</li>';
            }
            echo '</ul></div>';
        }
    }
}