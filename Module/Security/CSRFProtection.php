<?php
/**
 * CSRF Protection Class
 * Generates and validates CSRF tokens
 */

class CSRFProtection {
    
    /**
     * Generate CSRF token
     */
    public static function generateToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Get CSRF token for forms
     */
    public static function getTokenField() {
        $token = self::generateToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
    
    /**
     * Validate CSRF token
     */
    public static function validateToken($token = null) {
        if ($token === null) {
            $token = $_POST['csrf_token'] ?? '';
        }
        
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Validate token and die if invalid
     */
    public static function validateOrDie($token = null) {
        if (!self::validateToken($token)) {
            http_response_code(403);
            die('CSRF token validation failed. Please try again.');
        }
    }
    
    /**
     * Get token for AJAX requests
     */
    public static function getTokenForAjax() {
        return [
            'name' => 'csrf_token',
            'value' => self::generateToken()
        ];
    }
}