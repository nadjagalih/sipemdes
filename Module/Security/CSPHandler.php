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
            "script-src 'self' 'nonce-$nonce' 'unsafe-eval' 'unsafe-inline' 'sha256-J6XHI1Bzc5WXZ05UpDhWmUgJcbVKx4aeqaM41jTU6vA=' 'sha256-+Y6+obeKiW2g+YSfA9YP2TkrDqFEoOUpjuGVeOBGBzQ=' 'sha256-XMvdVIQQvrFllV2DhSQmewtTfVeYOj7JEXIjyB2xOpU=' 'sha256-0UxcMOYdfp8G+54E4VYzA=' 'sha256-XWdVIQQvrF11V2DhSQmewtTfVeYOj7JEXIjyB2xOpU=' 'sha256-KDMYZqAQ2JLh8CQ2BdCOaK1LqcWVshm+4CrLR8XjW5Y=' https://unpkg.com https://cdn.jsdelivr.net",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://use.fontawesome.com https://unpkg.com",
            "font-src 'self' https://fonts.gstatic.com https://use.fontawesome.com",
            "img-src 'self' data: https:",
            "connect-src 'self' https://nominatim.openstreetmap.org https://unpkg.com https://*.tile.openstreetmap.org https://*.openstreetmap.org",
            "frame-src 'none'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'"
        ];
        
        $cspHeader = implode('; ', $csp);
        
        // Only set header if headers haven't been sent yet
        if (!headers_sent()) {
            header("Content-Security-Policy: " . $cspHeader);
        }
        
        // Debug: log the CSP header and nonce
        error_log("CSP Header: " . $cspHeader);
        error_log("CSP Nonce: " . $nonce);
    }
    
    /**
     * Get nonce for script tag
     */
    public static function scriptNonce() {
        return 'nonce="' . self::getNonce() . '"';
    }
    
    /**
     * Get SRI (Subresource Integrity) attributes for external resources
     */
    public static function getSRI() {
        return [
            // jQuery 3.7.1
            'jquery-3.7.1' => 'sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs',
            
            // Leaflet 1.9.4
            'leaflet-1.9.4-css' => 'sha384-xzAm8b7LBz5Zzxh6UzJvJK0xj35GGl3VgcCl7CGkL3D5lCNaGIB3QVhqYB6Q+f6z',
            'leaflet-1.9.4-js' => 'sha384-Q0ZbcA6LjD8xT6TL9V6hH2pKlhm0WGmyFXjGRZnKHjt2z9aT5F9S8b7jt6l6v5',
            
            // FontAwesome 5.15.4
            'fontawesome-5.15.4' => 'sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm',
            
            // SweetAlert
            'sweetalert' => 'sha384-VUqOCbXMiN6UrLaA0CtM5z7b5Nd1xKoRb2YHhvfgq1Q6Fl5+tKmlvU1C6oX7J+XN'
        ];
    }
    
    /**
     * Get SRI attribute string for a resource
     */
    public static function sriAttribute($resourceKey) {
        $sriHashes = self::getSRI();
        if (isset($sriHashes[$resourceKey])) {
            return 'integrity="' . $sriHashes[$resourceKey] . '" crossorigin="anonymous"';
        }
        return '';
    }
}