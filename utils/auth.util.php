<?php
require_once UTILS_PATH . '/database.util.php';

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
            // Use DatabaseUtil to find user
            $user = DatabaseUtil::findUserByUsername($username);
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Invalid username or password'
                ];
            }
            
            // Verify password (plain text for now)
            // TODO: Implement password_verify() for hashed passwords
            if ($user['password'] === $password) {
                // Set session variables
                $_SESSION['user_id'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['logged_in'] = true;
                $_SESSION['login_time'] = time();
                
                return [
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'username' => $user['username'],
                        'role' => $user['role']
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
     * Register a new user
     * @param string $username
     * @param string $password
     * @param string $role
     * @return array
     */
    public static function register($username, $password, $role = 'user') {
        try {
            // Check if username already exists
            if (DatabaseUtil::usernameExists($username)) {
                return [
                    'success' => false,
                    'message' => 'Username already exists'
                ];
            }
            
            // TODO: Hash password for security
            // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Create new user
            $success = DatabaseUtil::createUser($username, $password, $role);
            
            if ($success) {
                return [
                    'success' => true,
                    'message' => 'User registered successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to register user'
                ];
            }
            
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred during registration'
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
     * Get current logged in user info
     * @return array|null
     */
    public static function getCurrentUser() {
        self::startSession();
        if (self::isLoggedIn()) {
            return [
                'username' => $_SESSION['user_id'],
                'role' => $_SESSION['user_role']
            ];
        }
        return null;
    }
    
    /**
     * Logout user
     */
    public static function logout() {
        self::startSession();
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
    }
    
    /**
     * Require login - redirect to login page if not logged in
     * @param string $redirectTo
     */
    public static function requireLogin($redirectTo = 'pages/login.php') {
        if (!self::isLoggedIn()) {
            header("Location: " . $redirectTo);
            exit();
        }
    }
    
    /**
     * Check if user has specific role
     * @param string $role
     * @return bool
     */
    public static function hasRole($role) {
        self::startSession();
        return self::isLoggedIn() && $_SESSION['user_role'] === $role;
    }
}