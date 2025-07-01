<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>The Last Trade Post - Electronics & Power</title>
    <link rel="stylesheet" href="assets/css/header.css"/>
    <link rel="stylesheet" href="assets/css/footer.css"/>
    <link rel="stylesheet" href="assets/css/global.css"/>
    <link rel="stylesheet" href="assets/css/responsive.css"/>
    <link rel="stylesheet" href="assets/css/loader.css"/>
    <link rel="stylesheet" href="assets/css/shop/trading.css"/>
    <script src="assets/js/script.js"></script>
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
                <a href="../index.php"><img src="assets/img/HomeLogo.png" draggable="false" alt="The Last Trade Post Logo"></a>
            </div>

            <div class="header-right">
                <nav class="main-nav">
                    <a href="marketplace.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Marketplace</a>
                    <a href="electronics.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Electronics</a>
                    <a href="tools.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Tools</a>
                    <a href="weapons.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Weapons</a>
                    <a href="other.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Other Essentials</a>
                    <a href="military.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Military Grade</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a href="#">👤 Login / Sign Up</a>
                <a href="../index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="#">📄 History</a>
                <a href="#">💬 Feedback</a>
                <a href="#">ℹ️ About Us</a>
            </div>
        </header>
    </div>

    <div class="products-container">
        <h2 class="section-title1" style="user-select: none;">BATTLE-TESTED</h2>
        <div class="showcase-container">
            <section class="showcase-hero" style="background-image: url('assets/img/products/first-aid-kit-showcase.jpg');">
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
                <section class="showcase-promo-card showcase-card-top" style="background-image: url('assets/img/products/survival-backpack-showcase.jpg');">
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
                <section class="showcase-promo-card showcase-card-bottom" style="background-image: url('assets/img/products/water-filter-pump-showcase.jpg');">
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
            <h2 class="section-title2" style="user-select: none;">FRESH SALVAGE</h2>
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
            <div class="product-card" data-price="1100" style="background-image: url('assets/img/products/survival-handbook.jpg');">
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
            <div class="product-card" data-price="650" style="background-image: url('assets/img/products/signal-mirror.jpg');">
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
            <div class="product-card" data-price="850" style="background-image: url('assets/img/products/utensil-set.jpg');">
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
            <div class="product-card" data-price="1200" style="background-image: url('assets/img/products/light-sticks.jpg');">
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
        <h2 class="section-title" style="user-select: none;">SURVIVOR'S CHOICE</h2>
        <section class="products" id="top-sellers-grid">
            <div class="product-card" data-price="1500" style="background-image: url('assets/img/products/lifestraw.jpg');">
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
            <div class="product-card" data-price="950" style="background-image: url('assets/img/products/ferro-rod.jpg');">
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
            <div class="product-card" data-price="900" style="background-image: url('assets/img/products/mylar-blankets.jpg');">
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
            <div class="product-card" data-price="1800" style="background-image: url('assets/img/products/lensatic-compass.jpg');">
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
            <div class="product-card" data-price="650" style="background-image: url('assets/img/products/paracord.jpg');">
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
            <div class="product-card" data-price="550" style="background-image: url('assets/img/products/whistle.jpg');">
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
            <div class="product-card" data-price="750" style="background-image: url('assets/img/products/waterproof-matches.jpg');">
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
            <div class="product-card" data-price="1500" style="background-image: url('assets/img/products/headlamp.jpg');">
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

    <footer>
        <div>
            <h4>Customer Service</h4>
            <a href="#">Privacy Policy</a>
            <a href="#">Returns & Refunds</a>
        </div>
        <div>
            <h4>Company</h4>
            <a href="#">Contact Us</a>
            <a href="#">FAQs</a>
            <a href="#">Our Company</a>
            <a href="#">Store Locations</a>
        </div>
        <div>
            <h4>Links</h4>
            <a href="#">Community</a>
        </div>
    </footer>
</body>
</html>