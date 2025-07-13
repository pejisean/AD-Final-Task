<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . '/envSetter.util.php';
require_once HANDLERS_PATH . '/database.handler.php';
require_once UTILS_PATH . '/database.util.php';
require_once UTILS_PATH . '/auth.util.php';

header('Content-Type: application/json');

try {
    $username = 'john.smith'; // Test with your known username
    
    // Test 1: Database connection
    $connection = ConnectDB();
    if (!$connection) {
        echo json_encode([
            'test' => 'Database Connection',
            'success' => false,
            'message' => 'Failed to connect to database'
        ]);
        exit();
    }
    
    // Test 2: Direct SQL query
    $query = "SELECT username, password, role FROM users WHERE username = $1";
    $result = pg_query_params($connection, $query, [$username]);
    
    if (!$result) {
        echo json_encode([
            'test' => 'Direct SQL Query',
            'success' => false,
            'message' => 'SQL query failed: ' . pg_last_error($connection)
        ]);
        exit();
    }
    
    $user = pg_fetch_assoc($result);
    pg_close($connection);
    
    // Test 3: DatabaseUtil method
    $utilUser = DatabaseUtil::findUserByUsername($username);
    
    // Test 4: Static data fallback
    $staticUsers = require_once '../staticDatas/user.staticData.php';
    $staticUser = null;
    foreach ($staticUsers as $sUser) {
        if ($sUser['username'] === $username) {
            $staticUser = $sUser;
            break;
        }
    }
    
    echo json_encode([
        'database_connection' => 'SUCCESS',
        'direct_sql_user' => $user ?: 'NOT FOUND',
        'database_util_user' => $utilUser ?: 'NOT FOUND',
        'static_data_user' => $staticUser ?: 'NOT FOUND',
        'test_username' => $username
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'test' => 'DEBUG',
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
?>