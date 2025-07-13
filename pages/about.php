<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <title>The Last Trade Post - About Us</title>
    <?php require_once '../components/head.component.php';?>
    <?php require_once '../components/script.component.php';?>
    <link rel="stylesheet" href="assets/css/shop/about.css">
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="sticky-header">
        <header>
            <div class="logo">
                <a href="../index.php"><img src="assets/img/HomeLogo.png" alt="The Last Trade Post Logo"></a>
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
                <a href="../index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="history.php">📄 History</a>
                <a href="#" onclick="openFeedback(); return false;">💬 Feedback</a>
                <a href="about.php">ℹ️ About Us</a>
            </div>
        </header>
    </div>

    <main class="about-container">
        <section class="about-description">
            <h1>About The Last Trade Post</h1>
            <p>
                We are a band of scavengers, survivors, and system builders.
                From ash and iron, we created a digital market where trades mean survival.
                At The Last Trade Post, we believe commerce builds order.
                That’s why we crafted a space where real-world gear meets post-apocalyptic readiness.
                Welcome to the future’s most trusted black market—run by survivors, for survivors.
            </p>
        </section>

        <section class="team-section">
            <h2>Meet the Survivors Behind the Screen</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="assets/img/about/migzabout.png" alt="Migz Antonio">
                    <h3>Juan Miguel Antonio</h3>
                    <p>Frontend Dev / QA / Hunter</p>
                </div>
                <div class="team-member">
                    <img src="assets/img/about/seanabout.png" alt="Sean">
                    <h3>Sean James Peji</h3>
                    <p>Database / Backend / QA / Foreman</p>
                </div>
                <div class="team-member">
                    <img src="assets/img/about/carloabout.png" alt="Carlo">
                    <h3>John Carlo Dulutan</h3>
                    <p>Frontend Dev / Scavenger</p>
                </div>
                <div class="team-member">
                    <img src="assets/img/about/jayabout.png" alt="Jay">
                    <h3>Jaymard Licas</h3>
                    <p>Frontend Dev / QA / Quartermaster</p>
                </div>
            </div>
        </section>
    </main>

    <div id="feedbackOverlay" class="feedback-overlay">
        <div class="feedback-modal">
            <button class="close-button" onclick="closeFeedback()">×</button>
            <h2 class="modal-title">We want your opinion!</h2>

            <div class="satisfaction-section">
                <p class="question">How satisfied are you with our service?*</p>
                <div class="emoji-rating">
                    <input type="radio" id="veryDissatisfied" name="satisfaction" value="very-dissatisfied" hidden>
                    <label for="veryDissatisfied" class="emoji-option" title="Very Dissatisfied"><span
                            class="emoji">😞</span></label>

                    <input type="radio" id="dissatisfied" name="satisfaction" value="dissatisfied" hidden>
                    <label for="dissatisfied" class="emoji-option" title="Dissatisfied"><span
                            class="emoji">😕</span></label>

                    <input type="radio" id="neutral" name="satisfaction" value="neutral" hidden>
                    <label for="neutral" class="emoji-option" title="Neutral"><span class="emoji">😐</span></label>

                    <input type="radio" id="satisfied" name="satisfaction" value="satisfied" hidden>
                    <label for="satisfied" class="emoji-option" title="Satisfied"><span class="emoji">🙂</span></label>

                    <input type="radio" id="verySatisfied" name="satisfaction" value="very-satisfied" hidden>
                    <label for="verySatisfied" class="emoji-option" title="Very Satisfied"><span
                            class="emoji">😊</span></label>
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
<?php include '../components/footer.component.php'; ?>
</body>
</html>