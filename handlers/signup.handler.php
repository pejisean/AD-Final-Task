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
        
        // Get input data
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_POST;
        }
        
        $username = trim($input['username'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';
        $gender = $input['gender'] ?? '';

        // Log the attempt for debugging
        error_log("Signup attempt for username: " . $username);

        // Basic validation
        if (empty($username) || empty($password) || empty($gender)) {
            echo json_encode([
                'success' => false,
                'message' => 'Username, password, and gender are required'
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

        // Check if username already exists using direct query
        $checkQuery = "SELECT username FROM users WHERE username = $1";
        $result = pg_query_params($connection, $checkQuery, [$username]);
        
        if (!$result) {
            pg_close($connection);
            echo json_encode([
                'success' => false,
                'message' => 'Database query failed'
            ]);
            exit();
        }

        if (pg_num_rows($result) > 0) {
            pg_close($connection);
            echo json_encode([
                'success' => false,
                'message' => 'This codename is already taken. Please choose another.'
            ]);
            exit();
        }

        // Check if email already exists (if provided)
        if (!empty($email)) {
            $emailCheckQuery = "SELECT email FROM users WHERE email = $1";
            $emailResult = pg_query_params($connection, $emailCheckQuery, [$email]);
            
            if ($emailResult && pg_num_rows($emailResult) > 0) {
                pg_close($connection);
                echo json_encode([
                    'success' => false,
                    'message' => 'This email is already registered'
                ]);
                exit();
            }
        }

        // Create the user with direct query
        $insertQuery = "INSERT INTO users (username, email, password, gender, role, is_active) VALUES ($1, $2, $3, $4, $5, $6)";
        $insertResult = pg_query_params($connection, $insertQuery, [
            $username,
            !empty($email) ? $email : null,
            $password, // Store plain text for now (you should hash this in production)
            $gender,
            'user',
            true
        ]);

        pg_close($connection);

        if ($insertResult) {
            echo json_encode([
                'success' => true,
                'message' => 'Account created successfully! You can now log in.'
            ]);
        } else {
            $error = pg_last_error();
            error_log("Direct insert failed: " . $error);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create account. Please try again.'
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
        'message' => 'Server error occurred. Please try again.'
    ]);
} catch (Exception $e) {
    error_log("Exception in signup: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again.'
    ]);
}
?>