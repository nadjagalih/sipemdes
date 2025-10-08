<?php
/**
 * XSS Protection Functions
 * Secure output and input handling
 */

class XSSProtection {
    
    /**
     * Escape output for HTML context
     */
    public static function escape($string, $encoding = 'UTF-8') {
        if ($string === null || $string === '') {
            return '';
        }
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, $encoding);
    }
    
    /**
     * Escape for HTML attributes
     */
    public static function escapeAttr($string, $encoding = 'UTF-8') {
        if ($string === null || $string === '') {
            return '';
        }
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, $encoding);
    }
    
    /**
     * Escape for JavaScript context
     */
    public static function escapeJs($string, $encoding = 'UTF-8') {
        if ($string === null || $string === '') {
            return '';
        }
        return json_encode($string, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
    
    /**
     * Escape for URL context
     */
    public static function escapeUrl($string) {
        if ($string === null || $string === '') {
            return '';
        }
        return urlencode($string);
    }
    
    /**
     * Clean HTML input (allow only safe tags)
     */
    public static function cleanHTML($html) {
        $allowedTags = '<p><br><strong><em><ul><ol><li><a>';
        return strip_tags($html, $allowedTags);
    }
    
    /**
     * Validate and sanitize input
     */
    public static function sanitizeInput($input, $type = 'string') {
        if ($input === null || $input === '') {
            return '';
        }
        
        switch ($type) {
            case 'email':
                return filter_var($input, FILTER_SANITIZE_EMAIL);
            case 'url':
                return filter_var($input, FILTER_SANITIZE_URL);
            case 'int':
                return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
            case 'float':
                return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            case 'string':
            default:
                return htmlspecialchars(trim($input), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
    }
    
    /**
     * Safe echo function
     */
    public static function safeEcho($string, $encoding = 'UTF-8') {
        echo self::escape($string, $encoding);
    }
}