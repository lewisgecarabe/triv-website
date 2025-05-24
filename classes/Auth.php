<?php
class Auth {
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header("Location: ../public/login.php");
            exit();
        }
    }

public static function requireRole($role) {
    self::startSession();
    
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: ../public/login.php");
        exit();
    }
}



    public static function getUserId() {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    public static function getUserRole() {
        self::startSession();
        return $_SESSION['role'] ?? null;
    }

    public static function logout() {
        self::startSession();
        session_unset();
        session_destroy();
        header("Location: ../public/login.php");
        exit();
    }
}
