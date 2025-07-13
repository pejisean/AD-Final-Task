<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Electronics</title>
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/shop/trading.css" />
    <link rel="stylesheet" href="assets/css/shop/trading.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <script src="assets/js/script.js"></script>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/signup.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="sticky-header">
        <header>
            <div class="logo">
                <a href="../index.php"><img src="assets/img/HomeLogo.png" draggable="false"
                        alt="The Last Trade Post Logo"></a>
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

    <div class="products-container">
        <h2 class="section-title1">BATTLE-TESTED</h2>
        <div class="showcase-container">
            <section class="showcase-hero" style="background-image: url('assets/img/electronics/powerbank.png');">
                <div class="showcase-content">
                    <span class="showcase-discount">Deal of the Week: Save ₱550</span>
                    <h3>20,000mAh Dual-Port Power Bank</h3>
                    <p>₱1,850.00</p>
                    <div class="showcase-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </section>
            <div class="showcase-right-column">
                <section class="showcase-promo-card showcase-card-top"
                    style="background-image: url('assets/img/electronics/jumper.png');">
                    <div class="showcase-content">
                        <span class="showcase-discount">Save ₱400</span>
                        <h3>Heavy-Duty Jumper Cables (8-Gauge)</h3>
                        <p>₱1,500.00</p>
                        <div class="showcase-buttons">
                            <a class="buy-btn" href="#">Buy Now</a>
                            <a class="add-cart-btn" href="#">Add to Cart</a>
                        </div>
                    </div>
                </section>
                <section class="showcase-promo-card showcase-card-bottom"
                    style="background-image: url('assets/img/electronics/surge.png');">
                    <div class="showcase-content">
                        <span class="showcase-discount">Save ₱350</span>
                        <h3>Smart Surge Protector Power Strip</h3>
                        <p>₱1,250.00</p>
                        <div class="showcase-buttons">
                            <a class="buy-btn" href="#">Buy Now</a>
                            <a class="add-cart-btn" href="#">Add to Cart</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- FRESH SALVAGE -->
    <div class="products-container">
        <div class="section-header">
            <h2 class="section-title2">FRESH SALVAGE</h2>
            <div class="product-toolbar">
                <div class="filter-group">
                    <label for="sort-by-main">Sort By:</label>
                    <select id="sort-by-main" class="sort-options">
                        <option value="default">Default</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        <section class="products" id="new-arrivals-grid">
            <div class="product-card" style="background-image: url('assets/img/electronics/multimeter.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱300</span>
                    <h3>Digital Multimeter</h3>
                    <p>₱950.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/led.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱250</span>
                    <h3>Rechargeable LED Headlamp</h3>
                    <p>₱850.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/circuit.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱150</span>
                    <h3>Automatic Circuit Breaker (20A)</h3>
                    <p>₱450.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/lithium.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱100</span>
                    <h3>CR2032 Lithium Coin Batteries (10-Pack)</h3>
                    <p>₱350.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- SURVIVOR'S CHOICE -->
    <div class="products-container">
        <h2 class="section-title">SURVIVOR'S CHOICE</h2>
        <section class="products" id="top-sellers-grid">
            <div class="product-card" style="background-image: url('assets/img/electronics/aa.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱200</span>
                    <h3>AA Alkaline Batteries (24-Pack)</h3>
                    <p>₱750.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/aaa.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱200</span>
                    <h3>AAA Alkaline Batteries (24-Pack)</h3>
                    <p>₱750.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/slimpower.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱450</span>
                    <h3>10,000mAh Slim Power Bank</h3>
                    <p>₱1,200.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/extension.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱250</span>
                    <h3>Heavy-Duty Extension Cord (10-meter)</h3>
                    <p>₱900.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/ledflash.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱350</span>
                    <h3>Rechargeable LED Flashlight</h3>
                    <p>₱1,100.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/9v.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱150</span>
                    <h3>9V Alkaline Batteries (4-Pack)</h3>
                    <p>₱550.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/alligator.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱100</span>
                    <h3>Alligator Clip Jumper Wires (Set of 10)</h3>
                    <p>₱300.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" style="background-image: url('assets/img/electronics/emergency.png')">
                <div class="product-content">
                    <span class="product-discount">Save ₱250</span>
                    <h3>LED Emergency Light with Battery Backup</h3>
                    <p>₱950.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

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
<?php include '../components/footer.component.php'; ?>
</body>

</html>