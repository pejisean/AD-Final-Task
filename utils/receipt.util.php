<?php
require_once UTILS_PATH . 'database.util.php';

class ReceiptUtil extends DatabaseUtil {
    
    /**
     * Create receipt from cart
     * @param string $sessionToken
     * @param int|null $userId
     * @param string $shippingAddress
     * @param string $billingAddress
     * @param string $paymentMethod
     * @return int|false Receipt ID on success, false on failure
     */
    public static function createReceiptFromCart($sessionToken, $userId = null, $shippingAddress = null, $billingAddress = null, $paymentMethod = 'cash') {
        try {
            // Get cart items
            $cartItems = CartUtil::getCartItems($sessionToken, $userId);
            
            if (empty($cartItems)) {
                return false;
            }
            
            // Calculate totals
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item['quantity'] * $item['price_at_time'];
            }
            
            $taxAmount = $totalAmount * 0.10; // 10% tax
            
            // Generate shipping address if not provided
            if (!$shippingAddress) {
                $shippingAddress = self::generateDeliveryAddress();
            }
            
            // Create receipt
            $receiptNumber = self::generateReceiptNumber();
            
            $receiptQuery = "INSERT INTO receipts 
                            (receipt_number, user_id, session_token, total_amount, tax_amount, 
                             shipping_address, billing_address, payment_method) 
                            VALUES ($1, $2, $3, $4, $5, $6, $7, $8) RETURNING id";
            
            $receiptResult = self::executeQuery($receiptQuery, [
                $receiptNumber, $userId, $sessionToken, $totalAmount, $taxAmount,
                $shippingAddress, $billingAddress, $paymentMethod
            ]);
            
            if (!$receiptResult['success'] || empty($receiptResult['data'])) {
                return false;
            }
            
            $receiptId = $receiptResult['data'][0]['id'];
            
            // Create receipt items
            foreach ($cartItems as $item) {
                $itemQuery = "INSERT INTO receipt_items 
                             (receipt_id, item_id, item_name, item_description, quantity, 
                              unit_price, total_price, seller_name) 
                             VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
                
                $totalPrice = $item['quantity'] * $item['price_at_time'];
                
                self::executeQuery($itemQuery, [
                    $receiptId, $item['item_id'], $item['name'], $item['description'],
                    $item['quantity'], $item['price_at_time'], $totalPrice, $item['seller_name']
                ]);
            }
            
            // Clear cart after successful receipt creation
            CartUtil::clearCart($sessionToken);
            
            return $receiptId;
            
        } catch (Exception $e) {
            error_log("Error creating receipt: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Create a receipt
     * @param array $receiptData
     * @return int|false Receipt ID on success, false on failure
     */
    public static function createReceipt($receiptData) {
        $query = "INSERT INTO receipts 
                  (receipt_number, user_id, session_token, total_amount, tax_amount, 
                   shipping_address, billing_address, payment_method, payment_status, order_status, notes) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11) RETURNING id";
        
        $result = self::executeQuery($query, [
            $receiptData['receipt_number'],
            $receiptData['user_id'],
            $receiptData['session_token'],
            $receiptData['total_amount'],
            $receiptData['tax_amount'],
            $receiptData['shipping_address'],
            $receiptData['billing_address'],
            $receiptData['payment_method'],
            $receiptData['payment_status'],
            $receiptData['order_status'],
            $receiptData['notes']
        ]);
        
        return $result['success'] && !empty($result['data']) ? $result['data'][0]['id'] : false;
    }
    
    /**
     * Add item to receipt
     * @param int $receiptId
     * @param array $itemData
     * @return bool
     */
    public static function addReceiptItem($receiptId, $itemData) {
        $query = "INSERT INTO receipt_items 
                  (receipt_id, item_id, item_name, item_description, quantity, unit_price, total_price, seller_name) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        
        $result = self::executeQuery($query, [
            $receiptId,
            $itemData['item_id'],
            $itemData['item_name'],
            $itemData['item_description'],
            $itemData['quantity'],
            $itemData['unit_price'],
            $itemData['total_price'],
            $itemData['seller_name']
        ]);
        
        return $result['success'];
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
     * Get receipt by ID
     * @param int $receiptId
     * @return array|null
     */
    public static function getReceiptById($receiptId) {
        $query = "SELECT r.*, u.username 
                  FROM receipts r
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.id = $1";
        $result = self::executeQuery($query, [$receiptId]);
        
        return $result['success'] && !empty($result['data']) ? $result['data'][0] : null;
    }
    
    /**
     * Get receipt items
     * @param int $receiptId
     * @return array
     */
    public static function getReceiptItems($receiptId) {
        $query = "SELECT * FROM receipt_items WHERE receipt_id = $1 ORDER BY id";
        $result = self::executeQuery($query, [$receiptId]);
        
        return $result['success'] ? $result['data'] : [];
    }
    
    /**
     * Get receipts by user
     * @param int $userId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getReceiptsByUser($userId, $limit = 20, $offset = 0) {
        $query = "SELECT r.*, u.username 
                  FROM receipts r
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.user_id = $1
                  ORDER BY r.created_at DESC
                  LIMIT $2 OFFSET $3";
        $result = self::executeQuery($query, [$userId, $limit, $offset]);
        
        return $result['success'] ? $result['data'] : [];
    }
    
    /**
     * Get all receipts (admin function)
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getAllReceipts($limit = 50, $offset = 0) {
        $query = "SELECT r.*, u.username 
                  FROM receipts r
                  LEFT JOIN users u ON r.user_id = u.id
                  ORDER BY r.created_at DESC
                  LIMIT $1 OFFSET $2";
        $result = self::executeQuery($query, [$limit, $offset]);
        
        return $result['success'] ? $result['data'] : [];
    }
    
    /**
     * Update receipt status
     * @param int $receiptId
     * @param string $orderStatus
     * @param string $paymentStatus
     * @return bool
     */
    public static function updateReceiptStatus($receiptId, $orderStatus = null, $paymentStatus = null) {
        $updateData = [];
        if ($orderStatus) $updateData['order_status'] = $orderStatus;
        if ($paymentStatus) $updateData['payment_status'] = $paymentStatus;
        
        if (empty($updateData)) {
            return false;
        }
        
        $setParts = [];
        $params = [];
        $paramCount = 0;
        
        foreach ($updateData as $field => $value) {
            $paramCount++;
            $setParts[] = "\"$field\" = $" . $paramCount;
            $params[] = $value;
        }
        
        $paramCount++;
        $setParts[] = "updated_at = CURRENT_TIMESTAMP";
        
        $query = "UPDATE receipts SET " . implode(', ', $setParts) . " WHERE id = $" . $paramCount;
        $params[] = $receiptId;
        
        $result = self::executeQuery($query, $params);
        return $result['success'];
    }
    
    /**
     * Get receipt statistics
     * @return array
     */
    public static function getReceiptStats() {
        $query = "SELECT 
                    COUNT(*) as total_receipts,
                    SUM(total_amount) as total_revenue,
                    AVG(total_amount) as average_order_value,
                    COUNT(CASE WHEN order_status = 'delivered' THEN 1 END) as delivered_orders
                  FROM receipts";
        $result = self::executeQuery($query);
        
        if ($result['success'] && !empty($result['data'])) {
            return $result['data'][0];
        }
        
        return [
            'total_receipts' => 0,
            'total_revenue' => 0,
            'average_order_value' => 0,
            'delivered_orders' => 0
        ];
    }
    
    /**
     * Find receipt by receipt number
     * @param string $receiptNumber
     * @return array|null
     */
    public static function findReceiptByNumber($receiptNumber) {
        $query = "SELECT r.*, u.username 
                  FROM receipts r
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.receipt_number = $1";
        $result = self::executeQuery($query, [$receiptNumber]);
        
        return $result['success'] && !empty($result['data']) ? $result['data'][0] : null;
    }

    /**
     * Find receipt by ID
     * @param int $receiptId
     * @return array|null
     */
    public static function findReceiptById($receiptId) {
        return self::getReceiptById($receiptId);
    }

    /**
     * Get receipt count
     * @param int|null $userId
     * @return int
     */
    public static function getReceiptCount($userId = null) {
        if ($userId) {
            $query = "SELECT COUNT(*) as count FROM receipts WHERE user_id = $1";
            $result = self::executeQuery($query, [$userId]);
        } else {
            $query = "SELECT COUNT(*) as count FROM receipts";
            $result = self::executeQuery($query);
        }
        
        return $result['success'] && !empty($result['data']) ? (int)$result['data'][0]['count'] : 0;
    }

    /**
     * Generate delivery address
     * @return string
     */
    public static function generateDeliveryAddress() {
        $addresses = [
            "Safe Zone Alpha-7, Sector 12",
            "Outpost Beta-3, Northern District",
            "Settlement Gamma-9, Eastern Quarter",
            "Bunker Delta-5, Underground Level 2",
            "Trading Post Echo-1, Central Plaza"
        ];
        
        return $addresses[array_rand($addresses)] . " - " . self::generateRandomIP();
    }

    /**
     * Generate random IP
     * @return string
     */
    private static function generateRandomIP() {
        return implode('.', [
            rand(1, 255),
            rand(1, 255),
            rand(1, 255),
            rand(1, 255)
        ]);
    }
}
?>