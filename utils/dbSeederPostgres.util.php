<?php
declare(strict_types=1);

// 1) Composer autoload
require_once 'vendor/autoload.php';

// 2) Bootstrap
require_once 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . 'envSetter.util.php';

echo "🌱 Starting database seeding...\n";

try {
    // Connect to PostgreSQL using PDO
    $dsn = "pgsql:host={$pgConfig['pg_host']};port={$pgConfig['pg_port']};dbname={$pgConfig['pg_db']}";
    $pdo = new PDO($dsn, $pgConfig['pg_user'], $pgConfig['pg_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    echo "✅ Connected to PostgreSQL successfully!\n";

    // Seed all tables in correct order (respecting foreign key constraints)
    seedUsers($pdo);
    seedItems($pdo);
    seedCart($pdo);
    seedReceipts($pdo);
    seedReceiptItems($pdo);
    
    echo "🎉 Database seeding completed successfully!\n";

} catch (Exception $e) {
    echo "❌ Error during seeding: " . $e->getMessage() . "\n";
    echo "❌ Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}

// ===== SEEDING FUNCTIONS =====

function seedUsers($pdo) {
    echo "Seeding users...\n";
    
    // Check if static data file exists
    if (!file_exists('staticDatas/users.staticData.php')) {
        echo "❌ Users static data file not found: staticDatas/users.staticData.php\n";
        return;
    }
    
    // Load static data
    $users = require 'staticDatas/users.staticData.php';
    
    if (empty($users)) {
        echo "❌ No users data found\n";
        return;
    }
    
    $insertQuery = "INSERT INTO users (username, email, password, gender, role) VALUES (?, ?, ?, ?, ?)
                   ON CONFLICT (username) DO NOTHING";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($users as $user) {
        try {
            $stmt->execute([
                $user['username'],
                $user['email'] ?? null,
                $user['password'],
                $user['gender'] ?? null,
                $user['role'] ?? 'user'
            ]);
            echo "✅ Seeded user: {$user['username']}\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed user {$user['username']}: " . $e->getMessage() . "\n";
        }
    }
}

function seedItems($pdo) {
    echo "Seeding items...\n";
    
    // Check if items static data file exists
    if (!file_exists('staticDatas/items.staticData.php')) {
        echo "⚠️ Items static data file not found, creating sample data...\n";
        createSampleItems($pdo);
        return;
    }
    
    // Load static data
    $items = require 'staticDatas/items.staticData.php';
    
    // Remove ON CONFLICT since items table doesn't have unique constraint on name
    $insertQuery = "INSERT INTO items (name, description, price, image_url, seller_id, category, stock_quantity, is_active, source) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($items as $item) {
        try {
            $stmt->execute([
                $item['name'],
                $item['description'],
                $item['price'],
                $item['image_url'] ?? null,
                $item['seller_id'],
                $item['category'] ?? 'general',
                $item['stock_quantity'] ?? 1,
                $item['is_active'] ?? true,
                $item['source'] ?? 'marketplace'
            ]);
            echo "✅ Seeded item: {$item['name']}\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed item {$item['name']}: " . $e->getMessage() . "\n";
        }
    }
}

function createSampleItems($pdo) {
    // Get user IDs for sellers
    $userQuery = "SELECT id FROM users LIMIT 3";
    $userResult = $pdo->query($userQuery);
    $userIds = $userResult->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($userIds)) {
        echo "⚠️ No users found, skipping items seeding\n";
        return;
    }
    
    $sampleItems = [
        [
            'name' => 'Scavenged Radio',
            'description' => 'A working radio found in the wasteland. Perfect for long-range communication.',
            'price' => 45.99,
            'image_url' => 'assets/img/items/radio.jpg',
            'seller_id' => $userIds[0],
            'category' => 'electronics',
            'stock_quantity' => 3,
            'is_active' => true,
            'source' => 'marketplace'
        ],
        [
            'name' => 'Combat Knife',
            'description' => 'Sharp and reliable blade for close combat situations.',
            'price' => 29.99,
            'image_url' => 'assets/img/items/knife.jpg',
            'seller_id' => $userIds[1] ?? $userIds[0],
            'category' => 'weapons',
            'stock_quantity' => 5,
            'is_active' => true,
            'source' => 'shop'
        ],
        [
            'name' => 'Medical Kit',
            'description' => 'Essential medical supplies for treating wounds and injuries.',
            'price' => 75.50,
            'image_url' => 'assets/img/items/medkit.jpg',
            'seller_id' => $userIds[2] ?? $userIds[0],
            'category' => 'medical',
            'stock_quantity' => 8,
            'is_active' => true,
            'source' => 'shop'
        ],
        [
            'name' => 'Water Purification Tablets',
            'description' => 'Clean water is essential for survival. These tablets make any water safe to drink.',
            'price' => 12.99,
            'image_url' => 'assets/img/items/water-tabs.jpg',
            'seller_id' => $userIds[0],
            'category' => 'survival',
            'stock_quantity' => 20,
            'is_active' => true,
            'source' => 'marketplace'
        ],
        [
            'name' => 'Flashlight',
            'description' => 'Reliable LED flashlight with long battery life.',
            'price' => 18.75,
            'image_url' => 'assets/img/items/flashlight.jpg',
            'seller_id' => $userIds[1] ?? $userIds[0],
            'category' => 'tools',
            'stock_quantity' => 12,
            'is_active' => true,
            'source' => 'shop'
        ]
    ];
    
    $insertQuery = "INSERT INTO items (name, description, price, image_url, seller_id, category, stock_quantity, is_active, source) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($sampleItems as $item) {
        try {
            $stmt->execute([
                $item['name'],
                $item['description'],
                $item['price'],
                $item['image_url'],
                $item['seller_id'],
                $item['category'],
                $item['stock_quantity'],
                $item['is_active'],
                $item['source']
            ]);
            echo "✅ Seeded sample item: {$item['name']}\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed sample item {$item['name']}: " . $e->getMessage() . "\n";
        }
    }
}

function seedCart($pdo) {
    echo "Seeding cart items...\n";
    
    // Check if cart static data file exists
    if (!file_exists('staticDatas/cart.staticData.php')) {
        echo "⚠️ Cart static data file not found, creating sample cart data...\n";
        createSampleCartItems($pdo);
        return;
    }
    
    $cartItems = require 'staticDatas/cart.staticData.php';
    
    $insertQuery = "INSERT INTO cart (session_token, user_id, item_id, quantity, price_at_time) 
                   VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($cartItems as $cartItem) {
        try {
            $stmt->execute([
                $cartItem['session_token'],
                $cartItem['user_id'] ?? null,
                $cartItem['item_id'],
                $cartItem['quantity'],
                $cartItem['price_at_time']
            ]);
            echo "✅ Seeded cart item for session: {$cartItem['session_token']}\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed cart item: " . $e->getMessage() . "\n";
        }
    }
}

function createSampleCartItems($pdo) {
    // Get some user IDs and item IDs
    $userQuery = "SELECT id FROM users LIMIT 2";
    $userResult = $pdo->query($userQuery);
    $userIds = $userResult->fetchAll(PDO::FETCH_COLUMN);
    
    $itemQuery = "SELECT id, price FROM items LIMIT 3";
    $itemResult = $pdo->query($itemQuery);
    $items = $itemResult->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($userIds) || empty($items)) {
        echo "⚠️ Insufficient data for cart seeding (users: " . count($userIds) . ", items: " . count($items) . ")\n";
        return;
    }
    
    $sampleCartItems = [
        [
            'session_token' => 'sess_' . uniqid(),
            'user_id' => $userIds[0],
            'item_id' => $items[0]['id'],
            'quantity' => 2,
            'price_at_time' => $items[0]['price']
        ],
        [
            'session_token' => 'sess_' . uniqid(),
            'user_id' => $userIds[1] ?? $userIds[0],
            'item_id' => $items[1]['id'] ?? $items[0]['id'],
            'quantity' => 1,
            'price_at_time' => $items[1]['price'] ?? $items[0]['price']
        ]
    ];
    
    $insertQuery = "INSERT INTO cart (session_token, user_id, item_id, quantity, price_at_time) 
                   VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($sampleCartItems as $cartItem) {
        try {
            $stmt->execute([
                $cartItem['session_token'],
                $cartItem['user_id'],
                $cartItem['item_id'],
                $cartItem['quantity'],
                $cartItem['price_at_time']
            ]);
            echo "✅ Seeded sample cart item\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed sample cart item: " . $e->getMessage() . "\n";
        }
    }
}

function seedReceipts($pdo) {
    echo "Seeding receipts...\n";
    
    // Check if receipts static data file exists
    if (!file_exists('staticDatas/receipts.staticData.php')) {
        echo "⚠️ Receipts static data file not found, creating sample receipts...\n";
        createSampleReceipts($pdo);
        return;
    }
    
    $receipts = require 'staticDatas/receipts.staticData.php';
    
    $insertQuery = "INSERT INTO receipts (receipt_number, user_id, session_token, total_amount, tax_amount, shipping_address, billing_address, payment_method, payment_status, order_status, notes) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                   ON CONFLICT (receipt_number) DO NOTHING";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($receipts as $receipt) {
        try {
            $stmt->execute([
                $receipt['receipt_number'],
                $receipt['user_id'] ?? null,
                $receipt['session_token'] ?? null,
                $receipt['total_amount'],
                $receipt['tax_amount'] ?? 0,
                $receipt['shipping_address'],
                $receipt['billing_address'] ?? null,
                $receipt['payment_method'] ?? 'cash',
                $receipt['payment_status'] ?? 'completed',
                $receipt['order_status'] ?? 'processing',
                $receipt['notes'] ?? null
            ]);
            echo "✅ Seeded receipt: {$receipt['receipt_number']}\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed receipt {$receipt['receipt_number']}: " . $e->getMessage() . "\n";
        }
    }
}

function createSampleReceipts($pdo) {
    // Get some user IDs
    $userQuery = "SELECT id FROM users LIMIT 2";
    $userResult = $pdo->query($userQuery);
    $userIds = $userResult->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($userIds)) {
        echo "⚠️ No users found for receipts seeding\n";
        return;
    }
    
    $sampleReceipts = [
        [
            'receipt_number' => generateReceiptNumber(),
            'user_id' => $userIds[0],
            'session_token' => null,
            'total_amount' => 123.45,
            'tax_amount' => 12.35,
            'shipping_address' => generateDeliveryAddress(),
            'billing_address' => null,
            'payment_method' => 'cash',
            'payment_status' => 'completed',
            'order_status' => 'delivered',
            'notes' => 'Sample receipt for testing'
        ],
        [
            'receipt_number' => generateReceiptNumber(),
            'user_id' => $userIds[1] ?? $userIds[0],
            'session_token' => 'guest_sess_' . uniqid(),
            'total_amount' => 67.89,
            'tax_amount' => 6.79,
            'shipping_address' => generateDeliveryAddress(),
            'billing_address' => null,
            'payment_method' => 'cash',
            'payment_status' => 'completed',
            'order_status' => 'processing',
            'notes' => 'Guest purchase sample'
        ]
    ];
    
    $insertQuery = "INSERT INTO receipts (receipt_number, user_id, session_token, total_amount, tax_amount, shipping_address, billing_address, payment_method, payment_status, order_status, notes) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($sampleReceipts as $receipt) {
        try {
            $stmt->execute([
                $receipt['receipt_number'],
                $receipt['user_id'],
                $receipt['session_token'],
                $receipt['total_amount'],
                $receipt['tax_amount'],
                $receipt['shipping_address'],
                $receipt['billing_address'],
                $receipt['payment_method'],
                $receipt['payment_status'],
                $receipt['order_status'],
                $receipt['notes']
            ]);
            echo "✅ Seeded sample receipt: {$receipt['receipt_number']}\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed sample receipt: " . $e->getMessage() . "\n";
        }
    }
}

function seedReceiptItems($pdo) {
    echo "Seeding receipt items...\n";
    
    // Check if receipt items static data file exists
    if (!file_exists('staticDatas/receiptItems.staticData.php')) {
        echo "⚠️ Receipt items static data file not found, creating sample receipt items...\n";
        createSampleReceiptItems($pdo);
        return;
    }
    
    $receiptItems = require 'staticDatas/receiptItems.staticData.php';
    
    $insertQuery = "INSERT INTO receipt_items (receipt_id, item_id, item_name, item_description, quantity, unit_price, total_price, seller_name) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($receiptItems as $receiptItem) {
        try {
            $stmt->execute([
                $receiptItem['receipt_id'],
                $receiptItem['item_id'],
                $receiptItem['item_name'],
                $receiptItem['item_description'] ?? null,
                $receiptItem['quantity'],
                $receiptItem['unit_price'],
                $receiptItem['total_price'],
                $receiptItem['seller_name'] ?? null
            ]);
            echo "✅ Seeded receipt item: {$receiptItem['item_name']}\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed receipt item: " . $e->getMessage() . "\n";
        }
    }
}

function createSampleReceiptItems($pdo) {
    // Get receipt IDs and item data
    $receiptQuery = "SELECT id FROM receipts LIMIT 2";
    $receiptResult = $pdo->query($receiptQuery);
    $receiptIds = $receiptResult->fetchAll(PDO::FETCH_COLUMN);
    
    $itemQuery = "SELECT i.id, i.name, i.description, i.price, u.username 
                 FROM items i 
                 JOIN users u ON i.seller_id = u.id 
                 LIMIT 3";
    $itemResult = $pdo->query($itemQuery);
    $items = $itemResult->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($receiptIds) || empty($items)) {
        echo "⚠️ Insufficient data for receipt items seeding (receipts: " . count($receiptIds) . ", items: " . count($items) . ")\n";
        return;
    }
    
    $sampleReceiptItems = [
        [
            'receipt_id' => $receiptIds[0],
            'item_id' => $items[0]['id'],
            'item_name' => $items[0]['name'],
            'item_description' => $items[0]['description'],
            'quantity' => 2,
            'unit_price' => $items[0]['price'],
            'total_price' => $items[0]['price'] * 2,
            'seller_name' => $items[0]['username']
        ],
        [
            'receipt_id' => $receiptIds[0],
            'item_id' => $items[1]['id'] ?? $items[0]['id'],
            'item_name' => $items[1]['name'] ?? $items[0]['name'],
            'item_description' => $items[1]['description'] ?? $items[0]['description'],
            'quantity' => 1,
            'unit_price' => $items[1]['price'] ?? $items[0]['price'],
            'total_price' => $items[1]['price'] ?? $items[0]['price'],
            'seller_name' => $items[1]['username'] ?? $items[0]['username']
        ]
    ];
    
    $insertQuery = "INSERT INTO receipt_items (receipt_id, item_id, item_name, item_description, quantity, unit_price, total_price, seller_name) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    foreach ($sampleReceiptItems as $receiptItem) {
        try {
            $stmt->execute([
                $receiptItem['receipt_id'],
                $receiptItem['item_id'],
                $receiptItem['item_name'],
                $receiptItem['item_description'],
                $receiptItem['quantity'],
                $receiptItem['unit_price'],
                $receiptItem['total_price'],
                $receiptItem['seller_name']
            ]);
            echo "✅ Seeded sample receipt item: {$receiptItem['item_name']}\n";
        } catch (Exception $e) {
            echo "⚠️ Failed to seed sample receipt item: " . $e->getMessage() . "\n";
        }
    }
}

// Helper functions
function generateReceiptNumber() {
    $date = date('Ymd');
    $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    return "RCP-{$date}-{$random}";
}

function generateDeliveryAddress() {
    $streets = ['Wasteland Ave', 'Survivor St', 'Bunker Blvd', 'Scavenger Ln', 'Fortress Dr', 'Outpost Way'];
    $cities = ['New Haven', 'Safe Zone Alpha', 'Sanctuary Hills', 'Trading Post Central', 'Survivor\'s Rest'];
    $zones = ['Zone A', 'Zone B', 'Zone C', 'Sector 7', 'District 9'];
    
    $number = mt_rand(100, 9999);
    $street = $streets[array_rand($streets)];
    $city = $cities[array_rand($cities)];
    $zone = $zones[array_rand($zones)];
    $postcode = mt_rand(10000, 99999);
    
    return "{$number} {$street}, {$city}, {$zone} {$postcode}";
}

echo "✨ Seeding script completed.\n";
?>