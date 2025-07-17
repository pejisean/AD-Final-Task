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
    
    /**
     * Find user by email
     * @param string $email
     * @return array|null
     */
    public static function findUserByEmail($email) {
        if (empty($email)) {
            return null;
        }
        
        $query = "SELECT id, username, email, gender, role, created_at FROM users WHERE email = $1";
        $result = self::executeQuery($query, [$email]);
        
        return $result['success'] && !empty($result['data']) ? $result['data'][0] : null;
    }
    
    /**
     * Get all users with pagination
     * @param int $limit
     * @param int $offset
     * @param string|null $role
     * @return array
     */
    public static function getAllUsers($limit = 20, $offset = 0, $role = null) {
        $query = "SELECT id, username, email, gender, role, created_at FROM users";
        $params = [];
        
        if ($role) {
            $query .= " WHERE role = $1";
            $params[] = $role;
            $query .= " ORDER BY created_at DESC LIMIT $2 OFFSET $3";
            $params[] = $limit;
            $params[] = $offset;
        } else {
            $query .= " ORDER BY created_at DESC LIMIT $1 OFFSET $2";
            $params[] = $limit;
            $params[] = $offset;
        }
        
        $result = self::executeQuery($query, $params);
        return $result['success'] ? $result['data'] : [];
    }
    
    /**
     * Get user count
     * @param string|null $role
     * @return int
     */
    public static function getUserCount($role = null) {
        $query = "SELECT COUNT(*) as count FROM users";
        $params = [];
        
        if ($role) {
            $query .= " WHERE role = $1";
            $params[] = $role;
        }
        
        $result = self::executeQuery($query, $params);
        return $result['success'] && !empty($result['data']) ? (int)$result['data'][0]['count'] : 0;
    }
    
    /**
     * Update user
     * @param int $userId
     * @param array $updateData
     * @return bool
     */
    public static function updateUser($userId, $updateData) {
        if (empty($updateData)) {
            return false;
        }
        
        $setParts = [];
        $params = [];
        $paramIndex = 1;
        
        foreach ($updateData as $field => $value) {
            $setParts[] = "$field = $$paramIndex";
            $params[] = $value;
            $paramIndex++;
        }
        
        $params[] = $userId; // Add userId as last parameter
        
        $query = "UPDATE users SET " . implode(', ', $setParts) . " WHERE id = $$paramIndex";
        $result = self::executeQuery($query, $params);
        
        return $result['success'];
    }
    
    /**
     * Delete user
     * @param int $userId
     * @return bool
     */
    public static function deleteUser($userId) {
        $query = "DELETE FROM users WHERE id = $1";
        $result = self::executeQuery($query, [$userId]);
        
        return $result['success'];
    }
}
?>