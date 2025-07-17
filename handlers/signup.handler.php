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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Get input data (exactly like login handler)
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_POST;
        }
        
        $username = trim($input['username'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';
        $gender = $input['gender'] ?? '';

        // Basic validation
        if (empty($username) || empty($password) || empty($gender)) {
            echo json_encode([
                'success' => false,
                'message' => 'Username, password, and gender are required'
            ]);
            exit();
        }

        // Check if username already exists (this works, so DB connection is fine)
        if (UserUtil::usernameExists($username)) {
            echo json_encode([
                'success' => false,
                'message' => 'This codename is already taken. Please choose another.'
            ]);
            exit();
        }

        // Check if email already exists (if provided)
        if (!empty($email) && UserUtil::emailExists($email)) {
            echo json_encode([
                'success' => false,
                'message' => 'This email is already registered'
            ]);
            exit();
        }

        // Try to create user directly with a simple query (bypass UserUtil for now)
        $connection = ConnectDB();
        if (!$connection) {
            echo json_encode([
                'success' => false,
                'message' => 'Database connection failed'
            ]);
            exit();
        }

        // Direct insert query (like your working handlers)
        $query = "INSERT INTO users (username, email, password, gender, role) VALUES ($1, $2, $3, $4, $5)";
        $result = pg_query_params($connection, $query, [
            $username,
            !empty($email) ? $email : null,
            $password,
            $gender,
            'user'
        ]);

        pg_close($connection);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Account created successfully! You can now log in.'
            ]);
        } else {
            $error = pg_last_error();
            error_log("Direct insert failed: " . $error);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create account: ' . $error
            ]);
        }
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }

} catch (Error $e) {
    error_log("Fatal Error in signup: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Fatal Error: ' . $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ]);
} catch (Exception $e) {
    error_log("Exception in signup: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ]);
}
?>