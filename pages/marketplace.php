<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <title>The Last Trade Post - Marketplace</title>
    <?php require_once '../components/head.component.php'; ?>
    <?php require_once '../components/script.component.php';?>
    <link rel="stylesheet" href="assets/css/shop/marketplace.css" />
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

    <main class="marketplace-container">
        <div class="marketplace-header-controls">
            <h1>Marketplace</h1>
            <button id="addItemBtn" class="add-item-button">Add New Item</button>
        </div>

        <div class="all-products-container">
            <div class="marketplace-grid" id="marketplaceGrid">

                <div class="product-card" data-name="Tactical Backpack" data-price="85.50"
                    data-description="Durable tactical backpack with multiple compartments, ideal for outdoor survival.">
                    <div class="item-image">
                        <img src="assets/img/marketplace/tacticalbackpack.png" alt="Tactical Backpack">
                        <div class="item-overlay">
                            <p class="item-name">Tactical Backpack</p>
                            <p class="item-price">85.50</p>
                        </div>
                    </div>
                    <div class="item-bottom-actions">
                        <button class="more-info-btn">More Info</button>
                        <button class="buy-now-btn">Buy Now</button>
                    </div>
                </div>

                <div class="product-card" data-name="Solar Charger Kit" data-price="120.00"
                    data-description="Portable solar charger kit for electronics, essential for off-grid power.">
                    <div class="item-image">
                        <img src="assets/img/marketplace/solarchargerkit.png" alt="Solar Charger Kit">
                        <div class="item-overlay">
                            <p class="item-name">Solar Charger Kit</p>
                            <p class="item-price">120.00</p>
                        </div>
                    </div>
                    <div class="item-bottom-actions">
                        <button class="more-info-btn">More Info</button>
                        <button class="buy-now-btn">Buy Now</button>
                    </div>
                </div>

                <div class="product-card" data-name="Multi-Tool Pliers" data-price="45.99"
                    data-description="Compact multi-tool with various functions including pliers, knife, and saw.">
                    <div class="item-image">
                        <img src="assets/img/marketplace/multitoolpliers.png" alt="Multi-Tool Pliers">
                        <div class="item-overlay">
                            <p class="item-name">Multi-Tool Pliers</p>
                            <p class="item-price">45.99</p>
                        </div>
                    </div>
                    <div class="item-bottom-actions">
                        <button class="more-info-btn">More Info</button>
                        <button class="buy-now-btn">Buy Now</button>
                    </div>
                </div>

                <div class="product-card" data-name="Steel Boxing Gloves" data-price="4,299.00"
                    data-description="Boxing gloves made of steel for your own use.">
                    <div class="item-image">
                        <img src="assets/img/marketplace/steelgloves.jpg" alt="steelgloves">
                        <div class="item-overlay">
                            <p class="item-name">Steel Boxing Gloves</p>
                            <p class="item-price">4,299.00</p>
                        </div>
                    </div>
                    <div class="item-bottom-actions">
                        <button class="more-info-btn">More Info</button>
                        <button class="buy-now-btn">Buy Now</button>
                    </div>
                </div>

                <div class="product-card" data-name="Stealth Boots" data-price="2,800.00"
                    data-description="Boots made to provide silent movement and comfort during action.">
                    <div class="item-image">
                        <img src="assets/img/marketplace/stealthboots.png" alt="stealthboots">
                        <div class="item-overlay">
                            <p class="item-name">Stealth Boots</p>
                            <p class="item-price">2,800.00</p>
                        </div>
                    </div>
                    <div class="item-bottom-actions">
                        <button class="more-info-btn">More Info</button>
                        <button class="buy-now-btn">Buy Now</button>
                    </div>
                </div>

                <div class="product-card" data-name="Night Vision Goggles" data-price="950.00"
                    data-description="High-quality night vision goggles for low-light observation.">
                    <div class="item-image">
                        <img src="assets/img/marketplace/nightvisiongoggles.png" alt="Night Vision Goggles">
                        <div class="item-overlay">
                            <p class="item-name">Night Vision Goggles</p>
                            <p class="item-price">950.00</p>
                        </div>
                    </div>
                    <div class="item-bottom-actions">
                        <button class="more-info-btn">More Info</button>
                        <button class="buy-now-btn">Buy Now</button>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <div id="addItemModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeAddItemModal">&times;</span>
            <h2>Add New Item</h2>
            <form id="addItemForm">
                <div class="form-group">
                    <label for="itemName">Item Name:</label>
                    <input type="text" id="itemName" required>
                </div>
                <div class="form-group">
                    <label for="itemPrice">Item Price:</label>
                    <input type="number" id="itemPrice" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="itemImage">Item Image (PNG only):</label>
                    <input type="file" id="itemImage" accept=".png" required>
                </div>
                <div class="form-group">
                    <label for="itemDescription">Item Description:</label>
                    <textarea id="itemDescription" rows="5" required></textarea>
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

<?php include '../components/feedback.component.php';?>

<?php include '../components/footerpages.component.php'; ?>
</body>

</html>