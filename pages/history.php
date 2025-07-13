<!DOCTYPE html>
<html lang="en">

<head>
    <title>The Last Trade Post - Purchase History</title>
    <?php require_once '../components/head.component.php'; ?>
    <?php require_once '../components/script.component.php';?>
    <link rel="stylesheet" href="assets/css/shop/history.css" />
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="sticky-header">
        <header>
            <div class="logo">
                <a href="../index.php"><img src="../assets/img/HomeLogo.png" alt="The Last Trade Post Logo"></a>
            </div>

            <div class="header-right">
                <nav class="main-nav">
                    <a href="marketplace.php">Marketplace</a>
                    <a href="electronics.php">Electronics</a>
                    <a href="tools.php">Tools</a>
                    <a href="weapons.php">Weapons</a>
                    <a href="other.php">Other Essentials</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a id="login-signup-link" href="login.php">👤 Login / Sign Up</a>
                <a href="/index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="history.php">📄 History</a>
                <a href="#" onclick="openFeedback(); return false;">💬 Feedback</a>
                <a href="about.php">ℹ️ About Us</a>
            </div>
        </header>
    </div>

    <main class="history-main">
        <section class="history-hero">
            <div class="history-hero-text">
                <h1>Your Trade History</h1>
                <p>A record of your past acquisitions from both the Marketplace and The Last Trade Post.</p>
            </div>
        </section>

        <section class="purchase-sections">
            <div class="purchase-section">
                <h2>Marketplace Purchases</h2>
                <div class="purchase-grid" id="marketplace-purchases">
                    <!-- Marketplace items will be loaded here by JavaScript -->
                    <p class="no-history-message" id="no-marketplace-history">No marketplace purchases yet.</p>
                </div>
            </div>

            <div class="purchase-section">
                <h2>Shop Purchases</h2>
                <div class="purchase-grid" id="shop-purchases">
                    <!-- Shop items will be loaded here by JavaScript -->
                    <p class="no-history-message" id="no-shop-history">No shop purchases yet.</p>
                </div>
            </div>
        </section>
    </main>

<?php include '../components/feedback.component.php';?>

    <!-- Cart Overlay HTML -->
    <div id="cartOverlay" class="cart-overlay">
        <div class="cart-modal">
            <button class="close-button" onclick="closeCart()">×</button>
            <div class="cart-content">
                <div class="cart-items-section">
                    <h2 class="cart-title">Bag</h2>
                    <div id="cart-items-list" class="cart-items-list">
                        <p class="empty-cart-message">There are no items in your bag.</p>
                        <!-- Cart items will be dynamically loaded here -->
                    </div>
                </div>
                <div class="cart-summary-section">
                    <h2 class="cart-title">Summary</h2>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="cart-subtotal">₱0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Estimated Delivery & Handling</span>
                            <span>Free</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span id="cart-total">₱0.00</span>
                        </div>
                    </div>
                    <div class="checkout-buttons">
                        <button class="checkout-button guest-checkout">Guest Checkout</button>
                        <button class="checkout-button member-checkout">Member Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include '../components/footer.component.php'; ?>

    <script src="../assets/js/history.js"></script>
</body>

</html>