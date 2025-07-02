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
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
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
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Electronics</a>
                    <a href="pages/tools.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Tools</a>
                    <a href="pages/weapons.php"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: pointer;">Weapons</a>
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
                <a href="#about">ℹ️ About Us</a>
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

        <section id="about" class="about-section">
            <h2>About The Last Trade Post</h2>
            <p class="about-section-p">
Let's be real—the world's a mess. Ever since the great burnout, it’s all been about picking through the bones of the old world, trying to find something useful before something nasty finds you. Out in the wastes, you hear whispers on scrambled comms about a place that's more than just another ruin, a spot on the map with lights that stay on. That's us. The Last Trade Post. We’re the anchor in the chaos, the place you limp to when you need to re-equip and reload. Before you even get to the people, you see our own stock, and we don't mess around with junk. We’ve got the gear that actually works, the real stuff that keeps you breathing for another day. You need power? We’ve got juice boxes and patched-up solar rigs that’ll get your corner of the world lit again. Our tool section is packed with hardened steel that won't snap on you when you're prying open a sealed door or trying to fix your ride. And yeah, we've got the hardware that solves the kind of problems you run into out there. We’ve got everything from a simple hand-cannon to the serious, military-grade ordnance the old-world soldiers dropped when they ran. This is the top-tier stuff you hear stories about—armor plates that’ll actually stop a round, scopes that see in the dead of night, and weapons that make damn sure you're the one walking away. It’s all here, a one-stop shop for not dying.
<br><br>
But here’s the real secret to this place, the thing that makes it tick: it's not just about what we stock. The Last Trade Post is a living, breathing marketplace, the biggest flea market at the end of the world, and it's powered entirely by people like you. It's driven by the lone scavengers hauling in a bag of salvaged components, by the organized crews looking to offload surplus gear after a successful run, and by the twitchy tech-head who just jury-rigged some new gadget and wants to trade it for something they need. Found something valuable out in the rust? Don't just sit on it. Bring it here, post it up, and turn that lucky find into a real payday. You're not just buying from some faceless shop; you're trading with another survivor who pulled that very item out of the rubble, probably with a hell of a story to tell about how they got it. It’s a whole ecosystem built on hustle and street cred. This is where you can turn a bag of bolts into a new weapon, or trade that extra armor plate for a water purifier that'll save your life next week. We just run the place and keep things from getting too bloody. You, the people, are the pulse. This is the new economy—it's raw, it's direct, and it's how we're all gonna build something new from the wreckage. One trade at a time.
            </p>
            <div class="about-image">
                <img src="assets/img/about-placeholder.jpg" alt="Trading outpost" />
            </div>
        </section>

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

</body>

</html>