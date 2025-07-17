<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <title>The Last Trade Post - Marketplace</title>
    <?php require_once '../components/head.component.php'; ?>
    <?php require_once '../components/script.component.php'; ?>
    <link rel="stylesheet" href="assets/css/shop/marketplace.css" />
    <link rel="stylesheet" href="assets/css/shop/buynowoverlay.css" />
</head>

<?php 
require_once '../components/dropdown.component.php';
require_once '../utils/marketplace.util.php';
require_once '../utils/imagePath.util.php';
require_once '../utils/auth.util.php';

// Debug: Check session status
error_log("Marketplace page - Session check:");
error_log("Session ID: " . session_id());
error_log("Is logged in: " . (AuthUtil::isLoggedIn() ? 'YES' : 'NO'));
if (AuthUtil::isLoggedIn()) {
    $user = AuthUtil::getCurrentUser();
    error_log("Current user: " . json_encode($user));
}

// Get items using the marketplace util
$items = MarketplaceUtil::getMarketplaceItems([], 50, 0);
?>

<main class="marketplace-container">
    <div class="marketplace-header-controls">
        <h1>Marketplace</h1>
        <button id="addItemBtn" class="add-item-button">Add New Item</button>
    </div>

    <div class="all-products-container">
        <div class="marketplace-grid" id="marketplaceGrid">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <div class="marketplace-item" 
                         data-item-id="<?= $item['id'] ?>"
                         data-description="<?= htmlspecialchars($item['description']) ?>">
                        <div class="item-image">
                            <?php 
                            // Use the improved getWebPath method with existence check
                            $imagePath = ImagePathUtil::getWebPath($item['image_url'], 'pages', true);
                            ?>
                            <img src="<?= $imagePath ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                 loading="lazy"
                                 onerror="this.src='<?= ImagePathUtil::getMarketplaceFallback("pages") ?>'">
                            <div class="item-overlay">
                                <p class="item-name"><?= htmlspecialchars($item['name']) ?></p>
                                <p class="item-price">₱<?= number_format($item['price'], 2) ?></p>
                                <div class="item-actions">
                                    <button class="more-info-btn">More Info</button>
                                    <button class="buy-now-btn" 
                                            data-item-name="<?= htmlspecialchars($item['name']) ?>" 
                                            data-item-price="<?= $item['price'] ?>"
                                            data-item-id="<?= $item['id'] ?>">Buy Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items available in the marketplace.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Modals -->
<div id="addItemModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeAddItemModal">&times;</span>
        <h2>Add New Item</h2>
        <form id="addItemForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="itemName">Item Name:</label>
                <input type="text" id="itemName" name="name" required>
            </div>
            <div class="form-group">
                <label for="itemPrice">Item Price:</label>
                <input type="number" id="itemPrice" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="itemCategory">Category:</label>
                <select id="itemCategory" name="category" required>
                    <option value="">Select Category</option>
                    <option value="weapons">Weapons</option>
                    <option value="survival">Survival</option>
                    <option value="electronics">Electronics</option>
                    <option value="medical">Medical</option>
                    <option value="tools">Tools</option>
                    <option value="apparel">Apparel</option>
                    <option value="food">Food</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="itemImage">Item Image:</label>
                <input type="file" id="itemImage" name="image" accept="image/*" required>
                <small>Supported formats: JPG, PNG, GIF (Max 5MB)</small>
            </div>
            <div class="form-group">
                <label for="itemDescription">Item Description:</label>
                <textarea id="itemDescription" name="description" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="itemStock">Stock Quantity:</label>
                <input type="number" id="itemStock" name="stock_quantity" min="1" value="1" required>
            </div>
            <button type="submit">Add Item</button>
        </form>
    </div>
</div>

<div id="itemDescriptionModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeDescriptionModal">&times;</span>
        <h2 id="descriptionModalTitle"></h2>
        <p id="descriptionModalText"></p>
    </div>
</div>

<!-- Pass PHP data to JavaScript -->
<script>
window.MARKETPLACE_CONFIG = {
    PLACEHOLDER_PATH: '<?= ImagePathUtil::getMarketplaceFallback("pages") ?>',
    FALLBACK_IMAGES: [
        '../assets/img/electronics/powerbank.png',
        '../assets/img/tools/crowbar.png',
        '../assets/img/weapons/machete.png',
        '../assets/img/other/first.png',
        '../assets/img/electronics/led.png',
        '../assets/img/tools/hammer.png',
        '../assets/img/weapons/sentry.png',
        '../assets/img/other/survival.png',
        '../assets/img/electronics/circuit.png',
        '../assets/img/tools/axe.png'
    ],
    BASE_PATH: '<?= BASE_PATH ?>'
};
</script>

<!-- Add debug console output -->
<script>
console.log('Marketplace page debug info:');
console.log('Session ID from PHP: <?= session_id() ?>');
console.log('Is logged in from PHP: <?= AuthUtil::isLoggedIn() ? "true" : "false" ?>');
console.log('localStorage loggedInCodename:', localStorage.getItem('loggedInCodename'));
</script>

<?php include '../components/feedback.component.php'; ?>
<?php include '../components/footer.component.php'; ?>
<script src="../assets/js/script.js"></script>
<script src="assets/js/marketplace.js"></script>
</body>
</html>