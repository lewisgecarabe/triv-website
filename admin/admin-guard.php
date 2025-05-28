<?php
// Include this file at the top of any admin page to protect it
require_once '../classes/Database.php';
require_once '../classes/Auth.php';

// Ensure only admins can access admin pages
Auth::checkAdminAccess();

// Optional: You can also add additional security checks here
// For example, checking IP whitelist, additional permissions, etc.
?>