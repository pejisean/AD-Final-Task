<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Sign Up</title>
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <link rel="stylesheet" href="assets/css/shop/signup.css" />
    <script src="assets/js/script.js"></script>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/signup.js"></script>
    <script src="assets/js/history.js"></script>
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
                <a href="../index.php"><img src="assets/img/HomeLogo.png" draggable="false" alt="The Last Trade Post Logo"></a>
            </div>
            <div class="header-right">
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="login.php">👤 Login / Sign Up</a>
                <a href="../index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="#">📄 History</a>
                <a href="#">💬 Feedback</a>
                <a href="/index.php#about">ℹ️ About Us</a>
            </div>
        </header>
    </div>

    <main class="signup-container">
        <div class="signup-form-wrapper">
            <h2>Create Your Account</h2>
            <form class="signup-form" onsubmit="return validateSignupForm()">
                <div class="form-group">
                    <label for="codename">Codename</label>
                    <input type="text" id="codename" name="codename" required placeholder="Enter your codename" aria-label="Codename" />
                    <p id="codename-error" class="input-error-message"></p>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required aria-label="Gender">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="others">Others</option>
                    </select>
                    <p id="gender-error" class="input-error-message"></p>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password" aria-label="Password" />
                    <p id="password-error" class="input-error-message"></p>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required placeholder="Confirm your password" aria-label="Confirm Password" />
                    <p id="confirm-password-error" class="input-error-message"></p>
                </div>

                <button type="submit" class="signup-button">Create Account</button>
                <p id="form-message" class="info-message"></p>
            </form>
            <p class="login-link-text">
                Already have an account? <a href="login.php">Login Here</a>
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

    <!-- Link to the external signup JavaScript file -->
    <script src="assets/js/signup.js"></script>
</body>

</html>