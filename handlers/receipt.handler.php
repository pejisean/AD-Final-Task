<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . '/receipt.util.php';
    require_once UTILS_PATH . '/cart.util.php';
    require_once UTILS_PATH . '/auth.util.php';

    // Add the missing getSessionToken function
    function getSessionToken() {
        AuthUtil::startSession();
        
        if (AuthUtil::isLoggedIn()) {
            $user = AuthUtil::getCurrentUser();
            return 'user_' . $user['id'] . '_' . md5(session_id() . $user['username']);
        } else {
            return 'guest_' . md5(session_id());
        }
    }

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
        $receipt = ReceiptUtil::getReceiptById($receiptId);
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
    
    if ($userId) {
        $receipts = ReceiptUtil::getReceiptsByUser($userId, $limit, $offset);
    } else {
        $receipts = ReceiptUtil::getAllReceipts($limit, $offset);
    }
    
    echo json_encode([
        'success' => true,
        'data' => $receipts,
        'total' => count($receipts)
    ]);
}

function handleCreateReceipt($input) {
    // Get session token
    $sessionToken = getSessionToken();
    
    // Get user ID if logged in
    $userId = null;
    if (AuthUtil::isLoggedIn()) {
        $user = AuthUtil::getCurrentUser();
        $userId = $user['id'];
    }
    
    // Create receipt
    $receiptId = ReceiptUtil::createReceiptFromCart(
        $sessionToken,
        $userId,
        $input['shipping_address'],
        $input['billing_address'] ?? $input['shipping_address'],
        $input['payment_method'] ?? 'cash'
    );
    
    if ($receiptId) {
        // Get the receipt number
        $receipt = ReceiptUtil::getReceiptById($receiptId);
        
        // Don't clear the session here - let the receipt creation handle cart clearing
        
        echo json_encode([
            'success' => true,
            'message' => 'Receipt created successfully',
            'data' => [
                'receipt_id' => $receiptId,
                'receipt_number' => $receipt['receipt_number'] ?? 'Generated'
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create receipt from cart']);
    }
}

function handleUpdateReceipt($input) {
    if (!AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Admin access required']);
        return;
    }
    
    if (empty($input['receipt_id'])) {
        echo json_encode(['success' => false, 'message' => 'Receipt ID is required']);
        return;
    }
    
    $result = ReceiptUtil::updateReceiptStatus(
        $input['receipt_id'],
        $input['order_status'] ?? null,
        $input['payment_status'] ?? null
    );
    
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
        echo json_encode(['success' => false, 'message' => 'Receipt ID is required']);
        return;
    }
    
    // Implementation would depend on your business logic
    // For now, we'll just return success
    echo json_encode(['success' => true, 'message' => 'Receipt deletion not implemented']);
}
?>