<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

header('Content-Type: application/json');

try {
    if (AuthUtil::isLoggedIn()) {
        $user = AuthUtil::getCurrentUser();
        echo json_encode([
            'success' => true,
            'logged_in' => true,
            'user' => $user
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'logged_in' => false,
            'message' => 'Not logged in'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error checking session'
    ]);
}
?>