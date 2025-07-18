<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';
require_once UTILS_PATH . '/cart.util.php';

header('Content-Type: application/json');

try {
    // Clear all user cart data if logged in
    if (AuthUtil::isLoggedIn()) {
        $user = AuthUtil::getCurrentUser();
        if ($user) {
            CartUtil::clearAllUserSessions($user['id']);
        }
    }
    
    // Clear PHP session completely
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Clear all session variables
    $_SESSION = array();
    
    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy session
    session_destroy();
    
    // Start a new clean session
    session_start();
    session_regenerate_id(true);
    
    echo json_encode([
        'success' => true,
        'message' => 'Complete reset successful',
        'clear_localStorage' => true,
        'clear_sessionStorage' => true,
        'reload_page' => true
    ]);
    
} catch (Exception $e) {
    error_log("Complete reset error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error during reset: ' . $e->getMessage(),
        'clear_localStorage' => true,
        'clear_sessionStorage' => true
    ]);
}
?>