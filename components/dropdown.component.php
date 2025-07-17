<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="sticky-header">
        <header>
            <div class="logo">
                <a href="/index.php"><img src="/assets/img/HomeLogo.png" draggable="false"
                        alt="The Last Trade Post Logo"></a>
            </div>

            <div class="header-right">
                <nav class="main-nav">
                    <a href="/pages/marketplace.php">Marketplace</a>
                    <a href="/pages/electronics.php">Electronics</a>
                    <a href="/pages/tools.php">Tools</a>
                    <a href="/pages/weapons.php">Weapons</a>
                    <a href="/pages/other.php">Other Essentials</a>
                    <a href="/pages/cart.php">Cart</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a id="login-signup-link" href="/pages/login.php">👤 Login / Sign Up</a>
                <a href="/index.php">🏠 Home</a>
                <a href="/pages/cart.php">🛒 Cart (<span id="cart-item-count">0</span>)</a>
                <a href="#" onclick="openFeedback(); return false;">💬 Feedback</a>
                <a href="/pages/about.php">ℹ️ About Us</a>
            </div>
        </header>
    </div>