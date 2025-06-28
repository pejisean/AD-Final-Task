<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Tools & Equipment</title>
    <link rel="stylesheet" href="assets/css/headfoot.css" />
    <link rel="stylesheet" href="assets/css/trading/trading.css" />
    <script src="assets/js/script.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
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
                    <span class="showcase-discount">Essential Gear: Save ₱1,500</span>
                    <h3>36-inch "Breacher" Halligan Bar</h3>
                    <p>₱7,500.00</p>
                    <div class="showcase-buttons">
                        <a class="buy-btn" href="#">Buy Now</a>
                        <a class="add-cart-btn" href="#">Add to Cart</a>
                    </div>
                </div>
            </section>
            <div class="showcase-right-column">
                <section class="showcase-promo-card showcase-card-top">
                    <div class="showcase-content">
                        <span class="showcase-discount">Save ₱900</span>
                        <h3>Heavy-Duty Bolt Cutters (30-inch)</h3>
                        <p>₱4,200.00</p>
                        <div class="showcase-buttons">
                            <a class="buy-btn" href="#">Buy Now</a>
                            <a class="add-cart-btn" href="#">Add to Cart</a>
                        </div>
                    </div>
                </section>
                <section class="showcase-promo-card showcase-card-bottom">
                    <div class="showcase-content">
                        <span class="showcase-discount">Save ₱750</span>
                        <h3>Carpenter's Manual Hand Drill Set</h3>
                        <p>₱3,200.00</p>
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
        <h2 class="section-title" style="user-select: none;">New Arrivals</h2>
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
        <section class="products" id="new-arrivals-grid">
            <div class="product-card" data-price="3500">
                <span>Save ₱850</span>
                <h3>Professional Lockpick Set (24-Piece)</h3>
                <p>₱3,500.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="1600">
                <span>Save ₱400</span>
                <h3>Collapsible Folding Saw</h3>
                <p>₱1,600.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="2200">
                <span>Save ₱500</span>
                <h3>Titanium Pry Bar</h3>
                <p>₱2,200.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="1250">
                <span>Save ₱350</span>
                <h3>Engineer's Hammer (4 lb)</h3>
                <p>₱1,250.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
        </section>
    </div>

    <div class="products-container">
        <h2 class="section-title" style="user-select: none;">Top Sellers</h2>
        <section class="products" id="top-sellers-grid">
            <div class="product-card" data-price="1800">
                <span>Save ₱450</span>
                <h3>24-inch Go-Bar (Crowbar)</h3>
                <p>₱1,800.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="4800">
                <span>Save ₱1,100</span>
                <h3>Forged Steel Splitting Axe</h3>
                <p>₱4,800.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="2500">
                <span>Save ₱600</span>
                <h3>10-lb Sledgehammer</h3>
                <p>₱2,500.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="4100">
                <span>Save ₱950</span>
                <h3>All-Purpose Tactical Tomahawk</h3>
                <p>₱4,100.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="1950">
                <span>Save ₱550</span>
                <h3>Folding Trench Shovel w/ Pick</h3>
                <p>₱1,950.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="1500">
                <span>Save ₱400</span>
                <h3>Dual-Grit Sharpening Stone Kit</h3>
                <p>₱1,500.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="950">
                <span>Save ₱300</span>
                <h3>Heavy Leather Work Gloves</h3>
                <p>₱950.00</p>
                <a class="buy-btn" href="#">Buy Now</a>
                <a class="add-cart-btn" href="#">Add to Cart</a>
            </div>
            <div class="product-card" data-price="5500">
                <span>Save ₱1,200</span>
                <h3>Mechanic's Wrench & Socket Roll</h3>
                <p>₱5,500.00</p>
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