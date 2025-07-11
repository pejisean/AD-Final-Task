<!DOCTYPE html>
<html lang="en">

<head>
    <title>The Last Trade Post - Purchase History</title>
    <?php require_once '../components/head.component.php'; ?>
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

    <!-- Feedback Overlay HTML -->
    <div id="feedbackOverlay" class="feedback-overlay">
        <div class="feedback-modal">
            <button class="close-button" onclick="closeFeedback()">×</button>
            <h2 class="modal-title">We want your opinion!</h2>

            <div class="satisfaction-section">
                <p class="question">How satisfied are you with our service?*</p>
                <div class="emoji-rating">
                    <input type="radio" id="veryDissatisfied" name="satisfaction" value="very-dissatisfied" hidden>
                    <label for="veryDissatisfied" class="emoji-option" title="Very Dissatisfied">
                        <span class="emoji">😞</span>
                    </label>

                    <input type="radio" id="dissatisfied" name="satisfaction" value="dissatisfied" hidden>
                    <label for="dissatisfied" class="emoji-option" title="Dissatisfied">
                        <span class="emoji">😕</span>
                    </label>

                    <input type="radio" id="neutral" name="satisfaction" value="neutral" hidden>
                    <label for="neutral" class="emoji-option" title="Neutral">
                        <span class="emoji">😐</span>
                    </label>

                    <input type="radio" id="satisfied" name="satisfaction" value="satisfied" hidden>
                    <label for="satisfied" class="emoji-option" title="Satisfied">
                        <span class="emoji">🙂</span>
                    </label>

                    <input type="radio" id="verySatisfied" name="satisfaction" value="very-satisfied" hidden>
                    <label for="verySatisfied" class="emoji-option" title="Very Satisfied">
                        <span class="emoji">😊</span>
                    </label>
                </div>
            </div>

            <div class="suggestion-section">
                <p class="question">Do you have any concerns or suggestions about our service?</p>
                <textarea id="suggestionTextbox" placeholder="Tell us more about your experience..."
                    rows="5"></textarea>
            </div>

            <button class="submit-button" onclick="submitFeedback()">Submit Feedback</button>
        </div>
    </div>
    <!-- End Feedback Overlay HTML -->

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
    <!-- End Cart Overlay HTML -->

    <footer>
        <div>
            <h4>Links</h4>
            <a href="../index.php">Home</a>
            <a href="marketplace.php">Marketplace</a>
            <a href="electronics.php">Electronics</a>
            <a href="tools.php">Tools</a>
            <a href="weapons.php">Weapons</a>
            <a href="other.php">Other Essentials</a>
            <a href="military.php">Military</a>
        </div>
        <div>
            <h4>Company</h4>
            <a href="history.php">History</a>
            <a href="about.php">About Us</a>
            <a href="#">Contact Us</a>
            <a href="#">FAQs</a>
            <a href="#">Our Company</a>
        </div>
    </footer>

    <script src="../assets/js/history.js"></script>
</body>

</html>