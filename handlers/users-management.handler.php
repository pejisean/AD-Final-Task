<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . '/user.util.php';
    require_once UTILS_PATH . '/auth.util.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    
    switch ($method) {
        case 'GET':
            handleGetUsers();
            break;
        case 'POST':
            handleCreateUser($input);
            break;
        case 'PUT':
            handleUpdateUser($input);
            break;
        case 'DELETE':
            handleDeleteUser($input);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    }
    
} catch (Exception $e) {
    error_log("Users handler error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

function handleGetUsers() {
    // Check permissions
    if (!AuthUtil::isLoggedIn()) {
        echo json_encode(['success' => false, 'message' => 'Must be logged in']);
        return;
    }
    
    $currentUser = AuthUtil::getCurrentUser();
    $userId = $_GET['user_id'] ?? null;
    $username = $_GET['username'] ?? null;
    
    // If specific user requested
    if ($userId) {
        // Users can view their own profile, admins can view any profile
        if ($userId != $currentUser['id'] && !AuthUtil::hasRole('admin')) {
            echo json_encode(['success' => false, 'message' => 'Not authorized']);
            return;
        }
        
        $user = UserUtil::findUserById($userId);
        if ($user) {
            // Remove sensitive data for non-admin users
            if (!AuthUtil::hasRole('admin')) {
                unset($user['password']);
            }
            echo json_encode(['success' => true, 'data' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
        return;
    }
    
    if ($username) {
        $user = UserUtil::findUserByUsername($username);
        if ($user) {
            // Only return public info for non-admin users
            if (!AuthUtil::hasRole('admin')) {
                $user = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'created_at' => $user['created_at']
                ];
            }
            echo json_encode(['success' => true, 'data' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
        return;
    }
    
    // List users (admin only)
    if (!AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Admin access required']);
        return;
    }
    
    $limit = (int)($_GET['limit'] ?? 20);
    $offset = (int)($_GET['offset'] ?? 0);
    $role = $_GET['role'] ?? null;
    
    $users = UserUtil::getAllUsers($limit, $offset, $role);
    
    echo json_encode([
        'success' => true,
        'data' => $users,
        'total' => UserUtil::getUserCount($role)
    ]);
}

function handleCreateUser($input) {
    // Only admins can create users through this endpoint
    if (!AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Admin access required']);
        return;
    }
    
    // Validate required fields
    $required = ['username', 'password'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => ucfirst($field) . ' is required']);
            return;
        }
    }
    
    // Check if username already exists
    if (UserUtil::usernameExists($input['username'])) {
        echo json_encode(['success' => false, 'message' => 'Username already exists']);
        return;
    }
    
    // Check if email already exists (if provided)
    if (!empty($input['email']) && UserUtil::emailExists($input['email'])) {
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
        return;
    }
    
    $result = UserUtil::createUser(
        $input['username'],
        $input['email'] ?? null,
        $input['password'], // TODO: Hash password
        $input['gender'] ?? null,
        $input['role'] ?? 'user'
    );
    
    echo json_encode([
        'success' => $result,
        'message' => $result ? 'User created successfully' : 'Failed to create user'
    ]);
}

function handleUpdateUser($input) {
    if (!AuthUtil::isLoggedIn()) {
        echo json_encode(['success' => false, 'message' => 'Must be logged in']);
        return;
    }
    
    if (empty($input['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User ID required']);
        return;
    }
    
    $currentUser = AuthUtil::getCurrentUser();
    $targetUserId = $input['user_id'];
    
    // Users can update their own profile, admins can update any profile
    if ($targetUserId != $currentUser['id'] && !AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Not authorized']);
        return;
    }
    
    // Non-admin users cannot change role
    $updateData = [];
    if (!empty($input['email'])) $updateData['email'] = $input['email'];
    if (!empty($input['gender'])) $updateData['gender'] = $input['gender'];
    if (!empty($input['password'])) $updateData['password'] = $input['password']; // TODO: Hash password
    
    // Only admins can change roles
    if (AuthUtil::hasRole('admin') && isset($input['role'])) {
        $updateData['role'] = $input['role'];
    }
    
    if (empty($updateData)) {
        echo json_encode(['success' => false, 'message' => 'No valid fields to update']);
        return;
    }
    
    // Check if email already exists (if being updated)
    if (isset($updateData['email'])) {
        $existingUser = UserUtil::findUserByEmail($updateData['email']);
        if ($existingUser && $existingUser['id'] != $targetUserId) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            return;
        }
    }
    
    $result = UserUtil::updateUser($targetUserId, $updateData);
    
    echo json_encode([
        'success' => $result,
        'message' => $result ? 'User updated successfully' : 'Failed to update user'
    ]);
}

function handleDeleteUser($input) {
    if (!AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Admin access required']);
        return;
    }
    
    if (empty($input['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User ID required']);
        return;
    }
    
    $currentUser = AuthUtil::getCurrentUser();
    
    // Prevent admin from deleting themselves
    if ($input['user_id'] == $currentUser['id']) {
        echo json_encode(['success' => false, 'message' => 'Cannot delete your own account']);
        return;
    }
    
    $result = UserUtil::deleteUser($input['user_id']);
    
    echo json_encode([
        'success' => $result,
        'message' => $result ? 'User deleted successfully' : 'Failed to delete user'
    ]);
}
?>