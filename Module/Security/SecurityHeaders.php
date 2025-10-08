<?php
/**
 * Security Headers Configuration
 * Implements security headers to prevent various attacks
 */

class SecurityHeaders {
    
    /**
     * Set all security headers
     */
    public static function setSecurityHeaders() {
        // Prevent clickjacking
        header('X-Frame-Options: DENY');
        
        // Enable XSS Protection
        header('X-XSS-Protection: 1; mode=block');
        
        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');
        
        // HSTS - Force HTTPS for 1 year
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }
        
        // Content Security Policy
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://cdn.jsdelivr.net; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://use.fontawesome.com https://unpkg.com; " .
               "font-src 'self' https://fonts.gstatic.com https://use.fontawesome.com; " .
               "img-src 'self' data: https:; " .
               "connect-src 'self' https://nominatim.openstreetmap.org; " .
               "frame-src 'none'";
        header("Content-Security-Policy: $csp");
        
        // Referrer Policy
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        // Feature Policy
        header("Permissions-Policy: geolocation=(), camera=(), microphone=()");
    }
    
    /**
     * Set secure session configuration
     */
    public static function setSecureSession() {
        // Set secure session parameters
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 3600, // 1 hour
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            session_start();
            
            // Regenerate session ID periodically
            if (!isset($_SESSION['created'])) {
                $_SESSION['created'] = time();
            } else if (time() - $_SESSION['created'] > 1800) { // 30 minutes
                session_regenerate_id(true);
                $_SESSION['created'] = time();
            }
        }
    }
}