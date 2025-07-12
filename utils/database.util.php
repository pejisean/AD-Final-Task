<?php
require_once UTILS_PATH . 'envSetter.util.php';

class DatabaseUtil {
    
    /**
     * Get database connection
     * @return resource|false
     */
    private static function getConnection() {
        return ConnectDB();
    }
    
    /**
     * Execute a prepared query with parameters
     * @param string $query
     * @param array $params
     * @return array
     */
    public static function executeQuery($query, $params = []) {
        try {
            $connection = self::getConnection();
            
            if (!$connection) {
                return [
                    'success' => false,
                    'message' => 'Database connection failed',
                    'data' => null
                ];
            }
            
            $result = pg_query_params($connection, $query, $params);
            
            if (!$result) {
                pg_close($connection);
                return [
                    'success' => false,
                    'message' => 'Query execution failed',
                    'data' => null
                ];
            }
            
            $data = [];
            while ($row = pg_fetch_assoc($result)) {
                $data[] = $row;
            }
            
            pg_close($connection);
            
            return [
                'success' => true,
                'message' => 'Query executed successfully',
                'data' => $data
            ];
            
        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error occurred',
                'data' => null
            ];
        }
    }
    
    /**
     * Find user by username
     * @param string $username
     * @return array|null
     */
    public static function findUserByUsername($username) {
        $query = "SELECT username, password, role FROM users WHERE username = $1";
        $result = self::executeQuery($query, [$username]);
        
        if ($result['success'] && !empty($result['data'])) {
            return $result['data'][0];
        }
        
        return null;
    }
    
    /**
     * Create a new user
     * @param string $username
     * @param string $password
     * @param string $role
     * @return bool
     */
    public static function createUser($username, $password, $role = 'user') {
        $query = "INSERT INTO users (username, password, role) VALUES ($1, $2, $3)";
        $result = self::executeQuery($query, [$username, $password, $role]);
        
        return $result['success'];
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
     * Get all users (admin function)
     * @return array
     */
    public static function getAllUsers() {
        $query = "SELECT username, role, created_at FROM users ORDER BY created_at DESC";
        $result = self::executeQuery($query);
        
        return $result['success'] ? $result['data'] : [];
    }
    
    /**
     * Update user role
     * @param string $username
     * @param string $role
     * @return bool
     */
    public static function updateUserRole($username, $role) {
        $query = "UPDATE users SET role = $2 WHERE username = $1";
        $result = self::executeQuery($query, [$username, $role]);
        
        return $result['success'];
    }
    
    /**
     * Delete user
     * @param string $username
     * @return bool
     */
    public static function deleteUser($username) {
        $query = "DELETE FROM users WHERE username = $1";
        $result = self::executeQuery($query, [$username]);
        
        return $result['success'];
    }
}
?>