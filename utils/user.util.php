<?php
require_once UTILS_PATH . 'database.util.php';

class UserUtil extends DatabaseUtil {
    
    /**
     * Find user by username
     * @param string $username
     * @return array|null
     */
    public static function findUserByUsername($username) {
        $query = "SELECT id, username, email, password, gender, role, created_at FROM users WHERE username = $1";
        $result = self::executeQuery($query, [$username]);
        
        if ($result['success'] && !empty($result['data'])) {
            return $result['data'][0];
        }
        
        return null;
    }
    
    /**
     * Find user by ID
     * @param int $userId
     * @return array|null
     */
    public static function findUserById($userId) {
        $query = "SELECT id, username, email, gender, role, created_at FROM users WHERE id = $1";
        $result = self::executeQuery($query, [$userId]);
        
        return $result['success'] && !empty($result['data']) ? $result['data'][0] : null;
    }
    
    /**
     * Check if username exists
     * @param string $username
     * @return bool
     */
    public static function usernameExists($username) {
        $user = self::findUserByUsername($username);
        return $user !== null;
    }
    
    /**
     * Check if email exists
     * @param string $email
     * @return bool
     */
    public static function emailExists($email) {
        if (empty($email)) {
            return false;
        }
        
        $query = "SELECT id FROM users WHERE email = $1";
        $result = self::executeQuery($query, [$email]);
        
        return $result['success'] && !empty($result['data']);
    }
    
    /**
     * Create a new user
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $gender
     * @param string $role
     * @return bool
     */
    public static function createUser($username, $email, $password, $gender = null, $role = 'user') {
        $query = "INSERT INTO users (username, email, password, gender, role) VALUES ($1, $2, $3, $4, $5)";
        $result = self::executeQuery($query, [$username, $email, $password, $gender, $role]);
        
        return $result['success'];
    }
}
?>