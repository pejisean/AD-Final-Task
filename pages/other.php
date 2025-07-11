<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <title>The Last Trade Post - Other Essentials</title>
    <?php require_once '../components/head.component.php'; ?>
    <link rel="stylesheet" href="assets/css/shop/trading.css" />
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
            <section class="showcase-hero" style="background-image: url('assets/img/other/first.png');">
                <div class="showcase-content">
                    <span class="showcase-discount">Priority Kit: Save ₱1,200</span>
                    <h3>Advanced First Aid Trauma Kit</h3>
                    <p>₱5,500.00</p>
                    <div class="showcase-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </section>
            <div class="showcase-right-column">
                <section class="showcase-promo-card showcase-card-top"
                    style="background-image: url('assets/img/other/survival.png');">
                    <div class="showcase-content">
                        <span class="showcase-discount">Save ₱2,500</span>
                        <h3>72-Hour Survival Backpack</h3>
                        <p>₱12,000.00</p>
                        <div class="showcase-buttons">
                            <a class="buy-btn" href="#">Buy Now</a>
                            <a class="add-cart-btn" href="#">Add to Cart</a>
                        </div>
                    </div>
                </section>
                <section class="showcase-promo-card showcase-card-bottom"
                    style="background-image: url('assets/img/other/water.png');">
                    <div class="showcase-content">
                        <span class="showcase-discount">Save ₱950</span>
                        <h3>High-Performance Water Filter Pump</h3>
                        <p>₱4,800.00</p>
                        <div class="showcase-buttons">
                            <a class="buy-btn" href="#">Buy Now</a>
                            <a class="add-cart-btn" href="#">Add to Cart</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

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
            <div class="product-card" data-price="1100" style="background-image: url('assets/img/other/handbook.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱300</span>
                    <h3>Waterproof Survival Handbook</h3>
                    <p>₱1,100.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="650" style="background-image: url('assets/img/other/signal.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱200</span>
                    <h3>Emergency Signal Mirror</h3>
                    <p>₱650.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="850" style="background-image: url('assets/img/other/utensil.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱250</span>
                    <h3>Titanium Spork & Utensil Set</h3>
                    <p>₱850.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="1200" style="background-image: url('assets/img/other/light.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱350</span>
                    <h3>Chemical Light Sticks (12-Pack)</h3>
                    <p>₱1,200.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="products-container">
        <h2 class="section-title">SURVIVOR'S CHOICE</h2>
        <section class="products" id="top-sellers-grid">
            <div class="product-card" data-price="1500"
                style="background-image: url('assets/img/other/lifestraw.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱450</span>
                    <h3>"Lifestraw" Personal Water Filter</h3>
                    <p>₱1,500.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="950" style="background-image: url('assets/img/other/ferro.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱300</span>
                    <h3>Ferro Rod & Striker Fire Starter</h3>
                    <p>₱950.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="900" style="background-image: url('assets/img/other/mylar.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱250</span>
                    <h3>Emergency Mylar Space Blankets (10-Pack)</h3>
                    <p>₱900.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="1800" style="background-image: url('assets/img/other/lensatic.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱500</span>
                    <h3>Military-Style Lensatic Compass</h3>
                    <p>₱1,800.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="650" style="background-image: url('assets/img/other/paracord.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱200</span>
                    <h3>100ft. 550 Paracord</h3>
                    <p>₱650.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="550" style="background-image: url('assets/img/other/whistle.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱150</span>
                    <h3>High-Decibel Emergency Whistle</h3>
                    <p>₱550.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="750"
                style="background-image: url('assets/img/other/waterproof.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱200</span>
                    <h3>Waterproof Match Case with Matches</h3>
                    <p>₱750.00</p>
                    <div class="product-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </div>
            <div class="product-card" data-price="1500" style="background-image: url('assets/img/other/headlamp.png');">
                <div class="product-content">
                    <span class="product-discount">Save ₱400</span>
                    <h3>Rechargeable LED Headlamp</h3>
                    <p>₱1,500.00</p>
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
</body>

</html>