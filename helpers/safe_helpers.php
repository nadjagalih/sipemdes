<?php
/**
 * Safe Helpers Library
 * Production-ready helper functions for error-free data handling
 * Created: October 8, 2025
 * Purpose: Prevent undefined index/offset errors across SIPEMDES application
 */

// Prevent direct access
if (!defined('DB_HOST') && !isset($db)) {
    // This file should only be included from application files
}

/**
 * Safely get session value with fallback
 * @param string $key Session key to retrieve
 * @param mixed $default Default value if key doesn't exist
 * @return mixed Session value or default
 */
function safeSession($key, $default = '') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
}

/**
 * Safely get array value with fallback
 * @param array $array Array to get value from
 * @param string $key Key to retrieve
 * @param mixed $default Default value if key doesn't exist
 * @return mixed Array value or default
 */
function safeGet($array, $key, $default = '') {
    if (!is_array($array)) {
        return $default;
    }
    return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Safely get POST value with fallback
 * @param string $key POST key to retrieve
 * @param mixed $default Default value if key doesn't exist
 * @return mixed POST value or default
 */
function safePost($key, $default = '') {
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}

/**
 * Safely get GET value with fallback
 * @param string $key GET key to retrieve
 * @param mixed $default Default value if key doesn't exist
 * @return mixed GET value or default
 */
function safeGetParam($key, $default = '') {
    return isset($_GET[$key]) ? $_GET[$key] : $default;
}

/**
 * Safely format date with fallback
 * @param string $date Date string to format
 * @param string $format Desired date format (default: d-m-Y)
 * @param string $default Default value if date is invalid
 * @return string Formatted date or default
 */
function safeDateFormat($date, $format = 'd-m-Y', $default = '-') {
    if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
        return $default;
    }
    
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return $default;
    }
    
    return date($format, $timestamp);
}

/**
 * Safely process data row with schema validation
 * @param array $data Raw data from database
 * @param array $schema Expected schema with default values
 * @return array Processed data with all required keys
 */
function safeDataRow($data, $schema) {
    $result = [];
    
    if (!is_array($data)) {
        $data = [];
    }
    
    foreach ($schema as $key => $defaultValue) {
        $result[$key] = isset($data[$key]) ? $data[$key] : $defaultValue;
    }
    
    return $result;
}

/**
 * Safely escape HTML output
 * @param string $string String to escape
 * @param int $flags HTML escape flags
 * @param string $encoding Character encoding
 * @return string Escaped string
 */
function safeHtml($string, $flags = ENT_QUOTES, $encoding = 'UTF-8') {
    if ($string === null || $string === '') {
        return '';
    }
    return htmlspecialchars($string, $flags, $encoding);
}

/**
 * Safely start session (prevents "session already started" errors)
 * @return bool True if session started successfully
 */
function safeSessionStart() {
    if (session_status() === PHP_SESSION_NONE) {
        return session_start();
    }
    return true;
}

/**
 * Check if value is empty or null safely
 * @param mixed $value Value to check
 * @return bool True if value is considered empty
 */
function safeEmpty($value) {
    return empty($value) || $value === null || $value === '';
}

/**
 * Safely convert to integer with fallback
 * @param mixed $value Value to convert
 * @param int $default Default value if conversion fails
 * @return int Integer value or default
 */
function safeInt($value, $default = 0) {
    if (is_numeric($value)) {
        return (int) $value;
    }
    return $default;
}

/**
 * Safely convert to float with fallback
 * @param mixed $value Value to convert
 * @param float $default Default value if conversion fails
 * @return float Float value or default
 */
function safeFloat($value, $default = 0.0) {
    if (is_numeric($value)) {
        return (float) $value;
    }
    return $default;
}

/**
 * Environment detection helper
 * @return bool True if in development mode
 */
function isDevelopment() {
    return (
        (defined('APP_ENV') && constant('APP_ENV') === 'development') ||
        (defined('ENVIRONMENT') && constant('ENVIRONMENT') === 'development') ||
        (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] === 'localhost') ||
        (isset($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], '127.0.0.1') !== false)
    );
}

/**
 * Safe error logging helper
 * @param string $message Error message to log
 * @param string $level Error level (ERROR, WARNING, INFO)
 * @return bool True if logged successfully
 */
function safeErrorLog($message, $level = 'ERROR') {
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] [$level] $message" . PHP_EOL;
    
    $logFile = __DIR__ . '/../Logs/safe_helpers.log';
    
    // Create logs directory if it doesn't exist
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    return file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX) !== false;
}

// Log that safe helpers has been loaded (for debugging)
if (isDevelopment()) {
    safeErrorLog('Safe helpers library loaded successfully', 'INFO');
}

?>
