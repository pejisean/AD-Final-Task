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
        echo json_encode([
            'success' => false,
            'message' => 'No image uploaded or upload error'
        ]);
        exit();
    }

    // Use absolute path from BASE_PATH
    $uploadDir = BASE_PATH . '/assets/img/marketplace/';
    
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
    $webPath = 'assets/img/marketplace/' . $fileName;

    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid file type'
        ]);
        exit();
    }

    // Validate file size (5MB max)
    if ($file['size'] > 5 * 1024 * 1024) {
        echo json_encode([
            'success' => false,
            'message' => 'File too large'
        ]);
        exit();
    }

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo json_encode([
            'success' => true,
            'data' => [
                'url' => $webPath,
                'filename' => $fileName
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload file'
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