<?php
// filepath: c:\Users\Sean\Desktop\Schoolwork\2nd Year\Third Sem\CCS0043\AD-Final-Task\AD-Final-Task\handlers\check-session.handler.php
// Prevent any output before headers
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(0); // Changed from E_ALL to 0 to suppress all errors from being displayed

// Start session first
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . '/auth.util.php';

    $response = [
        'success' => true,
        'logged_in' => false,
        'user' => null
    ];

    if (AuthUtil::isLoggedIn()) {
        $user = AuthUtil::getCurrentUser();
        if ($user) {
            $response['logged_in'] = true;
            $response['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'] ?? null,
                'role' => $user['role'] ?? 'user'
            ];
        }
    }

    echo json_encode($response);

} catch (Exception $e) {
    error_log("Session check error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Session check failed: ' . $e->getMessage(),
        'logged_in' => false,
        'user' => null
    ]);
}
?>