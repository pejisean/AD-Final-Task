<?php

class ImagePathUtil {
    
    /**
     * Simple path resolution - just add ../ prefix for pages context
     * @param string $imagePath The image path from database
     * @param string $context The context ('pages' or 'root')
     * @return string The resolved path
     */
    public static function resolve($imagePath, $context = 'root') {
        if (empty($imagePath)) {
            return '';
        }
        
        // For pages context, just add ../
        if ($context === 'pages') {
            return '../' . $imagePath;
        }
        
        // For root context, return as-is
        return $imagePath;
    }
    
    /**
     * Get absolute server path for file operations
     * @param string $imagePath The image path from database
     * @return string The absolute server path
     */
    public static function getAbsolutePath($imagePath) {
        if (empty($imagePath)) {
            return null;
        }
        
        return BASE_PATH . '/' . $imagePath;
    }
    
    /**
     * Get the upload directory path
     * @return string The upload directory path
     */
    public static function getUploadDirectory() {
        return BASE_PATH . '/assets/img/marketplace/uploads/';
    }
    
    /**
     * Check if image file exists on server
     * @param string $imagePath The image path
     * @return bool Whether the file exists
     */
    public static function exists($imagePath) {
        if (empty($imagePath)) {
            return false;
        }
        
        $absolutePath = self::getAbsolutePath($imagePath);
        return file_exists($absolutePath);
    }
}
?>