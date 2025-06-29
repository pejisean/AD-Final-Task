<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Electronics & Power</title>
    <link rel="stylesheet" href="assets/css/headfoot.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <link rel="stylesheet" href="assets/css/trading/trading.css" />
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
                <a href="../index.php"><img src="assets/img/HomeLogo.png" draggable="false"
                        alt="The Last Trade Post Logo"></a>
            </div>
            <div class="header-right">
                <nav class="main-nav">
                    <a href="electronics.php">Electronics & Power</a>
                    <a href="tools.php">Tools & Equipment</a>
                    <a href="weapons.php">Weapons & Defense</a>
                    <a href="other.php">Other Essentials</a>
                    <a href="military.php">Military Grade</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="#">👤 Login / Sign Up</a>
                <a href="../index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="#">📄 History</a>
                <a href="#">📍 Location</a>
                <a href="#">💬 Feedback</a>
                <a href="#">ℹ️ About Us</a>
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
            <div class="product-card" style="background-image: url('assets/img/products/headlamp.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/circuitbreaker.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/coinbatteries.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/aa.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/aaa.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/slimpower.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/extension.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/flashlight.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/9vbatt.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/jumperwires.jpg')">
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
            <div class="product-card" style="background-image: url('assets/img/products/emergencylight.jpg')">
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