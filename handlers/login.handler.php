<?php
// Turn off all error display to prevent HTML in JSON response
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(0);

header('Content-Type: application/json');

try {
    // Step 1: Include bootstrap
    require_once '../bootstrap.php';
    
    // Step 2: Include environment setup
    require_once UTILS_PATH . '/envSetter.util.php';
    
    // Step 3: Include the file that contains ConnectDB() - UPDATE THIS PATH
    // Look for one of these files in your project:
    require_once BASE_PATH . '/handlers/postgreChecker.handler.php';  // Try this first
    // OR require_once BASE_PATH . '/handlers/database.handler.php';
    // OR require_once UTILS_PATH . '/database.util.php';
    
    // Step 4: Include auth utility
    require_once UTILS_PATH . '/auth.util.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $input = json_decode(file_get_contents('php://input'), true);
        if(!$input){
            $input = $_POST;
        }

        $username = trim($input['codename'] ?? '');
        $password = $input['password'] ?? '';

        if (empty($username) || empty($password)){
            echo json_encode([
                'success' => false,
                'message' => 'Username and password are required'
            ]);
            exit();
        }

        // Test database connection
        $connection = ConnectDB();
        if (!$connection) {
            echo json_encode([
                'success' => false,
                'message' => 'Database connection failed'
            ]);
            exit();
        }
        pg_close($connection);

        // Try login
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