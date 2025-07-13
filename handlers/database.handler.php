<?php
require_once UTILS_PATH . '/envSetter.util.php';

function ConnectDB() {
    global $pgConfig;
    
    try {
        $connectionString = sprintf(
            "host=%s port=%s dbname=%s user=%s password=%s",
            $pgConfig['pg_host'],
            $pgConfig['pg_port'],
            $pgConfig['pg_db'],
            $pgConfig['pg_user'],
            $pgConfig['pg_pass']
        );
        
        $connection = pg_connect($connectionString);
        
        if (!$connection) {
            error_log("PostgreSQL connection failed");
            return false;
        }
        
        return $connection;
    } catch (Exception $e) {
        error_log("PostgreSQL connection error: " . $e->getMessage());
        return false;
    }
}
?>