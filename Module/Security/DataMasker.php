<?php
/**
 * Data Masking Utilities
 * Mask sensitive information in display
 */

class DataMasker {
    
    /**
     * Mask email address
     */
    public static function maskEmail($email) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }
        
        $parts = explode('@', $email);
        $username = $parts[0];
        $domain = $parts[1];
        
        $usernameLength = strlen($username);
        
        if ($usernameLength <= 2) {
            $maskedUsername = str_repeat('*', $usernameLength);
        } else {
            $visibleChars = min(2, floor($usernameLength / 3));
            $maskedUsername = substr($username, 0, $visibleChars) . 
                            str_repeat('*', $usernameLength - $visibleChars * 2) . 
                            substr($username, -$visibleChars);
        }
        
        return $maskedUsername . '@' . $domain;
    }
    
    /**
     * Mask phone number
     */
    public static function maskPhone($phone) {
        if (empty($phone)) {
            return $phone;
        }
        
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        $length = strlen($cleaned);
        
        if ($length < 6) {
            return str_repeat('*', $length);
        }
        
        $visibleStart = 3;
        $visibleEnd = 2;
        $masked = substr($cleaned, 0, $visibleStart) . 
                 str_repeat('*', $length - $visibleStart - $visibleEnd) . 
                 substr($cleaned, -$visibleEnd);
        
        return $masked;
    }
    
    /**
     * Mask NIK (Indonesian ID number)
     */
    public static function maskNIK($nik) {
        if (empty($nik) || strlen($nik) !== 16) {
            return $nik;
        }
        
        return substr($nik, 0, 4) . str_repeat('*', 8) . substr($nik, -4);
    }
    
    /**
     * Mask bank account number
     */
    public static function maskBankAccount($account) {
        if (empty($account)) {
            return $account;
        }
        
        $length = strlen($account);
        
        if ($length <= 4) {
            return str_repeat('*', $length);
        }
        
        return str_repeat('*', $length - 4) . substr($account, -4);
    }
    
    /**
     * Mask address (show only city/district)
     */
    public static function maskAddress($address) {
        if (empty($address)) {
            return $address;
        }
        
        // Extract city/district from address (basic implementation)
        $words = explode(' ', $address);
        $wordCount = count($words);
        
        if ($wordCount <= 2) {
            return $address; // Too short to mask
        }
        
        // Show first word and last 2 words
        return $words[0] . ' ... ' . $words[$wordCount-2] . ' ' . $words[$wordCount-1];
    }
    
    /**
     * Mask credit card number
     */
    public static function maskCreditCard($cardNumber) {
        if (empty($cardNumber)) {
            return $cardNumber;
        }
        
        $cleaned = preg_replace('/[^0-9]/', '', $cardNumber);
        
        if (strlen($cleaned) < 8) {
            return str_repeat('*', strlen($cleaned));
        }
        
        return str_repeat('*', strlen($cleaned) - 4) . substr($cleaned, -4);
    }
    
    /**
     * Mask general string (show first and last chars)
     */
    public static function maskString($string, $visibleChars = 2) {
        if (empty($string)) {
            return $string;
        }
        
        $length = strlen($string);
        
        if ($length <= $visibleChars * 2) {
            return str_repeat('*', $length);
        }
        
        return substr($string, 0, $visibleChars) . 
               str_repeat('*', $length - $visibleChars * 2) . 
               substr($string, -$visibleChars);
    }
    
    /**
     * Check if user can view sensitive data
     */
    public static function canViewSensitiveData($userLevel = null) {
        if ($userLevel === null && isset($_SESSION['IdLevelUserFK'])) {
            $userLevel = $_SESSION['IdLevelUserFK'];
        }
        
        // Level 1 = Super Admin, Level 2 = Admin - can view sensitive data
        return in_array($userLevel, [1, 2]);
    }
    
    /**
     * Conditional masking based on user permission
     */
    public static function conditionalMask($data, $type = 'string', $userLevel = null) {
        if (self::canViewSensitiveData($userLevel)) {
            return $data; // User can view full data
        }
        
        // Mask data based on type
        switch ($type) {
            case 'email':
                return self::maskEmail($data);
            case 'phone':
                return self::maskPhone($data);
            case 'nik':
                return self::maskNIK($data);
            case 'address':
                return self::maskAddress($data);
            case 'bank':
                return self::maskBankAccount($data);
            case 'card':
                return self::maskCreditCard($data);
            default:
                return self::maskString($data);
        }
    }
}