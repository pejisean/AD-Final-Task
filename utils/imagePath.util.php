<?php

class ImagePathUtil {
    
    /**
     * Resolve image paths correctly for different contexts
     * @param string|null $imagePath The image path to resolve
     * @param string $context The context ('pages' or 'root')
     * @return string The resolved image path
     */
    public static function resolve($imagePath, $context = 'pages') {
        if (!$imagePath) {
            return $context === 'pages' ? '../assets/img/placeholder.jpg' : 'assets/img/placeholder.jpg';
        }
        
        // If path starts with /, it's absolute from domain root
        if (str_starts_with($imagePath, '/')) {
            return $imagePath;
        }
        
        // If path starts with assets/, make it relative to context
        if (str_starts_with($imagePath, 'assets/')) {
            return $context === 'pages' ? '../' . $imagePath : $imagePath;
        }
        
        // If path starts with ../, it's already relative to pages
        if (str_starts_with($imagePath, '../')) {
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
}
?>