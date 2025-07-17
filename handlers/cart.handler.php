<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . '/cart.util.php';
    require_once UTILS_PATH . '/auth.util.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    
    // Get session token (either from logged in user or session)
    $sessionToken = getSessionToken();
    
    switch ($method) {
        case 'GET':
            handleGetCart($sessionToken);
            break;
        case 'POST':
            handleAddToCart($input, $sessionToken);
            break;
        case 'PUT':
            handleUpdateCartItem($input, $sessionToken);
            break;
        case 'DELETE':
            handleRemoveFromCart($input, $sessionToken);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    }
    
} catch (Exception $e) {
    error_log("Cart handler error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

function getSessionToken() {
    AuthUtil::startSession();
    
    if (AuthUtil::isLoggedIn()) {
        $user = AuthUtil::getCurrentUser();
        return 'user_' . $user['id'] . '_' . session_id();
    } else {
        return 'guest_' . session_id();
    }
}

function handleGetCart($sessionToken) {
    $cartItems = CartUtil::getCartItems($sessionToken);
    $total = CartUtil::getCartTotal($sessionToken);
    $itemCount = CartUtil::getCartItemCount($sessionToken);
    
    echo json_encode([
        'success' => true,
        'data' => [
            'items' => $cartItems,
            'total' => $total,
            'item_count' => $itemCount,
            'session_token' => $sessionToken
        ]
    ]);
}

function handleAddToCart($input, $sessionToken) {
    // Validate required fields
    if (empty($input['item_id']) && empty($input['item_name'])) {
        echo json_encode(['success' => false, 'message' => 'Item ID or Item Name is required']);
        return;
    }
    
    $itemId = null;
    
    // If item_id is provided, use it
    if (!empty($input['item_id'])) {
        $itemId = (int)$input['item_id'];
    } 
    // If only item_name is provided, try to find or create the item
    else if (!empty($input['item_name'])) {
        require_once UTILS_PATH . '/item.util.php';
        $price = (float)($input['item_price'] ?? 0);
        $itemId = ItemUtil::getOrCreateItemByName($input['item_name'], $price, 'shop');
        
        if (!$itemId) {
            echo json_encode(['success' => false, 'message' => 'Could not find or create item']);
            return;
        }
    }
    
    $quantity = (int)($input['quantity'] ?? 1);
    
    if ($quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Quantity must be greater than 0']);
        return;
    }
    
    // Get current user ID if logged in
    $userId = null;
    if (AuthUtil::isLoggedIn()) {
        $user = AuthUtil::getCurrentUser();
        $userId = $user['id'];
    }
    
    $result = CartUtil::addToCart($sessionToken, $userId, $itemId, $quantity);
    
    echo json_encode([
        'success' => $result,
        'message' => $result ? 'Item added to cart' : 'Failed to add item to cart'
    ]);
}

function handleUpdateCartItem($input, $sessionToken) {
    if (empty($input['item_id']) || !isset($input['quantity'])) {
        echo json_encode(['success' => false, 'message' => 'Item ID and quantity are required']);
        return;
    }
    
    $itemId = (int)$input['item_id'];
    $quantity = (int)$input['quantity'];
    
    if ($quantity <= 0) {
        // If quantity is 0 or negative, remove the item
        $result = CartUtil::removeFromCart($sessionToken, $itemId);
        $message = $result ? 'Item removed from cart' : 'Failed to remove item';
    } else {
        $result = CartUtil::updateCartItemQuantity($sessionToken, $itemId, $quantity);
        $message = $result ? 'Cart updated' : 'Failed to update cart';
    }
    
    echo json_encode([
        'success' => $result,
        'message' => $message
    ]);
}

function handleRemoveFromCart($input, $sessionToken) {
    error_log("handleRemoveFromCart called with: " . print_r($input, true)); // Debug log
    
    if (empty($input['item_id'])) {
        echo json_encode(['success' => false, 'message' => 'Item ID is required']);
        return;
    }
    
    $itemId = (int)$input['item_id'];
    
    if (isset($input['clear_all']) && $input['clear_all']) {
        // Clear entire cart
        $result = CartUtil::clearCart($sessionToken);
        $message = $result ? 'Cart cleared' : 'Failed to clear cart';
    } else {
        // Remove specific item
        $result = CartUtil::removeFromCart($sessionToken, $itemId);
        $message = $result ? 'Item removed from cart' : 'Failed to remove item';
    }
    
    error_log("Remove result: " . ($result ? 'SUCCESS' : 'FAILED') . " - " . $message); // Debug log
    
    echo json_encode([
        'success' => $result,
        'message' => $message
    ]);
}
?>