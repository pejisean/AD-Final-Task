<?php
require_once UTILS_PATH . 'database.util.php';

class CartUtil extends DatabaseUtil {
    
    /**
     * Add item to cart
     * @param string $sessionToken
     * @param int $itemId
     * @param int $quantity
     * @param int|null $userId
     * @return bool
     */
    public static function addToCart($sessionToken, $itemId, $quantity = 1, $userId = null) {
        // Get current item price
        $itemQuery = "SELECT price FROM items WHERE id = $1 AND is_active = true";
        $itemResult = self::executeQuery($itemQuery, [$itemId]);
        
        if (!$itemResult['success'] || empty($itemResult['data'])) {
            return false;
        }
        
        $price = $itemResult['data'][0]['price'];
        
        // Insert or update cart item
        $query = "INSERT INTO cart (session_token, user_id, item_id, quantity, price_at_time) 
                  VALUES ($1, $2, $3, $4, $5)
                  ON CONFLICT (session_token, item_id) 
                  DO UPDATE SET 
                    quantity = cart.quantity + $4, 
                    updated_at = CURRENT_TIMESTAMP";
        
        $result = self::executeQuery($query, [$sessionToken, $userId, $itemId, $quantity, $price]);
        return $result['success'];
    }
    
    /**
     * Get cart items
     * @param string $sessionToken
     * @param int|null $userId
     * @return array
     */
    public static function getCartItems($sessionToken, $userId = null) {
        $query = "SELECT c.*, i.name, i.description, i.image_url, i.stock_quantity,
                         u.username as seller_name
                  FROM cart c
                  JOIN items i ON c.item_id = i.id
                  LEFT JOIN users u ON i.seller_id = u.id
                  WHERE c.session_token = $1";
        $params = [$sessionToken];
        
        if ($userId) {
            $query .= " AND c.user_id = $2";
            $params[] = $userId;
        }
        
        $query .= " ORDER BY c.added_at DESC";
        
        $result = self::executeQuery($query, $params);
        return $result['success'] ? $result['data'] : [];
    }
    
    /**
     * Update cart item quantity
     * @param string $sessionToken
     * @param int $itemId
     * @param int $quantity
     * @return bool
     */
    public static function updateCartItemQuantity($sessionToken, $itemId, $quantity) {
        if ($quantity <= 0) {
            return self::removeFromCart($sessionToken, $itemId);
        }
        
        $query = "UPDATE cart SET quantity = $3, updated_at = CURRENT_TIMESTAMP 
                  WHERE session_token = $1 AND item_id = $2";
        $result = self::executeQuery($query, [$sessionToken, $itemId, $quantity]);
        
        return $result['success'];
    }
    
    /**
     * Remove item from cart
     * @param string $sessionToken
     * @param int $itemId
     * @return bool
     */
    public static function removeFromCart($sessionToken, $itemId) {
        $query = "DELETE FROM cart WHERE session_token = $1 AND item_id = $2";
        $result = self::executeQuery($query, [$sessionToken, $itemId]);
        
        return $result['success'];
    }
    
    /**
     * Clear entire cart
     * @param string $sessionToken
     * @return bool
     */
    public static function clearCart($sessionToken) {
        $query = "DELETE FROM cart WHERE session_token = $1";
        $result = self::executeQuery($query, [$sessionToken]);
        
        return $result['success'];
    }
    
    /**
     * Get cart total
     * @param string $sessionToken
     * @return float
     */
    public static function getCartTotal($sessionToken) {
        $query = "SELECT SUM(quantity * price_at_time) as total 
                  FROM cart 
                  WHERE session_token = $1";
        $result = self::executeQuery($query, [$sessionToken]);
        
        if ($result['success'] && !empty($result['data'])) {
            return (float)($result['data'][0]['total'] ?? 0);
        }
        
        return 0.0;
    }
    
    /**
     * Get cart item count
     * @param string $sessionToken
     * @return int
     */
    public static function getCartItemCount($sessionToken) {
        $query = "SELECT SUM(quantity) as total_items 
                  FROM cart 
                  WHERE session_token = $1";
        $result = self::executeQuery($query, [$sessionToken]);
        
        if ($result['success'] && !empty($result['data'])) {
            return (int)($result['data'][0]['total_items'] ?? 0);
        }
        
        return 0;
    }
    
    /**
     * Clear all cart items for a user
     * @param int $userId
     * @return bool
     */
    public static function clearAllUserSessions($userId) {
        $query = "DELETE FROM cart WHERE user_id = $1";
        $result = self::executeQuery($query, [$userId]);
        return $result['success'];
    }
}
?>