<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <title>The Last Trade Post - Home</title>
    <?php require_once 'components/head.component.php';?>
    <?php require_once 'components/script.component.php';?>
    <link rel="stylesheet" href="assets/css/home.css" />
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="sticky-header">
        <header>
            <div class="logo">
                <a href="index.php"><img src="assets/img/HomeLogo.png" alt="The Last Trade Post Logo"></a>
            </div>

            <div class="header-right">
                <nav class="main-nav">
                    <a href="pages/marketplace.php">Marketplace</a>
                    <a href="pages/electronics.php">Electronics</a>
                    <a href="pages/tools.php">Tools</a>
                    <a href="pages/weapons.php">Weapons</a>
                    <a href="pages/other.php">Other Essentials</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a id="login-signup-link" href="pages/login.php">👤 Login / Sign Up</a>
                <a href="index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="pages/history.php">📄 History</a>
                <a href="#" onclick="openFeedback(); return false;">💬 Feedback</a>
                <a href="pages/about.php">ℹ️ About Us</a> <!-- ✅ updated -->
            </div>
        </header>
    </div>

    <!-- Main Content -->
    <main class="home-container">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-wrapper">
                <div class="hero-text">
                    <span class="hero-subtitle">Survive. Trade. Rebuild.</span>
                    <h1 class="hero-title">Your ultimate marketplace for survival gear and supplies.</h1>
                    <p class="hero-description">Post-apocalyptic trading begins here.</p>
                </div>
                <img src="assets/img/home1.png" alt="Apocalyptic survivor hero image" class="hero-image">
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="featured-categories">
            <h2>Featured Categories</h2>
            <div class="category-grid">
                <a href="pages/electronics.php">
                    <div class="category-item">
                        <img src="assets/img/HomeElectronics.png" alt="Electronics & Power" />
                        <h3>Electronics & Power</h3>
                    </div>
                </a>
                <a href="pages/tools.php">
                    <div class="category-item">
                        <img src="assets/img/HomeTools.png" alt="Tools & Equipment" />
                        <h3>Tools & Equipment</h3>
                    </div>
                </a>
                <a href="pages/weapons.php">
                    <div class="category-item">
                        <img src="assets/img/HomeWeapons.png" alt="Weapons & Defense" />
                        <h3>Weapons & Defense</h3>
                    </div>
                </a>
                <a href="pages/food.php">
                    <div class="category-item">
                        <img src="assets/img/HomeFood.png" alt="Food & Cooking" />
                        <h3>Food & Cooking</h3>
                    </div>
                </a>
                <a href="pages/other.php">
                    <div class="category-item">
                        <img src="assets/img/HomeOther.png" alt="Other Essentials" />
                        <h3>Other Essentials</h3>
                    </div>
                </a>
                <a href="pages/military.php">
                    <div class="category-item">
                        <img src="assets/img/HomeMilitary.png" alt="Military Grade" />
                        <h3>Military Grade</h3>
                    </div>
                </a>
            </div>
        </section>

        <!-- About Section on Homepage -->
        <section id="about" class="about-section">
            <h2>About The Last Trade Post</h2>
            <p class="about-section-p">
                Let's be real—the world's a mess. Ever since the great burnout...
                <br><br>
                This is the new economy—it's raw, it's direct, and it's how we're all gonna build something new from the
                wreckage. One trade at a time.
            </p>
        </section>
    </main>

    <!-- Feedback Modal -->
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

<?php include 'components/footer.component.php'; ?>
</body>

</html>