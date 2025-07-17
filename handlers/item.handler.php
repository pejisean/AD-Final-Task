<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . '/item.util.php';
    require_once UTILS_PATH . '/auth.util.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    
    switch ($method) {
        case 'GET':
            handleGetItems();
            break;
        case 'POST':
            handleCreateItem($input);
            break;
        case 'PUT':
            handleUpdateItem($input);
            break;
        case 'DELETE':
            handleDeleteItem($input);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    }
    
} catch (Exception $e) {
    error_log("Items handler error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

function handleGetItems() {
    $category = $_GET['category'] ?? null;
    $seller_id = $_GET['seller_id'] ?? null;
    $search = $_GET['search'] ?? null;
    $limit = (int)($_GET['limit'] ?? 20);
    $offset = (int)($_GET['offset'] ?? 0);
    $source = $_GET['source'] ?? null; // 'marketplace' or 'shop'
    
    $items = ItemUtil::getAllItems($limit, $offset, $category, $seller_id, $search, $source);
    
    echo json_encode([
        'success' => true,
        'data' => $items,
        'total' => ItemUtil::getItemCount($category, $seller_id, $search, $source)
    ]);
}

function handleCreateItem($input) {
    // Check if user is logged in
    if (!AuthUtil::isLoggedIn()) {
        echo json_encode(['success' => false, 'message' => 'Must be logged in to create items']);
        return;
    }
    
    $currentUser = AuthUtil::getCurrentUser();
    
    // Validate required fields
    $required = ['name', 'description', 'price'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => ucfirst($field) . ' is required']);
            return;
        }
    }
    
    $itemData = [
        'name' => $input['name'],
        'description' => $input['description'],
        'price' => (float)$input['price'],
        'image_url' => $input['image_url'] ?? null,
        'seller_id' => $currentUser['id'],
        'category' => $input['category'] ?? 'general',
        'stock_quantity' => (int)($input['stock_quantity'] ?? 1),
        'source' => $input['source'] ?? 'marketplace'
    ];
    
    $result = ItemUtil::createItem($itemData);
    
    echo json_encode([
        'success' => $result !== false,
        'message' => $result !== false ? 'Item created successfully' : 'Failed to create item',
        'item_id' => $result // Return the created item ID
    ]);
}

function handleUpdateItem($input) {
    if (!AuthUtil::isLoggedIn()) {
        echo json_encode(['success' => false, 'message' => 'Must be logged in']);
        return;
    }
    
    if (empty($input['item_id'])) {
        echo json_encode(['success' => false, 'message' => 'Item ID required']);
        return;
    }
    
    $currentUser = AuthUtil::getCurrentUser();
    $item = ItemUtil::findItemById($input['item_id']);
    
    if (!$item) {
        echo json_encode(['success' => false, 'message' => 'Item not found']);
        return;
    }
    
    // Check if user owns the item or is admin
    if ($item['seller_id'] != $currentUser['id'] && !AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Not authorized to update this item']);
        return;
    }
    
    $updateData = array_filter([
        'name' => $input['name'] ?? null,
        'description' => $input['description'] ?? null,
        'price' => isset($input['price']) ? (float)$input['price'] : null,
        'image_url' => $input['image_url'] ?? null,
        'category' => $input['category'] ?? null,
        'stock_quantity' => isset($input['stock_quantity']) ? (int)$input['stock_quantity'] : null,
        'is_active' => isset($input['is_active']) ? (bool)$input['is_active'] : null
    ], function($value) { return $value !== null; });
    
    $result = ItemUtil::updateItem($input['item_id'], $updateData);
    
    echo json_encode([
        'success' => $result,
        'message' => $result ? 'Item updated successfully' : 'Failed to update item'
    ]);
}

function handleDeleteItem($input) {
    if (!AuthUtil::isLoggedIn()) {
        echo json_encode(['success' => false, 'message' => 'Must be logged in']);
        return;
    }
    
    if (empty($input['item_id'])) {
        echo json_encode(['success' => false, 'message' => 'Item ID required']);
        return;
    }
    
    $currentUser = AuthUtil::getCurrentUser();
    $item = ItemUtil::findItemById($input['item_id']);
    
    if (!$item) {
        echo json_encode(['success' => false, 'message' => 'Item not found']);
        return;
    }
    
    // Check if user owns the item or is admin
    if ($item['seller_id'] != $currentUser['id'] && !AuthUtil::hasRole('admin')) {
        echo json_encode(['success' => false, 'message' => 'Not authorized to delete this item']);
        return;
    }
    
    $result = ItemUtil::deleteItem($input['item_id']);
    
    echo json_encode([
        'success' => $result,
        'message' => $result ? 'Item deleted successfully' : 'Failed to delete item'
    ]);
}
?>