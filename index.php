<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Home</title>
    <link rel="stylesheet" href="assets/css/global.css" />
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/home.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <script src="assets/js/script.js"></script>
    <script src="assets/js/marketplace.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <!-- for h4 h5 h6 like big headings -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <!-- for <p> tag </p> -->
    <link href="https://fonts.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- for header and footer </p> -->
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
                    <a href="pages/marketplace.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Marketplace</a>
                    <a href="pages/electronics.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Electronics
                        & Power</a>
                    <a href="pages/tools.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Tools
                        & Equipment</a>
                    <a href="pages/weapons.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Weapons
                        & Defense</a>
                    <a href="pages/other.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Other
                        Essentials</a>
                    <a href="pages/military.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Military
                        Grade</a>
                </nav>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a href="#">👤 Login / Sign Up</a>
                <a href="index.php">🏠 Home</a>
                <a href="#">🛒 Cart (0)</a>
                <a href="#">📄 History</a>
                <a href="#">💬 Feedback</a>
                <a href="#">ℹ️ About Us</a>
            </div>
        </header>
    </div>

    <!-- Main Content -->
    <main class="home-container">

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-image">
                <img src="assets/img/home1.png" alt="Apocalyptic survivor hero image">
            </div>
            <div class="hero-text">
                <h1>The Last Trade Postss</h1>
                <p>Survive. Trade. Rebuild. In the aftermath of the collapse, this is your ultimate marketplace for
                    survival gear and critical supplies.</p>
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

        <!-- About Section -->
        <section class="about-section">
            <h2>About The Last Trade Post</h2>
            <p>
                Once the cities fell and the systems collapsed, only a few outposts remained—places where survivors
                could find gear, share intel, and barter for essentials. This is that place.
                Whether you're a lone scavenger or leading a crew, our inventory is your key to survival.
            </p>
            <div class="about-image">
                <img src="assets/img/about-placeholder.jpg" alt="Trading outpost" />
            </div>
        </section>

    </main>

    <!-- Footer -->
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