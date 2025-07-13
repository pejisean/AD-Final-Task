<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <title>The Last Trade Post - Login</title>
    <?php require_once '../components/head.component.php'; ?>
    <link rel="stylesheet" href="assets/css/shop/login.css" />
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

                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="login.php">👤 Login / Sign Up</a>
                <a href="../index.php">🏠 Home</a>
                <a href="about.php">ℹ️ About Us</a>
            </div>
        </header>
    </div>

    <main class="login-container">
        <div class="login-form-wrapper">
            <h2>Welcome Back!</h2>
            <form class="login-form" onsubmit="return handleLogin()">
                <div class="form-group">
                    <label for="codename">Codename</label>
                    <input type="text" id="codename" name="codename" required placeholder="Enter your codename"
                        aria-label="Codename" />
                    <p id="codename-error" class="input-error-message"></p>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password"
                        aria-label="Password" />
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



    <?php include '../components/footer.component.php'; ?>
</body>

</html>