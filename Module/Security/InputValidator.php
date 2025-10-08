<?php
/**
 * Input Validation Class
 * Comprehensive input validation and sanitization
 */

class InputValidator {
    
    private static $errors = [];
    
    /**
     * Validate required field
     */
    public static function required($value, $fieldName) {
        if (empty(trim($value))) {
            self::$errors[$fieldName] = "$fieldName tidak boleh kosong";
            return false;
        }
        return true;
    }
    
    /**
     * Validate email
     */
    public static function email($email, $fieldName = 'Email') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::$errors[$fieldName] = "$fieldName tidak valid";
            return false;
        }
        return true;
    }
    
    /**
     * Validate phone number
     */
    public static function phone($phone, $fieldName = 'Nomor Telepon') {
        if (!preg_match('/^[0-9+\-\s()]+$/', $phone)) {
            self::$errors[$fieldName] = "$fieldName hanya boleh berisi angka dan karakter +, -, (), spasi";
            return false;
        }
        return true;
    }
    
    /**
     * Validate NIK (16 digits)
     */
    public static function nik($nik, $fieldName = 'NIK') {
        if (!preg_match('/^[0-9]{16}$/', $nik)) {
            self::$errors[$fieldName] = "$fieldName harus 16 digit angka";
            return false;
        }
        return true;
    }
    
    /**
     * Validate date
     */
    public static function date($date, $fieldName = 'Tanggal') {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if (!$d || $d->format('Y-m-d') !== $date) {
            self::$errors[$fieldName] = "$fieldName tidak valid";
            return false;
        }
        return true;
    }
    
    /**
     * Validate string length
     */
    public static function length($value, $min, $max, $fieldName) {
        $len = strlen($value);
        if ($len < $min || $len > $max) {
            self::$errors[$fieldName] = "$fieldName harus antara $min dan $max karakter";
            return false;
        }
        return true;
    }
    
    /**
     * Validate alphanumeric
     */
    public static function alphanumeric($value, $fieldName) {
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $value)) {
            self::$errors[$fieldName] = "$fieldName hanya boleh berisi huruf, angka, dan spasi";
            return false;
        }
        return true;
    }
    
    /**
     * Validate numeric
     */
    public static function numeric($value, $fieldName) {
        if (!is_numeric($value)) {
            self::$errors[$fieldName] = "$fieldName harus berupa angka";
            return false;
        }
        return true;
    }
    
    /**
     * Validate file upload
     */
    public static function file($file, $allowedTypes, $maxSize, $fieldName = 'File') {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            self::$errors[$fieldName] = "Gagal upload $fieldName";
            return false;
        }
        
        $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileType, $allowedTypes)) {
            self::$errors[$fieldName] = "$fieldName harus berformat: " . implode(', ', $allowedTypes);
            return false;
        }
        
        if ($file['size'] > $maxSize) {
            $maxSizeMB = round($maxSize / 1024 / 1024, 1);
            self::$errors[$fieldName] = "$fieldName maksimal $maxSizeMB MB";
            return false;
        }
        
        return true;
    }
    
    /**
     * Validate password strength
     */
    public static function password($password, $fieldName = 'Password') {
        if (strlen($password) < 8) {
            self::$errors[$fieldName] = "$fieldName minimal 8 karakter";
            return false;
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            self::$errors[$fieldName] = "$fieldName harus mengandung huruf besar";
            return false;
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            self::$errors[$fieldName] = "$fieldName harus mengandung huruf kecil";
            return false;
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            self::$errors[$fieldName] = "$fieldName harus mengandung angka";
            return false;
        }
        
        return true;
    }
    
    /**
     * Get all validation errors
     */
    public static function getErrors() {
        return self::$errors;
    }
    
    /**
     * Check if validation has errors
     */
    public static function hasErrors() {
        return !empty(self::$errors);
    }
    
    /**
     * Clear all errors
     */
    public static function clearErrors() {
        self::$errors = [];
    }
    
    /**
     * Get first error message
     */
    public static function getFirstError() {
        return !empty(self::$errors) ? reset(self::$errors) : '';
    }
}

/**
 * SQL Injection Protection
 */
class SQLProtection {
    
    /**
     * Prepare statement with parameters
     */
    public static function prepare($connection, $query, $params = []) {
        $stmt = mysqli_prepare($connection, $query);
        
        if (!$stmt) {
            throw new Exception('Failed to prepare statement: ' . mysqli_error($connection));
        }
        
        if (!empty($params)) {
            $types = '';
            $values = [];
            
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $param;
            }
            
            mysqli_stmt_bind_param($stmt, $types, ...$values);
        }
        
        return $stmt;
    }
    
    /**
     * Execute prepared statement
     */
    public static function execute($stmt) {
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Failed to execute statement: ' . mysqli_stmt_error($stmt));
        }
        
        return $stmt;
    }
}