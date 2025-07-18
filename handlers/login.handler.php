<?php
// Turn off all error display to prevent HTML in JSON response
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    // Include bootstrap
    require_once '../bootstrap.php';
    
    // Include required utilities - this sets up $pgConfig
    require_once UTILS_PATH . '/envSetter.util.php';

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

        // Use the same connection method as the seeder utilities
        // $pgConfig is available after including envSetter.util.php
        $dsn = "pgsql:host={$pgConfig['pg_host']};port={$pgConfig['pg_port']};dbname={$pgConfig['pg_db']}";
        $pdo = new PDO($dsn, $pgConfig['pg_user'], $pgConfig['pg_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        // Find user by username
        $query = "SELECT id, username, password, role FROM users WHERE username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid username or password'
            ]);
            exit();
        }

        // Verify password
        if ($user['password'] !== $password) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid username or password'
            ]);
            exit();
        }

        // Start session and store user data
        session_start();
        session_regenerate_id(true); // Prevent session fixation
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_role'] = $user['role']; // For backward compatibility
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();

        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ],
            'clear_localStorage' => false // Don't clear localStorage on successful login
        ]);
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }

} catch (PDOException $e) {
    error_log("Database error in login: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred. Please try again.',
        'debug' => $e->getMessage() // Remove this in production
    ]);
} catch (Error $e) {
    error_log("Fatal Error in login: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred. Please try again.',
        'debug' => $e->getMessage() // Remove this in production
    ]);
} catch (Exception $e) {
    error_log("Exception in login: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again.',
        'debug' => $e->getMessage() // Remove this in production
    ]);
}
?>