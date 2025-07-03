<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Purchase History</title>
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/shop/history.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <link rel="stylesheet" href="assets/css/feedback.css" />
    <script src="assets/js/script.js"></script>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/signup.js"></script>
        <script src="assets/js/history.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="sticky-header">
        <header>
            <div class="logo">
                <a href="../index.php"><img src="../assets/img/HomeLogo.png" alt="The Last Trade Post Logo"></a>
            </div>

            <div class="header-right">
                <nav class="main-nav">
                    <a href="marketplace.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Marketplace</a>
                    <a href="electronics.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Electronics</a>
                    <a href="tools.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Tools</a>
                    <a href="weapons.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Weapons</a>
                    <a href="other.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Other
                        Essentials</a>
                    <a href="military.php" style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Military
                        Grade</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a id="login-signup-link" href="login.php">👤 Login / Sign Up</a>
                <a href="../index.php">🏠 Home</a>
                <a href="history.php" class="active">📄 History</a> 
                <a href="#">🛒 Cart (0)</a>
                <a href="#" onclick="openFeedback(); return false;">💬 Feedback</a>
                <a href="../index.php#about">ℹ️ About Us</a>
            </div>
        </header>
    </div>

    <main class="history-main">
        <section class="history-hero">
            <div class="history-hero-text">
                <h1>Your Trade History</h1>
                <p>A record of your past acquisitions from both the Marketplace and The Last Trade Post.</p>
            </div>
        </section>

        <section class="purchase-sections">
            <div class="purchase-section">
                <h2>Marketplace Purchases</h2>
                <div class="purchase-grid" id="marketplace-purchases">
                    <!-- Marketplace items will be loaded here by JavaScript -->
                    <p class="no-history-message" id="no-marketplace-history">No marketplace purchases yet.</p>
                </div>
            </div>

            <div class="purchase-section">
                <h2>Shop Purchases</h2>
                <div class="purchase-grid" id="shop-purchases">
                    <!-- Shop items will be loaded here by JavaScript -->
                    <p class="no-history-message" id="no-shop-history">No shop purchases yet.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Feedback Overlay HTML (copied from previous instructions) -->
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
                <textarea id="suggestionTextbox" placeholder="Tell us more about your experience..." rows="5"></textarea>
            </div>

            <button class="submit-button" onclick="submitFeedback()">Submit Feedback</button>
        </div>
    </div>
    <!-- End Feedback Overlay HTML -->

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
