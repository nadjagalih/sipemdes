<?php
/**
 * Application Configuration
 * Main configuration file for SIPEMDES
 */

return [
    'app' => [
        'name' => 'SIPEMDES',
        'version' => '2.0.0',
        'environment' => 'development', // Change to 'production' for production
        'timezone' => 'Asia/Jakarta',
        'debug' => true, // Set to false in production
        'url' => 'http://localhost/sipemdes1',
        'locale' => 'id_ID'
    ],
    
    'database' => [
        'default' => 'mysql',
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'sipemdes_dbpemd3sa',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => false,
                'engine' => null,
            ]
        ]
    ],
    
    'security' => [
        // Session Configuration
        'session' => [
            'timeout' => 3600, // 1 hour
            'regenerate_interval' => 1800, // 30 minutes
            'cookie_secure' => true, // Always secure for production - SECURITY FIX
            'cookie_httponly' => true,
            'cookie_samesite' => 'Strict'
        ],
        
        // Authentication
        'auth' => [
            'max_login_attempts' => 5,
            'lockout_duration' => 900, // 15 minutes
            'password_min_length' => 8,
            'require_strong_password' => true,
            'password_expiry_days' => 90
        ],
        
        // CSRF Protection
        'csrf' => [
            'token_expiry' => 3600, // 1 hour
            'regenerate_on_use' => false
        ],
        
        // Rate Limiting
        'rate_limit' => [
            'login_attempts' => [
                'max_attempts' => 5,
                'time_window' => 900 // 15 minutes
            ],
            'api_requests' => [
                'max_requests' => 100,
                'time_window' => 3600 // 1 hour
            ]
        ],
        
        // File Upload Security
        'upload' => [
            'max_file_size' => 10 * 1024 * 1024, // 10MB
            'allowed_image_types' => ['jpg', 'jpeg', 'png', 'gif'],
            'allowed_document_types' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
            'scan_uploads' => true,
            'quarantine_suspicious' => true
        ]
    ],
    
    'logging' => [
        'enabled' => true,
        'level' => 'info', // debug, info, warning, error, critical
        'channels' => [
            'application' => [
                'file' => 'logs/app.log',
                'max_size' => 50 * 1024 * 1024, // 50MB
                'max_files' => 10
            ],
            'security' => [
                'file' => 'logs/security.log',
                'max_size' => 100 * 1024 * 1024, // 100MB
                'max_files' => 20
            ],
            'error' => [
                'file' => 'logs/error.log',
                'max_size' => 50 * 1024 * 1024, // 50MB
                'max_files' => 15
            ]
        ]
    ],
    
    'cache' => [
        'default' => 'file',
        'ttl' => 3600, // 1 hour
        'path' => 'cache/',
        'enabled' => true
    ],
    
    'mail' => [
        'driver' => 'smtp',
        'host' => 'localhost',
        'port' => 587,
        'username' => '',
        'password' => '',
        'encryption' => 'tls',
        'from' => [
            'address' => 'noreply@sipemdes.com',
            'name' => 'SIPEMDES System'
        ]
    ],
    
    'features' => [
        'maintenance_mode' => false,
        'registration_enabled' => false,
        'password_reset_enabled' => true,
        'two_factor_auth' => false,
        'audit_logging' => true,
        'data_encryption' => false
    ],
    
    'ui' => [
        'theme' => 'default',
        'items_per_page' => 20,
        'date_format' => 'd/m/Y',
        'datetime_format' => 'd/m/Y H:i',
        'currency' => 'IDR',
        'language' => 'id'
    ]
];