<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . '/receipt.util.php';
    require_once UTILS_PATH . '/auth.util.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    
    switch ($method) {
        case 'GET':
            handleGetReceipts();
            break;
        case 'POST':
            handleCreateReceipt($input);
            break;
        case 'PUT':
            handleUpdateReceipt($input);
            break;
        case 'DELETE':
            handleDeleteReceipt($input);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    }
    
} catch (Exception $e) {
    error_log("Receipts handler error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

function handleGetReceipts() {
    $receiptId = $_GET['receipt_id'] ?? null;
    $receiptNumber = $_GET['receipt_number'] ?? null;
    $userId = $_GET['user_id'] ?? null;
    $limit = (int)($_GET['limit'] ?? 20);
    $offset = (int)($_GET['offset'] ?? 0);
    
    // If specific receipt requested
    if ($receiptId) {
        $receipt = ReceiptUtil::findReceiptById($receiptId);
        if ($receipt) {
            // Get receipt items
            $receiptItems = ReceiptUtil::getReceiptItems($receiptId);
            $receipt['items'] = $receiptItems;
            
            echo json_encode([
                'success' => true,
                'data' => $receipt
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Receipt not found']);
        }
        return;
    }
    
    if ($receiptNumber) {
        $receipt = ReceiptUtil::findReceiptByNumber($receiptNumber);
        if ($receipt) {
            $receiptItems = ReceiptUtil::getReceiptItems($receipt['id']);
            $receipt['items'] = $receiptItems;
            
            echo json_encode([
                'success' => true,
                'data' => $receipt
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Receipt not found']);
        }
        return;
    }
    
    // For logged in users, default to their receipts unless they're admin
    if (AuthUtil::isLoggedIn() && !$userId) {
        $currentUser = AuthUtil::getCurrentUser();
        if (!AuthUtil::hasRole('admin')) {
            $userId = $currentUser['id'];
        }
    }
    
    $receipts = ReceiptUtil::getAllReceipts($limit, $offset, $userId);
    
    echo json_encode([
        'success' => true,
        'data' => $receipts,
        'total' => ReceiptUtil::getReceiptCount($userId)
    ]);
}

function handleCreateReceipt($input) {
    // Validate required fields
    $required = ['total_amount', 'shipping_address'];
    foreach ($required as $field) {
        if (!isset($input[$field])) {
            echo json_encode(['success' => false, 'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required']);
            return;
        }
    }
    
    // Get user info if logged in
    $userId = null;
    $sessionToken = null;
    
    if (AuthUtil::isLoggedIn()) {
        $user = AuthUtil::getCurrentUser();
        $userId = $user['id'];
    } else {
        AuthUtil::startSession();
        $sessionToken = 'guest_' . session_id();
    }
    
    // Generate receipt number
    $receiptNumber = ReceiptUtil::generateReceiptNumber();
    
    $receiptData = [
        'receipt_number' => $receiptNumber,
        'user_id' => $userId,
        'session_token' => $sessionToken,
        'total_amount' => (float)$input['total_amount'],
        'tax_amount' => (float)($input['tax_amount'] ?? 0),
        'shipping_address' => $input['shipping_address'],
        'billing_address' => $input['billing_address'] ?? null,
        'payment_method' => $input['payment_method'] ?? 'cash',
        'payment_status' => $input['payment_status'] ?? 'completed',
        'order_status' => $input['order_status'] ?? 'processing',
        'notes' => $input['notes'] ?? null
    ];
    
    $receiptId = ReceiptUtil::createReceipt($receiptData);
    
    if ($receiptId) {
        // Add receipt items if provided
        if (!empty($input['items'])) {
            foreach ($input['items'] as $item) {
                ReceiptUtil::addReceiptItem($receiptId, [
                    'item_id' => $item['item_id'],
                    'item_name' => $item['item_name'],
                    'item_description' => $item['item_description'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                    'seller_name' => $item['seller_name'] ?? null
                ]);
            }
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Receipt created successfully',
            'data' => [
                'receipt_id' => $receiptId,
                'receipt_number' => $receiptNumber
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create receipt']);
    }
}

function handleUpdateReceipt($input) {
    if (!AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Admin access required']);
        return;
    }
    
    if (empty($input['receipt_id'])) {
        echo json_encode(['success' => false, 'message' => 'Receipt ID required']);
        return;
    }
    
    $updateData = array_filter([
        'payment_status' => $input['payment_status'] ?? null,
        'order_status' => $input['order_status'] ?? null,
        'shipping_address' => $input['shipping_address'] ?? null,
        'billing_address' => $input['billing_address'] ?? null,
        'notes' => $input['notes'] ?? null
    ], function($value) { return $value !== null; });
    
    $result = ReceiptUtil::updateReceipt($input['receipt_id'], $updateData);
    
    echo json_encode([
        'success' => $result,
        'message' => $result ? 'Receipt updated successfully' : 'Failed to update receipt'
    ]);
}

function handleDeleteReceipt($input) {
    if (!AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Admin access required']);
        return;
    }
    
    if (empty($input['receipt_id'])) {
        echo json_encode(['success' => false, 'message' => 'Receipt ID required']);
        return;
    }
    
    $result = ReceiptUtil::deleteReceipt($input['receipt_id']);
    
    echo json_encode([
        'success' => $result,
        'message' => $result ? 'Receipt deleted successfully' : 'Failed to delete receipt'
    ]);
}
?>