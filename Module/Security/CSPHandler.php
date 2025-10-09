<?php
/**
 * Content Security Policy Configuration
 */

class CSPHandler {
    
    private static $nonce = null;
    
    /**
     * Generate CSP nonce
     */
    public static function getNonce() {
        if (self::$nonce === null) {
            self::$nonce = base64_encode(random_bytes(16));
        }
        return self::$nonce;
    }
    
    /**
     * Set CSP headers with nonce
     */
    public static function setCSPHeaders() {
        $nonce = self::getNonce();
        
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'nonce-$nonce' 'sha256-J6XHI1Bzc5WXZ05UpDhWmUgJcbVKx4aeqaM41jTU6vA=' https://unpkg.com https://cdn.jsdelivr.net",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://use.fontawesome.com https://unpkg.com",
            "font-src 'self' https://fonts.gstatic.com https://use.fontawesome.com",
            "img-src 'self' data: https:",
            "connect-src 'self' https://nominatim.openstreetmap.org",
            "frame-src 'none'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'"
        ];
        
        header("Content-Security-Policy: " . implode('; ', $csp));
    }
    
    /**
     * Get nonce for script tag
     */
    public static function scriptNonce() {
        return 'nonce="' . self::getNonce() . '"';
    }
}