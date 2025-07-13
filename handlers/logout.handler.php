<?php
    require_once '../bootstrap.php';
    require_once UTILS_PATH . 'auth.util.php';

    AuthUtil::logout();

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
?>