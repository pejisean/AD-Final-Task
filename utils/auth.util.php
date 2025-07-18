<?php
require_once UTILS_PATH . 'user.util.php';

class AuthUtil {
    
    /**
     * Start session if not already started
     */
    public static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Authenticate user with username and password
     * @param string $username
     * @param string $password
     * @return array
     */
    public static function login($username, $password) {
        self::startSession();
        
        try {
            // Use UserUtil to find user
            $user = UserUtil::findUserByUsername($username);
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Invalid username or password'
                ];
            }
            
            // Verify password (plain text for now)
            if ($user['password'] === $password) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                // Set session variables with consistent naming
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'] ?? null;
                $_SESSION['role'] = $user['role'] ?? 'user';
                $_SESSION['user_role'] = $user['role'] ?? 'user'; // Add this for backward compatibility
                $_SESSION['logged_in'] = true;
                $_SESSION['login_time'] = time();
                
                return [
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'] ?? null,
                        'role' => $user['role'] ?? 'user'
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Invalid username or password'
                ];
            }
            
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred during login'
            ];
        }
    }
    
    /**
     * Check if user is logged in
     * @return bool
     */
    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Check if user has specific role
     * @param string $role
     * @return bool
     */
    public static function hasRole($role) {
        self::startSession();
        if (!self::isLoggedIn()) {
            return false;
        }
        
        // Check both possible session keys for backward compatibility, with proper null checking
        $userRole = 'user'; // Default fallback
        if (isset($_SESSION['user_role'])) {
            $userRole = $_SESSION['user_role'];
        } elseif (isset($_SESSION['role'])) {
            $userRole = $_SESSION['role'];
        }
        
        return $userRole === $role;
    }
    
    /**
     * Get current logged in user info
     * @return array|null
     */
    public static function getCurrentUser() {
        self::startSession();
        if (self::isLoggedIn()) {
            // Ensure all required session variables exist with fallbacks
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
                return null;
            }
            
            // Get role with proper fallback - fix the undefined key issue
            $role = 'user'; // default role
            if (isset($_SESSION['role'])) {
                $role = $_SESSION['role'];
            } elseif (isset($_SESSION['user_role'])) {
                $role = $_SESSION['user_role'];
            }
            
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email'] ?? null,
                'role' => $role
            ];
        }
        return null;
    }
    
    /**
     * Logout user
     */
    public static function logout() {
        self::startSession();
        
        // Clear all session variables
        $_SESSION = array();
        
        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session
        session_destroy();
    }
}
?>