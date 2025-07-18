<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <title>The Last Trade Post - Cart</title>
    <?php require_once '../components/head.component.php'; ?>
    <?php require_once '../components/script.component.php'; ?>
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/shop/trading.css" />
    <link rel="stylesheet" href="assets/css/shop/buynowoverlay.css" />
    <link rel="stylesheet" href="assets/css/shop/addtocartoverlay.css" />
    <link rel="stylesheet" href="assets/css/shop/cart.css" />
</head>

<body>
<?php 
require_once '../components/dropdown.component.php';
require_once '../utils/imagePath.util.php';
?>

<div class="products-container">
    <h2 class="cart-title">Your Cart</h2>
    
    <div id="cart-loading" class="cart-loading">
        <p>Loading cart...</p>
    </div>
    
    <div id="cart-items-list" class="cart-items-list"></div>
    
    <div class="cart-summary-section" id="cart-summary">
        <h3>Order Summary</h3>
        <p><strong>Subtotal:</strong> <span id="cart-subtotal">₱0.00</span></p>
        <p><strong>Total:</strong> <span id="cart-total">₱0.00</span></p>
        <button id="checkoutBtn" class="checkout-button member-checkout">Proceed to Checkout</button>
    </div>
    
    <div id="empty-cart-message" class="empty-cart-message">
        <p>Your cart is empty</p>
        <a href="marketplace.php" class="continue-shopping-btn">Continue Shopping</a>
    </div>
</div>

<!-- Receipt Overlay -->
<div id="receiptOverlay" class="overlay">
    <div class="overlay-content">
        <span class="close-button" id="closeReceiptOverlayBtn">&times;</span>
        <h2>Order Receipt</h2>
        <div class="receipt">
            <p><strong>Customer Name:</strong> <span id="receiptCustomerName"></span></p>
            <div id="receiptItems"></div>
            <hr>
            <p><strong>Total:</strong> ₱<span id="receiptTotalPrice"></span></p>
            <p><strong>Secure Address:</strong> <span id="receiptIPAddress"></span></p>
        </div>
        <button id="finalCheckoutBtn" class="checkout-button member-checkout">Complete Order</button>
    </div>
</div>

<!-- Pass PHP data to JavaScript -->
<script>
window.CART_CONFIG = {
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
    UPLOAD_PATH: '../assets/img/marketplace/uploads/',
    BASE_PATH: '<?= BASE_PATH ?>'
};
</script>

<?php include '../components/feedback.component.php'; ?>
<?php include '../components/footer.component.php'; ?>
<script src="assets/js/cart.js"></script>
</body>

</html>