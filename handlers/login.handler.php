<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . 'envSetter.util.php'; // Add this line
require_once UTILS_PATH . 'auth.util.php'; // Fixed the missing slash

// Disable HTML error output for clean JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);

    // Fallback if JSON input is empty
    if(!$input){
        $input = $_POST;
    }

    $username = trim($input['codename'] ?? '');
    $password = $input['password'] ?? '';

    // Debug: Add debug info to response
    $debug = [
        'input_received' => $input,
        'username' => $username,
        'password_length' => strlen($password),
        'timestamp' => date('Y-m-d H:i:s')
    ];

    if (empty($username) || empty($password)){
        echo json_encode([
            'success' => false,
            'message' => 'Username and password are required',
            'debug' => $debug
        ]);
        exit();
    }

    // Test database connection before login
    try {
        $connection = ConnectDB();
        $debug['db_connection'] = $connection ? 'success' : 'failed';
        if ($connection) {
            pg_close($connection);
        }
    } catch (Exception $e) {
        $debug['db_error'] = $e->getMessage();
    }

    try {
        $result = AuthUtil::login($username, $password);
        
        // Add debug info to result
        $result['debug'] = $debug;
        
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Login error: ' . $e->getMessage(),
            'debug' => $debug
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method',
        'debug' => ['method' => $_SERVER['REQUEST_METHOD']]
    ]);
}
?>