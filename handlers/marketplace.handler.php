<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../bootstrap.php';
    require_once UTILS_PATH . 'marketplace.util.php';
    require_once UTILS_PATH . 'auth.util.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    
    switch ($method) {
        case 'GET':
            handleGetMarketplaceItems();
            break;
        case 'POST':
            // Delegate to existing item.handler.php logic
            require_once HANDLERS_PATH . 'item.handler.php';
            handleCreateItem($input);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    }
    
} catch (Exception $e) {
    error_log("Marketplace handler error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

function handleGetMarketplaceItems() {
    $limit = (int)($_GET['limit'] ?? 50);
    $offset = (int)($_GET['offset'] ?? 0);
    $category = $_GET['category'] ?? null;
    $search = $_GET['search'] ?? null;
    
    $filters = array_filter([
        'category' => $category,
        'search' => $search
    ]);
    
    $items = MarketplaceUtil::getMarketplaceItems($filters, $limit, $offset);
    $formattedItems = MarketplaceUtil::formatItemsForDisplay($items, 'pages');
    $stats = MarketplaceUtil::getMarketplaceStats();
    
    echo json_encode([
        'success' => true,
        'data' => [
            'items' => $formattedItems,
            'stats' => $stats,
            'total' => count($items)
        ]
    ]);
}
?>