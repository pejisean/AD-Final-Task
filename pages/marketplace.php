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
    <script src="assets/js/login.js"></script>
    <script src="assets/js/signup.js"></script>
    <script src="assets/js/marketplace.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=wrap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=wrap" rel="stylesheet">
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
                    <a href="marketplace.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Marketplace</a>
                    <a href="electronics.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Electronics</a>
                    <a href="tools.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Tools</a>
                    <a href="weapons.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Weapons</a>
                    <a href="other.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Other
                        Essentials</a>
                    <a href="military.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none;  -ms-user-select: none; cursor: pointer;">Military
                        Grade</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a id="login-signup-link" href="login.php">👤 Login / Sign Up</a>
                <a href="/index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="history.php">📄 History</a>
                <a href="#" onclick="openFeedback(); return false;">💬 Feedback</a>
                <a href="/index.php#about">ℹ️ About Us</a>
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
            <h4>Company</h4>
            <a href="#">Contact Us</a>
            <a href="#">FAQs</a>
            <a href="#">Our Company</a>
        </div>
        <div>
            <h4>Links</h4>
            <a href="#">Community</a>
        </div>
    </footer>
</body>

</html>