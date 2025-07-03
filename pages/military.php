<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Military Grade</title>
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/shop/military.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
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
                    <a href="marketplace.php">Marketplace</a>
                    <a href="electronics.php">Electronics</a>
                    <a href="tools.php">Tools</a>
                    <a href="weapons.php">Weapons</a>
                    <a href="other.php">Other Essentials</a>
                    <a href="military.php">Military Grade</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a id="login-signup-link" href="login.php">👤 Login / Sign Up</a>
                <a href="/index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="pages/history.php">📄 History</a>
                <a href="#" onclick="openFeedback(); return false;">💬 Feedback</a>
                <a href="/index.php#about">ℹ️ About Us</a>
            </div>
        </header>
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
            <textarea id="suggestionTextbox" placeholder="Tell us more about your experience..." rows="5"></textarea>
        </div>

        <button class="submit-button" onclick="submitFeedback()">Submit Feedback</button>
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