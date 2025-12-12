<?php
/**
 * Configuration Manager
 * Centralized configuration with security features
 */

class ConfigManager {
    
    private static $config = [];
    private static $loaded = false;
    
    /**
     * Load configuration
     */
    public static function load($configFile = null) {
        if (self::$loaded) {
            return;
        }
        
        if ($configFile === null) {
            $configFile = __DIR__ . '/../../config/app_config.php';
        }
        
        if (file_exists($configFile)) {
            self::$config = require $configFile;
        }
        
        // Set default values
        self::setDefaults();
        self::$loaded = true;
    }
    
    /**
     * Get configuration value
     */
    public static function get($key, $default = null) {
        self::load();
        
        // Support dot notation (e.g., 'database.host')
        $keys = explode('.', $key);
        $value = self::$config;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    /**
     * Set configuration value
     */
    public static function set($key, $value) {
        self::load();
        
        $keys = explode('.', $key);
        $config = &self::$config;
        
        foreach ($keys as $k) {
            if (!isset($config[$k])) {
                $config[$k] = [];
            }
            $config = &$config[$k];
        }
        
        $config = $value;
    }
    
    /**
     * Set default configuration values
     */
    private static function setDefaults() {
        $defaults = [
            'app' => [
                'name' => 'SIPEMDES',
                'version' => '1.0.0',
                'environment' => 'development',
                'timezone' => 'Asia/Jakarta',
                'debug' => true
            ],
            'security' => [
                'session_timeout' => 3600,
                'max_login_attempts' => 5,
                'lockout_duration' => 900,
                'csrf_token_expiry' => 3600,
                'password_min_length' => 8,
                'require_strong_password' => true
            ],
            'upload' => [
                'max_file_size' => 10 * 1024 * 1024, // 10MB
                'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],
                'upload_path' => 'uploads/',
                'quarantine_path' => 'quarantine/'
            ],
            'logging' => [
                'enabled' => true,
                'level' => 'info',
                'file' => 'logs/app.log',
                'max_size' => 50 * 1024 * 1024 // 50MB
            ]
        ];
        
        // Merge with existing config
        self::$config = array_merge_recursive($defaults, self::$config);
    }
    
    /**
     * Get all configuration
     */
    public static function all() {
        self::load();
        return self::$config;
    }
    
    /**
     * Check if key exists
     */
    public static function has($key) {
        return self::get($key) !== null;
    }
    
    /**
     * Get environment
     */
    public static function getEnvironment() {
        return self::get('app.environment', 'development');
    }
    
    /**
     * Check if in production
     */
    public static function isProduction() {
        return self::getEnvironment() === 'production';
    }
    
    /**
     * Check if in development
     */
    public static function isDevelopment() {
        return self::getEnvironment() === 'development';
    }
    
    /**
     * Get database configuration
     */
    public static function getDatabase() {
        return self::get('database', []);
    }
    
    /**
     * Get security configuration
     */
    public static function getSecurity() {
        return self::get('security', []);
    }
}