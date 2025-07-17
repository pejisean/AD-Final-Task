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

        // Use the same connection method as the seeder utilities
        $dsn = "pgsql:host={$pgConfig['pg_host']};port={$pgConfig['pg_port']};dbname={$pgConfig['pg_db']}";
        $pdo = new PDO($dsn, $pgConfig['pg_user'], $pgConfig['pg_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        // Check if username already exists
        $checkQuery = "SELECT username FROM users WHERE username = ?";
        $stmt = $pdo->prepare($checkQuery);
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'This codename is already taken. Please choose another.'
            ]);
            exit();
        }

        // Check if email already exists (if provided)
        if (!empty($email)) {
            $emailCheckQuery = "SELECT email FROM users WHERE email = ?";
            $emailStmt = $pdo->prepare($emailCheckQuery);
            $emailStmt->execute([$email]);
            
            if ($emailStmt->rowCount() > 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'This email is already registered'
                ]);
                exit();
            }
        }

        // Hash the password properly
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create the user with prepared statement
        $insertQuery = "INSERT INTO users (username, email, password, gender, role, is_active) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertResult = $insertStmt->execute([
            $username,
            !empty($email) ? $email : null,
            $hashedPassword,
            $gender,
            'user',
            true
        ]);

        if ($insertResult) {
            echo json_encode([
                'success' => true,
                'message' => 'Account created successfully! You can now log in.'
            ]);
        } else {
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

} catch (PDOException $e) {
    error_log("Database error in signup: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred. Please try again.'
    ]);
} catch (Error $e) {
    error_log("Fatal Error in signup: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred. Please try again.'
    ]);
} catch (Exception $e) {
    error_log("Exception in signup: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again.'
    ]);
}
?>