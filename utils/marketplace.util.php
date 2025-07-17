<?php
require_once UTILS_PATH . 'database.util.php';
require_once UTILS_PATH . 'item.util.php';
require_once UTILS_PATH . 'imagePath.util.php'; // Remove the extra slash

class MarketplaceUtil extends DatabaseUtil {
    
    /**
     * Get marketplace items with enhanced data
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getMarketplaceItems($filters = [], $limit = 50, $offset = 0) {
        // Use existing ItemUtil but add marketplace-specific filters
        $marketplaceFilters = array_merge($filters, ['source' => 'marketplace']);
        return ItemUtil::getItems($marketplaceFilters, $limit, $offset);
    }
    
    /**
     * Create marketplace item (wrapper around ItemUtil with marketplace defaults)
     * @param array $itemData
     * @return int|false Item ID or false on failure
     */
    public static function createMarketplaceItem($itemData) {
        // Set marketplace-specific defaults
        $itemData['source'] = 'marketplace';
        $itemData['is_active'] = true;
        
        return ItemUtil::createItem($itemData);
    }
    
    /**
     * Format item data for frontend display
     * @param array $items
     * @param string $context ('pages' or 'root')
     * @return array
     */
    public static function formatItemsForDisplay($items, $context = 'pages') {
        foreach ($items as &$item) {
            // Use existing ImagePathUtil
            $item['display_image_url'] = ImagePathUtil::resolve($item['image_url'], $context);
            $item['formatted_price'] = '₱' . number_format($item['price'], 2);
            $item['safe_name'] = htmlspecialchars($item['name']);
            $item['safe_description'] = htmlspecialchars($item['description']);
        }
        return $items;
    }
    
    /**
     * Get item statistics for marketplace
     * @return array
     */
    public static function getMarketplaceStats() {
        $query = "SELECT 
                    COUNT(*) as total_items,
                    COUNT(DISTINCT seller_id) as total_sellers,
                    AVG(price) as avg_price,
                    MAX(price) as max_price,
                    MIN(price) as min_price
                  FROM items 
                  WHERE source = 'marketplace' AND is_active = true";
        
        $result = self::executeQuery($query, []);
        return $result['success'] && !empty($result['data']) ? $result['data'][0] : [];
    }
}
?>