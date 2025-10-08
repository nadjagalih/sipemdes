<?php
/**
 * Secure Error Handler
 * Handles errors without exposing sensitive information
 */

class SecureErrorHandler {
    
    private static $logFile = null;
    
    /**
     * Set log file path
     */
    public static function setLogFile($path) {
        self::$logFile = $path;
    }
    
    /**
     * Handle errors securely
     */
    public static function handleError($errno, $errstr, $errfile, $errline) {
        // Log error details
        self::logError($errno, $errstr, $errfile, $errline);
        
        // Don't expose error details in production
        if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
            // Show generic error message
            self::showGenericError();
        } else {
            // Development mode - show error details
            self::showDetailedError($errno, $errstr, $errfile, $errline);
        }
        
        return true; // Don't execute internal error handler
    }
    
    /**
     * Handle exceptions securely
     */
    public static function handleException($exception) {
        self::logException($exception);
        
        if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
            self::showGenericError();
        } else {
            self::showDetailedException($exception);
        }
    }
    
    /**
     * Log error to file
     */
    private static function logError($errno, $errstr, $errfile, $errline) {
        if (self::$logFile) {
            $timestamp = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
            
            $logEntry = "[$timestamp] [$ip] ERROR: [$errno] $errstr in $errfile on line $errline | User-Agent: $userAgent" . PHP_EOL;
            
            error_log($logEntry, 3, self::$logFile);
        }
    }
    
    /**
     * Log exception to file
     */
    private static function logException($exception) {
        if (self::$logFile) {
            $timestamp = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
            
            $logEntry = "[$timestamp] [$ip] EXCEPTION: " . $exception->getMessage() . 
                       " in " . $exception->getFile() . " on line " . $exception->getLine() . 
                       " | User-Agent: $userAgent" . PHP_EOL;
            
            error_log($logEntry, 3, self::$logFile);
        }
    }
    
    /**
     * Show generic error message
     */
    private static function showGenericError() {
        http_response_code(500);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Error - SIPEMDES</title>
            <meta charset="utf-8">
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                .error-container { max-width: 500px; margin: 0 auto; }
                .error-icon { font-size: 64px; color: #e74c3c; margin-bottom: 20px; }
                h1 { color: #e74c3c; }
                p { color: #7f8c8d; line-height: 1.6; }
            </style>
        </head>
        <body>
            <div class="error-container">
                <div class="error-icon">⚠️</div>
                <h1>Terjadi Kesalahan</h1>
                <p>Maaf, terjadi kesalahan pada sistem. Tim teknis telah diberitahu dan akan segera memperbaikinya.</p>
                <p><a href="javascript:history.back()">Kembali</a> | <a href="/">Beranda</a></p>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
    
    /**
     * Show detailed error (development only)
     */
    private static function showDetailedError($errno, $errstr, $errfile, $errline) {
        ?>
        <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;">
            <h4>Error Details (Development Mode)</h4>
            <p><strong>Error:</strong> <?php echo XSSProtection::escape($errstr); ?></p>
            <p><strong>File:</strong> <?php echo XSSProtection::escape($errfile); ?></p>
            <p><strong>Line:</strong> <?php echo $errline; ?></p>
            <p><strong>Type:</strong> <?php echo $errno; ?></p>
        </div>
        <?php
    }
    
    /**
     * Show detailed exception (development only)
     */
    private static function showDetailedException($exception) {
        ?>
        <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;">
            <h4>Exception Details (Development Mode)</h4>
            <p><strong>Message:</strong> <?php echo XSSProtection::escape($exception->getMessage()); ?></p>
            <p><strong>File:</strong> <?php echo XSSProtection::escape($exception->getFile()); ?></p>
            <p><strong>Line:</strong> <?php echo $exception->getLine(); ?></p>
            <p><strong>Trace:</strong></p>
            <pre><?php echo XSSProtection::escape($exception->getTraceAsString()); ?></pre>
        </div>
        <?php
    }
    
    /**
     * Initialize error handling
     */
    public static function initialize($logFile = null) {
        if ($logFile) {
            self::setLogFile($logFile);
        }
        
        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
        
        // Set error reporting based on environment
        if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
            error_reporting(0);
            ini_set('display_errors', 0);
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
    }
}