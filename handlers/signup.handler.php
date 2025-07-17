<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . '/user.util.php';
    require_once UTILS_PATH . '/auth.util.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }

    // Get input data
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        $input = $_POST;
    }

    $username = trim($input['username'] ?? '');
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';
    $gender = $input['gender'] ?? '';

    // Validate required fields
    if (empty($username)) {
        echo json_encode(['success' => false, 'message' => 'Codename is required']);
        exit;
    }

    if (empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Password is required']);
        exit;
    }

    if (empty($gender)) {
        echo json_encode(['success' => false, 'message' => 'Gender is required']);
        exit;
    }

    // Validate username format
    if (strlen($username) < 3) {
        echo json_encode(['success' => false, 'message' => 'Codename must be at least 3 characters']);
        exit;
    }

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        echo json_encode(['success' => false, 'message' => 'Codename can only contain letters, numbers, and underscores']);
        exit;
    }

    // Validate password
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
        exit;
    }

    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        echo json_encode(['success' => false, 'message' => 'Password must include uppercase, lowercase, and a number']);
        exit;
    }

    // Check if username already exists
    if (UserUtil::usernameExists($username)) {
        echo json_encode(['success' => false, 'message' => 'This codename is already taken. Please choose another.']);
        exit;
    }

    // Check if email already exists (if provided)
    if (!empty($email) && UserUtil::emailExists($email)) {
        echo json_encode(['success' => false, 'message' => 'This email is already registered']);
        exit;
    }

    // Create the user
    $result = UserUtil::createUser(
        $username,
        !empty($email) ? $email : null,
        $password, // Note: You might want to hash this in UserUtil::createUser
        $gender,
        'user' // Default role
    );

    if ($result) {
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

} catch (Exception $e) {
    error_log("Signup handler error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred during registration. Please try again.'
    ]);
}
?>