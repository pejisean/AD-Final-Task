<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Marketplace</title>
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/shop/marketplace.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <script src="assets/js/script.js"></script>
    <script src="assets/js/marketplace.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
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
                    <a href="marketplace.php">Marketplace</a>
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
                <a href="index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="#">📄 History</a>
                <a href="#">💬 Feedback</a>
                <a href="#">ℹ️ About Us</a>
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
                <div class="product-card" data-name="Tactical Backpack" data-price="85.50" data-description="Durable tactical backpack with multiple compartments, ideal for outdoor survival.">
                    <div class="item-details">
                        <p class="item-name">Tactical Backpack</p>
                        <p class="item-price">85.50</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Tactical Backpack">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Solar Charger Kit" data-price="120.00" data-description="Portable solar charger kit for electronics, essential for off-grid power.">
                    <div class="item-details">
                        <p class="item-name">Solar Charger Kit</p>
                        <p class="item-price">120.00</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Solar Charger Kit">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Multi-Tool Pliers" data-price="45.99" data-description="Compact multi-tool with various functions including pliers, knife, and saw.">
                    <div class="item-details">
                        <p class="item-name">Multi-Tool Pliers</p>
                        <p class="item-price">45.99</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Multi-Tool Pliers">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Water Purifier Bottle" data-price="60.25" data-description="Personal water filter bottle, capable of removing contaminants.">
                    <div class="item-details">
                        <p class="item-name">Water Purifier Bottle</p>
                        <p class="item-price">60.25</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Water Purifier Bottle">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Survival First Aid Kit" data-price="75.00" data-description="Comprehensive first aid kit for emergencies in wilderness or urban environments.">
                    <div class="item-details">
                        <p class="item-name">Survival First Aid Kit</p>
                        <p class="item-price">75.00</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Survival First Aid Kit">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Night Vision Goggles" data-price="950.00" data-description="High-quality night vision goggles for low-light observation.">
                    <div class="item-details">
                        <p class="item-name">Night Vision Goggles</p>
                        <p class="item-price">950.00</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Night Vision Goggles">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Compact Tent" data-price="180.00" data-description="Lightweight and compact tent for 2-3 persons, quick to set up.">
                    <div class="item-details">
                        <p class="item-name">Compact Tent</p>
                        <p class="item-price">180.00</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Compact Tent">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Emergency Radio" data-price="55.00" data-description="Hand-crank and solar-powered emergency radio with NOAA weather alerts.">
                    <div class="item-details">
                        <p class="item-name">Emergency Radio</p>
                        <p class="item-price">55.00</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Emergency Radio">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Durable Shovel" data-price="30.00" data-description="Foldable military-grade shovel for digging and chopping.">
                    <div class="item-details">
                        <p class="item-name">Durable Shovel</p>
                        <p class="item-price">30.00</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Durable Shovel">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Portable Cooking Stove" data-price="90.00" data-description="Compact and efficient portable stove for cooking in any outdoor setting.">
                    <div class="item-details">
                        <p class="item-name">Portable Cooking Stove</p>
                        <p class="item-price">90.00</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Portable Cooking Stove">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Rechargeable LED Lantern" data-price="40.00" data-description="Bright LED lantern, rechargeable via USB, perfect for camping or power outages.">
                    <div class="item-details">
                        <p class="item-name">Rechargeable LED Lantern</p>
                        <p class="item-price">40.00</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Rechargeable LED Lantern">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
                    </div>
                </div>
                <div class="product-card" data-name="Sport Gloves Pandora's Box" data-price="109931.04" data-description="Factory New Sport Gloves Pandora's Box. Exceedingly rare and highly sought after.">
                    <div class="item-details">
                        <p class="item-name">Sport Gloves Pandora's Box</p>
                        <p class="item-price">109,931.04</p>
                    </div>
                    <div class="item-image">
                        <img src="https://via.placeholder.com/150x100" alt="Item Image">
                    </div>
                    <div class="item-actions">
                        <button class="more-info-btn">More Info</button>
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