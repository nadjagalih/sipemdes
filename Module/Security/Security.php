<?php
/**
 * Main Security Configuration
 * Include this file in all pages that need security protection
 */

// Include security classes
// Load configuration
require_once __DIR__ . '/../Config/ConfigManager.php';
ConfigManager::load();

// Define environment if not already defined
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', ConfigManager::getEnvironment());
}

require_once __DIR__ . '/SecurityHeaders.php';
require_once __DIR__ . '/CSRFProtection.php';
require_once __DIR__ . '/XSSProtection.php';
require_once __DIR__ . '/InputValidator.php';
require_once __DIR__ . '/CSPHandler.php';
require_once __DIR__ . '/SecureErrorHandler.php';
require_once __DIR__ . '/SecureFileUpload.php';
require_once __DIR__ . '/DataMasker.php';

// Initialize secure error handling
SecureErrorHandler::initialize(__DIR__ . '/../../Logs/error.log');

// Apply security headers
SecurityHeaders::setSecurityHeaders();

// Set CSP headers with nonce support
CSPHandler::setCSPHeaders();

// Start secure session
SecurityHeaders::setSecureSession();

// Helper functions for backward compatibility
function secure_output($string) {
    return XSSProtection::escape($string);
}

function csrf_token_field() {
    return CSRFProtection::getTokenField();
}

function validate_csrf() {
    return CSRFProtection::validateToken();
}

// Rate limiting class
class RateLimiter {
    private static $attempts = [];
    
    public static function checkLimit($identifier, $maxAttempts = 5, $timeWindow = 300) {
        $now = time();
        
        if (!isset(self::$attempts[$identifier])) {
            self::$attempts[$identifier] = [];
        }
        
        // Clean old attempts
        self::$attempts[$identifier] = array_filter(
            self::$attempts[$identifier],
            function($timestamp) use ($now, $timeWindow) {
                return ($now - $timestamp) < $timeWindow;
            }
        );
        
        // Check if limit exceeded
        if (count(self::$attempts[$identifier]) >= $maxAttempts) {
            return false;
        }
        
        // Record this attempt
        self::$attempts[$identifier][] = $now;
        return true;
    }
}