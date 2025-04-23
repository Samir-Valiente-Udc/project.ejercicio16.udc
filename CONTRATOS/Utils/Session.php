<?php
namespace Utils;

class Session {
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    public static function delete($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }
    
    public static function destroy() {
        self::start();
        session_destroy();
    }
    
    public static function setFlash($key, $message) {
        self::start();
        $_SESSION['_flash'][$key] = $message;
    }
    
    public static function getFlash($key, $default = null) {
        self::start();
        $value = isset($_SESSION['_flash'][$key]) ? $_SESSION['_flash'][$key] : $default;
        if (isset($_SESSION['_flash'][$key])) {
            unset($_SESSION['_flash'][$key]);
        }
        return $value;
    }
    
    public static function hasFlash($key) {
        self::start();
        return isset($_SESSION['_flash'][$key]);
    }
    
    public static function isLoggedIn() {
        return self::get('user_id') !== null;
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: login.php');
            exit;
        }
    }
}