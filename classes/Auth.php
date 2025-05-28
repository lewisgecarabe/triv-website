<?php
class Auth {
    private static $sessionStarted = false;

    public static function startSession() {
        if (!self::$sessionStarted && session_status() === PHP_SESSION_NONE) {
            // Configure session security
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.use_strict_mode', 1);
            
            session_start();
            self::$sessionStarted = true;
            
            // Regenerate session ID periodically for security
            if (!isset($_SESSION['last_regeneration'])) {
                self::regenerateSession();
            } elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutes
                self::regenerateSession();
            }
        }
    }

    private static function regenerateSession() {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }

    public static function login($userData, $remember = false) {
        self::startSession();
        
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_role'] = $userData['role'];
        $_SESSION['login_time'] = time();
        $_SESSION['last_activity'] = time();
        
        // Set remember me cookies if requested
        if ($remember) {
            $cookieExpire = time() + (86400 * 30); // 30 days
            setcookie('remember_user_id', $userData['id'], $cookieExpire, "/", "", isset($_SERVER['HTTPS']), true);
            setcookie('remember_user_token', self::generateRememberToken($userData['id']), $cookieExpire, "/", "", isset($_SERVER['HTTPS']), true);
        }
        
        self::regenerateSession();
    }

    public static function logout() {
        self::startSession();
        
        // Clear remember me cookies
        if (isset($_COOKIE['remember_user_id'])) {
            setcookie('remember_user_id', '', time() - 3600, "/");
            setcookie('remember_user_token', '', time() - 3600, "/");
        }
        
        // Clear session
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        header("Location: ../public/login.php");
        exit();
    }

    public static function isLoggedIn() {
        self::startSession();
        
        // Check if user is logged in via session
        if (isset($_SESSION['user_id']) && isset($_SESSION['last_activity'])) {
            // Check session timeout (30 minutes)
            if (time() - $_SESSION['last_activity'] > 1800) {
                self::logout();
                return false;
            }
            
            $_SESSION['last_activity'] = time();
            return true;
        }
        
        // Check remember me cookies
        if (isset($_COOKIE['remember_user_id']) && isset($_COOKIE['remember_user_token'])) {
            return self::validateRememberToken($_COOKIE['remember_user_id'], $_COOKIE['remember_user_token']);
        }
        
        return false;
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header("Location: ../public/login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
            exit();
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        
        if (!self::isAdmin()) {
            header("Location: ../public/index.php?error=access_denied");
            exit();
        }
    }

    public static function requireRole($requiredRole) {
        self::requireLogin();
        
        $userRole = self::getUserRole();
        if ($userRole !== $requiredRole) {
            if ($userRole === 'admin') {
                // Admins can access everything
                return true;
            }
            header("Location: ../public/index.php?error=insufficient_permissions");
            exit();
        }
    }

    public static function isAdmin() {
        return self::getUserRole() === 'admin';
    }

    public static function getUserId() {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    public static function getUserName() {
        self::startSession();
        return $_SESSION['user_name'] ?? null;
    }

    public static function getUserEmail() {
        self::startSession();
        return $_SESSION['user_email'] ?? null;
    }

    public static function getUserRole() {
        self::startSession();
        return $_SESSION['user_role'] ?? null;
    }

    public static function redirectBasedOnRole($role = null) {
        $role = $role ?? self::getUserRole();
        
        if ($role === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../public/index.php");
        }
        exit();
    }

    private static function generateRememberToken($userId) {
        return hash('sha256', $userId . time() . random_bytes(16));
    }

    private static function validateRememberToken($userId, $token) {
        // In a production environment, you should store and validate tokens in the database
        // For now, we'll do a basic validation and auto-login
        if (!empty($userId) && !empty($token)) {
            try {
                $db = new Database();
                $conn = $db->connect();
                $user = new User($conn);
                $userData = $user->getUserById($userId);
                
                if ($userData) {
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['user_name'] = $userData['name'];
                    $_SESSION['user_email'] = $userData['email'];
                    $_SESSION['user_role'] = $userData['role'];
                    $_SESSION['login_time'] = time();
                    $_SESSION['last_activity'] = time();
                    return true;
                }
            } catch (Exception $e) {
                error_log("Remember token validation error: " . $e->getMessage());
            }
        }
        
        return false;
    }

    public static function checkAdminAccess() {
        // This method can be called at the top of admin pages
        self::requireAdmin();
    }

    public static function getLoginRedirectUrl() {
        if (isset($_GET['redirect'])) {
            return urldecode($_GET['redirect']);
        }
        return null;
    }
}
?>