<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/cart.util.php';

header('Content-Type: application/json');

try {
    if (AuthUtil::isLoggedIn()) {
        $user = AuthUtil::getCurrentUser();
        
        // Clear all user cart sessions from database
        CartUtil::clearAllUserSessions($user['id']);
        
        // Logout user (destroys PHP session)
        AuthUtil::logout();
        
        echo json_encode([
            'success' => true,
            'message' => 'Logged out successfully',
            'clear_localStorage' => true // Signal to clear localStorage
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'User not logged in',
            'clear_localStorage' => true // Clear localStorage anyway
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error during logout',
        'clear_localStorage' => true // Clear localStorage on error
    ]);
}
?>