<?php
require_once UTILS_PATH . 'database.util.php';

class ItemUtil extends DatabaseUtil {
    
    /**
     * Find item by name (for legacy support)
     * @param string $name
     * @return array|null
     */
    public static function findItemByName($name) {
        $query = "SELECT id, name, description, price, image_url, seller_id, category, stock_quantity, is_active, source, created_at 
                  FROM items 
                  WHERE name = $1 AND is_active = true 
                  LIMIT 1";
        $result = self::executeQuery($query, [$name]);
        
        return $result['success'] && !empty($result['data']) ? $result['data'][0] : null;
    }
    
    /**
     * Get or create item by name (for adding from product pages)
     * @param string $name
     * @param float $price
     * @param string $source
     * @return int|null Item ID
     */
    public static function getOrCreateItemByName($name, $price, $source = 'shop') {
        // First try to find existing item
        $existing = self::findItemByName($name);
        if ($existing) {
            return $existing['id'];
        }
        
        // Create new item if not found
        $query = "INSERT INTO items (name, description, price, seller_id, category, stock_quantity, is_active, source) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8) 
                  RETURNING id";
        
        $result = self::executeQuery($query, [
            $name,
            "Auto-generated item from shop",
            $price,
            1, // Default seller (admin)
            'general',
            99,
            true,
            $source
        ]);
        
        return $result['success'] && !empty($result['data']) ? $result['data'][0]['id'] : null;
    }
    
    /**
     * Get all items with filters and pagination
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getItems($filters = [], $limit = 20, $offset = 0) {
        $query = "SELECT i.*, u.username as seller_name 
                  FROM items i 
                  LEFT JOIN users u ON i.seller_id = u.id 
                  WHERE i.is_active = true";
        $params = [];
        $paramCount = 0;
        
        // Add filters
        if (!empty($filters['category'])) {
            $paramCount++;
            $query .= " AND i.category = $" . $paramCount;
            $params[] = $filters['category'];
        }
        
        if (!empty($filters['source'])) {
            $paramCount++;
            $query .= " AND i.source = $" . $paramCount;
            $params[] = $filters['source'];
        }
        
        if (!empty($filters['seller_id'])) {
            $paramCount++;
            $query .= " AND i.seller_id = $" . $paramCount;
            $params[] = $filters['seller_id'];
        }
        
        if (isset($filters['min_price'])) {
            $paramCount++;
            $query .= " AND i.price >= $" . $paramCount;
            $params[] = $filters['min_price'];
        }
        
        if (isset($filters['max_price'])) {
            $paramCount++;
            $query .= " AND i.price <= $" . $paramCount;
            $params[] = $filters['max_price'];
        }
        
        $query .= " ORDER BY i.created_at DESC";
        
        if ($limit > 0) {
            $paramCount++;
            $query .= " LIMIT $" . $paramCount;
            $params[] = $limit;
            
            $paramCount++;
            $query .= " OFFSET $" . $paramCount;
            $params[] = $offset;
        }
        
        $result = self::executeQuery($query, $params);
        return $result['success'] ? $result['data'] : [];
    }
    
    /**
     * Get item by ID
     * @param int $itemId
     * @return array|null
     */
    public static function getItemById($itemId) {
        $query = "SELECT i.*, u.username as seller_name 
                  FROM items i 
                  LEFT JOIN users u ON i.seller_id = u.id 
                  WHERE i.id = $1";
        $result = self::executeQuery($query, [$itemId]);
        
        return $result['success'] && !empty($result['data']) ? $result['data'][0] : null;
    }
    
    /**
     * Create new item
     * @param array $itemData
     * @return int|false Item ID on success, false on failure
     */
    public static function createItem($itemData) {
        error_log("ItemUtil::createItem called with: " . json_encode($itemData));
        
        $query = "INSERT INTO items (name, description, price, image_url, seller_id, category, stock_quantity, source, is_active) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9) RETURNING id";
        
        $params = [
            $itemData['name'],
            $itemData['description'],
            $itemData['price'],
            $itemData['image_url'] ?? null,
            $itemData['seller_id'],
            $itemData['category'] ?? 'general',
            $itemData['stock_quantity'] ?? 1,
            $itemData['source'] ?? 'marketplace',
            true // is_active
        ];
        
        error_log("SQL Query: " . $query);
        error_log("SQL Params: " . json_encode($params));
        
        try {
            $result = self::executeQuery($query, $params);
            
            error_log("executeQuery result: " . json_encode($result));
            
            if ($result['success'] && !empty($result['data'])) {
                $itemId = $result['data'][0]['id'];
                error_log("Item created successfully with ID: " . $itemId);
                return (int)$itemId;
            } else {
                error_log("executeQuery failed or returned no data");
                error_log("Result details: " . json_encode($result));
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in createItem: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
    
    /**
     * Update item
     * @param int $itemId
     * @param array $updateData
     * @return bool
     */
    public static function updateItem($itemId, $updateData) {
        $allowedFields = ['name', 'description', 'price', 'image_url', 'category', 'stock_quantity', 'is_active'];
        $setParts = [];
        $params = [];
        $paramCount = 0;
        
        foreach ($updateData as $field => $value) {
            if (in_array($field, $allowedFields)) {
                $paramCount++;
                $setParts[] = "\"$field\" = $" . $paramCount;
                $params[] = $value;
            }
        }
        
        if (empty($setParts)) {
            return false;
        }
        
        $paramCount++;
        $setParts[] = "updated_at = CURRENT_TIMESTAMP";
        
        $query = "UPDATE items SET " . implode(', ', $setParts) . " WHERE id = $" . $paramCount;
        $params[] = $itemId;
        
        $result = self::executeQuery($query, $params);
        return $result['success'];
    }
    
    /**
     * Delete item (soft delete)
     * @param int $itemId
     * @return bool
     */
    public static function deleteItem($itemId) {
        return self::updateItem($itemId, ['is_active' => false]);
    }
    
    /**
     * Update stock quantity
     * @param int $itemId
     * @param int $newQuantity
     * @return bool
     */
    public static function updateStock($itemId, $newQuantity) {
        return self::updateItem($itemId, ['stock_quantity' => $newQuantity]);
    }
    
    /**
     * Get categories with item counts
     * @return array
     */
    public static function getCategories() {
        $query = "SELECT category, COUNT(*) as item_count 
                  FROM items 
                  WHERE is_active = true 
                  GROUP BY category 
                  ORDER BY category";
        $result = self::executeQuery($query);
        
        return $result['success'] ? $result['data'] : [];
    }
    
    /**
     * Get items by seller
     * @param int $sellerId
     * @return array
     */
    public static function getItemsBySeller($sellerId) {
        return self::getItems(['seller_id' => $sellerId], 100, 0);
    }
}
?>