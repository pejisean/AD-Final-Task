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
                <a href="../index.php"><img src="assets/img/HomeLogo.png" draggable="false" alt="The Last Trade Post Logo"></a>
            </div>
            <div class="header-right">
                <nav class="main-nav">
                    <a href="electronics.php" style="user-select: none;">Electronics & Power</a>
                    <a href="tools.php" style="user-select: none;">Tools & Equipment</a>
                    <a href="weapons.php" style="user-select: none;">Weapons & Defense</a>
                    <a href="other.php" style="user-select: none;">Other Essentials</a>
                    <a href="military.php" style="user-select: none;">Military Grade</a>
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
        <h2 class="section-title1" style="user-select: none;">Featured Items</h2>
        <div class="showcase-container">
            <section class="showcase-hero">
                <div class="showcase-content">
                    <span class="showcase-discount">Ultimate Defense: Save ₱8,000</span>
                    <h3>Automated Sentry Platform (Unarmed)</h3>
                    <p>₱35,000.00</p>
                    <div class="showcase-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </section>
            <div class="showcase-right-column">
                <section class="showcase-promo-card showcase-card-top">
                    <div class="showcase-content">
                        <span class="showcase-discount">Save ₱2,500</span>
                        <h3>Scrap Metal Armor Set (Torso & Pauldrons)</h3>
                        <p>₱15,000.00</p>
                        <div class="showcase-buttons">
                            <a class="buy-btn" href="#">Buy Now</a>
                            <a class="add-cart-btn" href="#">Add to Cart</a>
                        </div>
                    </div>
                </section>
                <section class="showcase-promo-card showcase-card-bottom">
                    <div class="showcase-content">
                        <span class="showcase-discount">Save ₱1,200</span>
                        <h3>Pipe Pistol Assembly Kit (.38 Special)</h3>
                        <p>₱7,800.00</p>
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
        <h2 class="section-title2" style="user-select: none;">New Arrivals</h2>
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
            <div class="product-card" data-price="3200">
                <span>Save ₱700</span>
                <h3>Remote-Triggered Trap Mechanism</h3>
                <p>₱3,200.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="1800">
                <span>Save ₱400</span>
                <h3>Caltrops (Bag of 50)</h3>
                <p>₱1,800.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="4500">
                <span>Save ₱950</span>
                <h3>Welded Steel Riot Shield</h3>
                <p>₱4,500.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="1500">
                <span>Save ₱350</span>
                <h3>Heavy-Duty Slingshot & Steel Bearings</h3>
                <p>₱1,500.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
        </section>
    </div>

    <div class="products-container">
        <h2 class="section-title" style="user-select: none;">Top Sellers</h2>
        <section class="products" id="top-sellers-grid">
            <div class="product-card" data-price="1200">
                <span>Save ₱300</span>
                <h3>Reinforced Baseball Bat (Barbed Wire)</h3>
                <p>₱1,200.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="2500">
                <span>Save ₱500</span>
                <h3>Combat Machete with Sheath</h3>
                <p>₱2,500.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="4100">
                <span>Save ₱800</span>
                <h3>Breaching Tomahawk</h3>
                <p>₱4,100.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="2800">
                <span>Save ₱650</span>
                <h3>Plated Forearm Guards (Pair)</h3>
                <p>₱2,800.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="950">
                <span>Save ₱200</span>
                <h3>Slam-Fire Shotgun Blueprints (12 Gauge)</h3>
                <p>₱950.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="900">
                <span>Save ₱250</span>
                <h3>Sharpened Rebar Spear</h3>
                <p>₱900.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="2600">
                <span>Save ₱550</span>
                <h3>Tripwire Flare Alarm Kit (4-Pack)</h3>
                <p>₱2,600.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="3100">
                <span>Save ₱700</span>
                <h3>Modified Motorcycle Helmet</h3>
                <p>₱3,100.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
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