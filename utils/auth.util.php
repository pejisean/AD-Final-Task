<?php
require_once BASE_PATH . '/handlers/postgreChecker.handler.php';

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
        
        // TODO: Replace with actual database query
        // For now, using static data
        $staticUsers = require_once DUMMIES_PATH . '/user.staticData.php';
        
        foreach ($staticUsers as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
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
            }
        }
        
        return [
            'success' => false,
            'message' => 'Invalid username or password'
        ];
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