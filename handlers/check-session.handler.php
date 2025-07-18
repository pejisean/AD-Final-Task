<?php
session_start();

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
                'email' => $user['email']
            ];
        }
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Session check failed: ' . $e->getMessage(),
        'logged_in' => false,
        'user' => null
    ]);
}
?>