<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Login</title>
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <link rel="stylesheet" href="assets/css/shop/marketplace.css" />
    <!-- Link to your new login CSS -->
    <link rel="stylesheet" href="assets/css/login.css" />
    <!-- Link to your general script.js -->
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
                <!-- Ensure this path is correct relative to login.php -->
                <a href="../index.php"><img src="assets/img/HomeLogo.png" draggable="false" alt="The Last Trade Post Logo"></a>
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
                <!-- This link now points to itself as the entry point for login/signup flow -->
                <a href="login.php">👤 Login / Sign Up</a>
                <a href="../index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="#">📄 History</a>
                <a href="#">💬 Feedback</a>
                <a href="#">ℹ️ About Us</a>
            </div>
        </header>
    </div>

    <main class="login-container">
        <div class="login-form-wrapper">
            <h2>Welcome Back!</h2>
            <form class="login-form" onsubmit="return handleLogin()">
                <div class="form-group">
                    <label for="codename">Codename</label>
                    <input type="text" id="codename" name="codename" required placeholder="Enter your codename" aria-label="Codename" />
                    <p id="codename-error" class="input-error-message"></p>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password" aria-label="Password" />
                    <p id="password-error" class="input-error-message"></p>
                </div>

                <button type="submit" class="login-button">Login</button>
                <p id="form-message" class="info-message"></p>
            </form>
            <p class="signup-link-text">
                Don't have an account? <a href="signup.php">Sign Up Here</a>
            </p>
        </div>
    </main>

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

    <!-- Link to the external login JavaScript file -->
    <script src="assets/js/login.js"></script>
</body>

</html>