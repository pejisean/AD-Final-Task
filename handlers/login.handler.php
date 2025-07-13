<?php
// Turn off all error display to prevent HTML in JSON response
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(0);

header('Content-Type: application/json');

try {
    // Include bootstrap
    require_once '../bootstrap.php';
    
    // Include required utilities
    require_once UTILS_PATH . '/envSetter.util.php';
    require_once HANDLERS_PATH . '/database.handler.php';
    require_once UTILS_PATH . '/database.util.php';
    require_once UTILS_PATH . '/auth.util.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Get input data
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_POST;
        }
        
        $username = trim($input['codename'] ?? '');
        $password = $input['password'] ?? '';

        // Validate input
        if (empty($username) || empty($password)) {
            echo json_encode([
                'success' => false,
                'message' => 'Username and password are required'
            ]);
            exit();
        }

        // Test database connection first
        $connection = ConnectDB();
        if (!$connection) {
            echo json_encode([
                'success' => false,
                'message' => 'Database connection failed'
            ]);
            exit();
        }
        pg_close($connection);

        // Attempt login using AuthUtil
        $result = AuthUtil::login($username, $password);
        echo json_encode($result);
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }

} catch (Error $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Fatal Error: ' . $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ]);
}
?>