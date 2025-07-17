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
        
        // If path starts with /, it's absolute from domain root - use as is
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
     * Get absolute server path for file operations
     * @param string $imagePath The image path from database
     * @return string The absolute server path
     */
    public static function getAbsolutePath($imagePath) {
        if (empty($imagePath)) {
            return null;
        }
        
        // If path starts with /, it's absolute from domain root
        if (strpos($imagePath, '/') === 0) {
            return BASE_PATH . $imagePath;
        }
        
        // If path starts with assets/, make it absolute
        if (strpos($imagePath, 'assets/') === 0) {
            return BASE_PATH . '/' . $imagePath;
        }
        
        // If path starts with ../, convert to absolute
        if (strpos($imagePath, '../') === 0) {
            $cleanPath = substr($imagePath, 3); // Remove ../
            return BASE_PATH . '/' . $cleanPath;
        }
        
        // Default: assume it's relative to BASE_PATH
        return BASE_PATH . '/' . $imagePath;
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
     * Generate placeholder image using actual product images
     * @param string $text The text to display
     * @param int $width Image width
     * @param int $height Image height
     * @return string The placeholder URL
     */
    public static function getPlaceholder($text = 'No Image', $width = 150, $height = 150) {
        // Check if we're in pages context
        $context = (strpos($_SERVER['REQUEST_URI'], '/pages/') !== false) ? 'pages' : 'root';
        
        // Use actual product images from your asset folders as placeholders
        $possibleImages = [
            'assets/img/electronics/powerbank.png',
            'assets/img/tools/crowbar.png',
            'assets/img/weapons/machete.png',
            'assets/img/other/first.png',
            'assets/img/electronics/led.png',
            'assets/img/tools/hammer.png',
            'assets/img/weapons/sentry.png',
            'assets/img/other/survival.png',
            'assets/img/electronics/circuit.png',
            'assets/img/tools/axe.png'
        ];
        
        // Pick a random image from the available ones
        $selectedImage = $possibleImages[array_rand($possibleImages)];
        
        // Check if the selected image exists
        $absolutePath = BASE_PATH . '/' . $selectedImage;
        if (file_exists($absolutePath)) {
            return $context === 'pages' ? '../' . $selectedImage : $selectedImage;
        }
        
        // Fallback to external placeholder service if no local images exist
        $encodedText = urlencode($text);
        return "https://via.placeholder.com/{$width}x{$height}/1C1C1C/DA6015?text={$encodedText}";
    }
    
    /**
     * Get a specific fallback image for marketplace items
     * @param string $context The context ('pages' or 'root')
     * @return string The fallback image path
     */
    public static function getMarketplaceFallback($context = 'pages') {
        // Use actual product images as fallbacks for marketplace items
        $fallbackImages = [
            'assets/img/electronics/powerbank.png',
            'assets/img/tools/crowbar.png',
            'assets/img/weapons/machete.png',
            'assets/img/other/first.png'
        ];
        
        // Pick a random fallback image
        $fallbackImage = $fallbackImages[array_rand($fallbackImages)];
        $absolutePath = BASE_PATH . '/' . $fallbackImage;
        
        if (file_exists($absolutePath)) {
            return $context === 'pages' ? '../' . $fallbackImage : $fallbackImage;
        }
        
        // If that doesn't exist, use the generic placeholder
        return self::getPlaceholder('Item Image');
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
        return $absolutePath && file_exists($absolutePath);
    }
    
    /**
     * Get file size if image exists
     * @param string $imagePath The image path
     * @return int|false File size in bytes or false if not exists
     */
    public static function getFileSize($imagePath) {
        if (empty($imagePath)) {
            return false;
        }
        
        $absolutePath = self::getAbsolutePath($imagePath);
        return $absolutePath && file_exists($absolutePath) ? filesize($absolutePath) : false;
    }
    
    /**
     * Get image dimensions if image exists
     * @param string $imagePath The image path
     * @return array|false Array with width/height or false if not exists
     */
    public static function getImageDimensions($imagePath) {
        if (empty($imagePath)) {
            return false;
        }
        
        $absolutePath = self::getAbsolutePath($imagePath);
        if (!$absolutePath || !file_exists($absolutePath)) {
            return false;
        }
        
        $imageInfo = getimagesize($absolutePath);
        return $imageInfo ? ['width' => $imageInfo[0], 'height' => $imageInfo[1]] : false;
    }
    
    /**
     * Validate image file
     * @param string $imagePath The image path
     * @return bool Whether the file is a valid image
     */
    public static function isValidImage($imagePath) {
        if (empty($imagePath)) {
            return false;
        }
        
        $absolutePath = self::getAbsolutePath($imagePath);
        if (!$absolutePath || !file_exists($absolutePath)) {
            return false;
        }
        
        $imageInfo = getimagesize($absolutePath);
        return $imageInfo !== false;
    }
    
    /**
     * Get web-safe path for HTML output
     * @param string $imagePath The image path from database
     * @param string $context The context ('pages' or 'root')
     * @param bool $checkExists Whether to check if file exists
     * @return string The web-safe path or placeholder
     */
    public static function getWebPath($imagePath, $context = 'pages', $checkExists = true) {
        if (empty($imagePath)) {
            return self::getMarketplaceFallback($context);
        }
        
        // Check if file exists (if requested)
        if ($checkExists && !self::exists($imagePath)) {
            return self::getMarketplaceFallback($context);
        }
        
        return self::resolve($imagePath, $context);
    }
}
?>