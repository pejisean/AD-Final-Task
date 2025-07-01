<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Electronics & Power</title>
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <link rel="stylesheet" href="assets/css/shop/marketplace.css" />
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
                <a href="#"> Login / Sign Up</a>
                <a href="../index.php"> Home</a>
                <a href="#"> Cart (0)</a>
                <a href="#"> History</a>
                <a href="#"> Feedback</a>
                <a href="#"> About Us</a>
            </div>
        </header>
    </div>

    <main class="marketplace-container">
        <h1>Marketplace</h1>

        <button id="addItemBtn" class="add-item-button">Add New Item</button>

        <div class="marketplace-grid" id="marketplaceGrid">
            <div class="product-card" data-name="Sport Gloves Pandora's Box" data-price="109931.04" data-description="Factory New Sport Gloves Pandora's Box. Exceedingly rare and highly sought after.">
                <div class="item-header">
                    <span class="item-condition">FACTORY NEW - 0.005</span>
                </div>
                <div class="item-image">
                    <img src="https://via.placeholder.com/150x100" alt="Item Image">
                </div>
                <div class="item-details">
                    <p class="item-name">Sport Gloves Pandora's Box</p>
                    <p class="item-price">109,931.04<span class="price-change positive">+1.67%</span></p>
                </div>
                <div class="item-actions">
                    <span class="item-status offline">Offline</span>
                    <button class="more-info-btn">More Info</button>
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
                    <label for="itemCondition">Item Condition:</label>
                    <input type="text" id="itemCondition" placeholder="e.g., FACTORY NEW - 0.005">
                </div>
                <div class="form-group">
                    <label for="itemStatus">Status:</label>
                    <select id="itemStatus">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="itemPriceChange">Price Change (e.g., +1.67%):</label>
                    <input type="text" id="itemPriceChange" placeholder="+1.67%">
                </div>
                <div class="form-group">
                    <label for="itemImage">Image URL:</label>
                    <input type="url" id="itemImage" placeholder="https://via.placeholder.com/150x100">
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