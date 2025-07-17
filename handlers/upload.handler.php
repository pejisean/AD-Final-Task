<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . 'auth.util.php';
    require_once UTILS_PATH . 'imagePath.util.php'; // Remove the extra slash

    if (!AuthUtil::isLoggedIn()) {
        echo json_encode(['success' => false, 'message' => 'Must be logged in to upload images']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error']);
        exit;
    }

    $file = $_FILES['image'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    // Validate file type
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
        exit;
    }

    // Validate file size
    if ($file['size'] > $maxSize) {
        echo json_encode(['success' => false, 'message' => 'File too large. Maximum size is 5MB.']);
        exit;
    }

    // Use ImagePathUtil to get upload directory
    $uploadDir = ImagePathUtil::getUploadDirectory();

    // Create upload directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            echo json_encode(['success' => false, 'message' => 'Failed to create upload directory: ' . $uploadDir]);
            exit;
        }
    }

    // Check if directory is writable
    if (!is_writable($uploadDir)) {
        echo json_encode(['success' => false, 'message' => 'Upload directory is not writable: ' . $uploadDir]);
        exit;
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'item_' . time() . '_' . uniqid() . '.' . $extension;
    $targetPath = $uploadDir . $filename;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Return absolute path from domain root
        $relativePath = '/assets/img/marketplace/uploads/' . $filename;
        echo json_encode([
            'success' => true, 
            'message' => 'Image uploaded successfully',
            'image_url' => $relativePath
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file to: ' . $targetPath]);
    }

} catch (Exception $e) {
    error_log("Upload handler error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Upload failed: ' . $e->getMessage()
    ]);
}
?>