<?php

class ImagePathUtil {
    /**
     * Resolve image path based on context
     * @param string $imagePath The image path from database
     * @param string $context The context ('pages' or 'root')
     * @return string The resolved path
     */
    public static function resolve($imagePath, $context = 'pages') {
        // Handle null/empty paths
        if (empty($imagePath)) {
            return self::getPlaceholder();
        }
        
        // If path starts with /, it's absolute from domain root
        if (strpos($imagePath, '/') === 0) {
            return $imagePath;
        }
        
        // If path starts with assets/, make it relative to context
        if (strpos($imagePath, 'assets/') === 0) {
            return $context === 'pages' ? '../' . $imagePath : $imagePath;
        }
        
        // If path starts with ../, it's already relative to pages context
        if (strpos($imagePath, '../') === 0) {
            return $context === 'pages' ? $imagePath : substr($imagePath, 3);
        }
        
        // Default: assume it needs context-appropriate prefix
        return $context === 'pages' ? '../' . $imagePath : $imagePath;
    }
    
    /**
     * Get the upload directory path
     * @return string The upload directory path
     */
    public static function getUploadDirectory() {
        return defined('UPLOAD_PATH') ? UPLOAD_PATH : BASE_PATH . '/assets/img/marketplace/uploads/';
    }
    
    /**
     * Get relative path for uploaded images
     * @param string $filename The filename
     * @param string $context The context ('pages' or 'root')
     * @return string The relative path
     */
    public static function getUploadPath($filename, $context = 'pages') {
        $basePath = 'assets/img/marketplace/uploads/' . $filename;
        return $context === 'pages' ? '../' . $basePath : $basePath;
    }
    
    /**
     * Generate placeholder image URL with theme colors
     * @param string $text The text to display
     * @param int $width Image width
     * @param int $height Image height
     * @return string The placeholder URL
     */
    public static function getPlaceholder($text = 'No Image', $width = 150, $height = 150) {
        $encodedText = urlencode($text);
        return "https://via.placeholder.com/{$width}x{$height}/1C1C1C/DA6015?text={$encodedText}";
    }
    
    /**
     * Check if image file exists
     * @param string $imagePath The image path
     * @param string $context The context ('pages' or 'root')
     * @return bool Whether the file exists
     */
    public static function exists($imagePath, $context = 'pages') {
        if (empty($imagePath)) {
            return false;
        }
        
        // Convert to server file path
        $serverPath = self::toServerPath($imagePath, $context);
        return file_exists($serverPath);
    }
    
    /**
     * Convert web path to server file path
     * @param string $imagePath The web path
     * @param string $context The context
     * @return string The server file path
     */
    private static function toServerPath($imagePath, $context) {
        $resolved = self::resolve($imagePath, $context);
        
        // Remove leading ../ if present
        if (strpos($resolved, '../') === 0) {
            $resolved = substr($resolved, 3);
        }
        
        // Remove leading / if present
        if (strpos($resolved, '/') === 0) {
            $resolved = substr($resolved, 1);
        }
        
        return BASE_PATH . '/' . $resolved;
    }
}
?>