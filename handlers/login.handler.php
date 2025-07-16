<?php
// Turn off all error display to prevent HTML in JSON response
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    // Include bootstrap
    require_once '../bootstrap.php';
    
    // Include required utilities
    require_once UTILS_PATH . '/envSetter.util.php';
    require_once HANDLERS_PATH . '/database.handler.php';
    require_once UTILS_PATH . '/user.util.php';
    require_once UTILS_PATH . '/auth.util.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Get input data
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_POST;
        }
        
        $username = trim($input['codename'] ?? '');
        $password = $input['password'] ?? '';

        // Log the attempt for debugging
        error_log("Login attempt for username: " . $username);

        // Validate input
        if (empty($username) || empty($password)) {
            echo json_encode([
                'success' => false,
                'message' => 'Username and password are required'
            ]);
            exit();
        }

        // Test database connection (but don't close it)
        $connection = ConnectDB();
        if (!$connection) {
            echo json_encode([
                'success' => false,
                'message' => 'Database connection failed'
            ]);
            exit();
        }
        
        // Close the test connection since DatabaseUtil will create its own
        pg_close($connection);

        // Attempt login using AuthUtil (this will create new connections as needed)
        $result = AuthUtil::login($username, $password);
        
        // Log the result for debugging
        error_log("Login result: " . json_encode($result));
        
        echo json_encode($result);
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }

} catch (Error $e) {
    error_log("Fatal Error in login: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Fatal Error: ' . $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ]);
} catch (Exception $e) {
    error_log("Exception in login: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ]);
}
?>