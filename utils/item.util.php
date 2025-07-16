<?php
require_once UTILS_PATH . 'database.util.php';

class ItemUtil extends DatabaseUtil {
    
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
        $query = "INSERT INTO items (name, description, price, image_url, seller_id, category, stock_quantity, source) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8) RETURNING id";
        
        $params = [
            $itemData['name'],
            $itemData['description'],
            $itemData['price'],
            $itemData['image_url'] ?? null,
            $itemData['seller_id'],
            $itemData['category'] ?? 'general',
            $itemData['stock_quantity'] ?? 1,
            $itemData['source'] ?? 'marketplace'
        ];
        
        $result = self::executeQuery($query, $params);
        
        if ($result['success'] && !empty($result['data'])) {
            return $result['data'][0]['id'];
        }
        
        return false;
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