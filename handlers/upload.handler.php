<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . '/auth.util.php';

    // Check if user is logged in
    if (!AuthUtil::isLoggedIn()) {
        echo json_encode([
            'success' => false,
            'message' => 'Must be logged in to upload images'
        ]);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
        exit();
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = $_FILES['image']['error'] ?? 'No file uploaded';
        error_log("Upload error: " . $error);
        echo json_encode([
            'success' => false,
            'message' => 'No image uploaded or upload error: ' . $error
        ]);
        exit();
    }

    // Use the uploads folder as specified
    $uploadDir = BASE_PATH . '/assets/img/marketplace/uploads/';
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            error_log("Failed to create upload directory: " . $uploadDir);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create upload directory'
            ]);
            exit();
        }
    }

    // Check if directory is writable
    if (!is_writable($uploadDir)) {
        error_log("Upload directory not writable: " . $uploadDir);
        echo json_encode([
            'success' => false,
            'message' => 'Upload directory not writable'
        ]);
        exit();
    }

    $file = $_FILES['image'];
    $fileName = uniqid() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    
    // Update web path to include uploads folder
    $webPath = 'assets/img/marketplace/uploads/' . $fileName;

    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = $file['type'];
    
    // Also check by file extension as backup
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!in_array($fileType, $allowedTypes) && !in_array($fileExtension, $allowedExtensions)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid file type. Only JPG, and PNG allowed.'
        ]);
        exit();
    }

    // Validate file size (5MB max)
    if ($file['size'] > 5 * 1024 * 1024) {
        echo json_encode([
            'success' => false,
            'message' => 'File too large. Maximum size is 5MB.'
        ]);
        exit();
    }

    // Additional security: check if file is actually an image
    if (!getimagesize($file['tmp_name'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid image file'
        ]);
        exit();
    }

    error_log("Attempting to move file from " . $file['tmp_name'] . " to " . $targetPath);

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        error_log("File uploaded successfully to: " . $targetPath);
        echo json_encode([
            'success' => true,
            'data' => [
                'url' => $webPath,
                'filename' => $fileName,
                'full_path' => $targetPath
            ]
        ]);
    } else {
        error_log("Failed to move uploaded file. Check permissions and paths.");
        error_log("Source: " . $file['tmp_name']);
        error_log("Target: " . $targetPath);
        error_log("Upload dir exists: " . (is_dir($uploadDir) ? 'YES' : 'NO'));
        error_log("Upload dir writable: " . (is_writable($uploadDir) ? 'YES' : 'NO'));
        
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload file. Check server logs.'
        ]);
    }

} catch (Exception $e) {
    error_log("Upload error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Upload error: ' . $e->getMessage()
    ]);
}
?>