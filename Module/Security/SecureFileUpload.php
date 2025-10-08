<?php
/**
 * Secure File Upload Handler
 * Handles file uploads with security checks
 */

class SecureFileUpload {
    
    private static $allowedTypes = [
        'image' => ['jpg', 'jpeg', 'png', 'gif'],
        'document' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
        'general' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx']
    ];
    
    private static $maxSizes = [
        'image' => 5 * 1024 * 1024,     // 5MB
        'document' => 10 * 1024 * 1024, // 10MB
        'general' => 10 * 1024 * 1024   // 10MB
    ];
    
    /**
     * Upload file securely
     */
    public static function upload($file, $uploadDir, $type = 'general', $customName = null) {
        try {
            // Validate upload
            if (!self::validateUpload($file, $type)) {
                return ['success' => false, 'error' => 'File validation failed'];
            }
            
            // Create upload directory if not exists
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    return ['success' => false, 'error' => 'Failed to create upload directory'];
                }
            }
            
            // Generate secure filename
            $filename = self::generateSecureFilename($file['name'], $customName);
            $uploadPath = $uploadDir . '/' . $filename;
            
            // Check for malicious content
            if (!self::scanFileContent($file['tmp_name'])) {
                return ['success' => false, 'error' => 'File content validation failed'];
            }
            
            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Set secure file permissions
                chmod($uploadPath, 0644);
                
                return [
                    'success' => true,
                    'filename' => $filename,
                    'path' => $uploadPath,
                    'size' => filesize($uploadPath)
                ];
            } else {
                return ['success' => false, 'error' => 'Failed to move uploaded file'];
            }
            
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Upload error: ' . $e->getMessage()];
        }
    }
    
    /**
     * Validate file upload
     */
    private static function validateUpload($file, $type) {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        // Check file size
        if (!isset(self::$maxSizes[$type])) {
            $type = 'general';
        }
        
        if ($file['size'] > self::$maxSizes[$type]) {
            return false;
        }
        
        // Check file extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!isset(self::$allowedTypes[$type])) {
            $type = 'general';
        }
        
        if (!in_array($extension, self::$allowedTypes[$type])) {
            return false;
        }
        
        // Check MIME type
        $allowedMimes = self::getAllowedMimeTypes($type);
        $fileMime = mime_content_type($file['tmp_name']);
        
        if (!in_array($fileMime, $allowedMimes)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Generate secure filename
     */
    private static function generateSecureFilename($originalName, $customName = null) {
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        
        if ($customName) {
            // Sanitize custom name
            $basename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $customName);
        } else {
            // Generate random name
            $basename = bin2hex(random_bytes(16));
        }
        
        // Add timestamp to prevent conflicts
        $timestamp = time();
        
        return $basename . '_' . $timestamp . '.' . $extension;
    }
    
    /**
     * Scan file content for malicious patterns
     */
    private static function scanFileContent($filePath) {
        $content = file_get_contents($filePath);
        
        // Check for PHP code in uploaded files
        $maliciousPatterns = [
            '/<\?php/i',
            '/<\?=/i',
            '/<script/i',
            '/eval\s*\(/i',
            '/exec\s*\(/i',
            '/system\s*\(/i',
            '/shell_exec\s*\(/i',
            '/passthru\s*\(/i'
        ];
        
        foreach ($maliciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get allowed MIME types for file type
     */
    private static function getAllowedMimeTypes($type) {
        $mimeTypes = [
            'image' => [
                'image/jpeg',
                'image/png',
                'image/gif'
            ],
            'document' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]
        ];
        
        if ($type === 'general') {
            return array_merge($mimeTypes['image'], $mimeTypes['document']);
        }
        
        return $mimeTypes[$type] ?? [];
    }
    
    /**
     * Delete file securely
     */
    public static function deleteFile($filePath) {
        if (file_exists($filePath)) {
            // Overwrite file content before deletion (security best practice)
            $fileSize = filesize($filePath);
            $handle = fopen($filePath, 'w');
            
            if ($handle) {
                // Overwrite with random data
                fwrite($handle, str_repeat(chr(0), $fileSize));
                fclose($handle);
            }
            
            return unlink($filePath);
        }
        
        return false;
    }
    
    /**
     * Set custom allowed types
     */
    public static function setAllowedTypes($type, $extensions) {
        self::$allowedTypes[$type] = $extensions;
    }
    
    /**
     * Set custom max size
     */
    public static function setMaxSize($type, $size) {
        self::$maxSizes[$type] = $size;
    }
}