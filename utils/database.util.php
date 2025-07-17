<?php
require_once UTILS_PATH . 'envSetter.util.php';
require_once HANDLERS_PATH . 'database.handler.php';

class DatabaseUtil {
    
    /**
     * Get database connection
     * @return resource|false
     */
    protected static function getConnection() {
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
                $error_message = pg_last_error($connection);
                pg_close($connection);
                return [
                    'success' => false,
                    'message' => 'Query execution failed: ' . $error_message,
                    'data' => null
                ];
            }
            
            $data = [];
            while ($row = pg_fetch_assoc($result)) {
                $data[] = $row;
            }
            
            // Close the connection afterwards
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
                'message' => 'Database error occurred: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
    
    /**
     * Generate receipt number
     * @return string
     */
    public static function generateReceiptNumber() {
        $date = date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return "RCP-{$date}-{$random}";
    }
    
    /**
     * Generate random delivery address
     * @return string
     */
    public static function generateDeliveryAddress() {
        $streets = ['Wasteland Ave', 'Survivor St', 'Bunker Blvd', 'Scavenger Ln', 'Fortress Dr', 'Outpost Way'];
        $cities = ['New Haven', 'Safe Zone Alpha', 'Sanctuary Hills', 'Trading Post Central', 'Survivor\'s Rest'];
        $zones = ['Zone A', 'Zone B', 'Zone C', 'Sector 7', 'District 9'];
        
        $number = mt_rand(100, 9999);
        $street = $streets[array_rand($streets)];
        $city = $cities[array_rand($cities)];
        $zone = $zones[array_rand($zones)];
        $postcode = mt_rand(10000, 99999);
        
        return "{$number} {$street}, {$city}, {$zone} {$postcode}";
    }
}
?>