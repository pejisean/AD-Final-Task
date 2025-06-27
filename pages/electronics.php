<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Last Trade Post - Home</title>
    <link rel="stylesheet" href="assets/css/headfoot.css" />
    <link rel="stylesheet" href="assets/css/home.css" />
    <script src="assets/js/script.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">  <!-- for h4 h5 h6 like big headings -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet"> <!-- for <p> tag </p> -->
    <link href="https://fonts.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet"> <!-- for header and footer </p> -->
</head>

<body>

<!-- Header & Navigation -->
<div class="sticky-header">
    <header>
        <div class="logo">
           <a href="index.php"><img src="assets/img/HomeLogo.png" alt="The Last Trade Post Logo"></a>
        </div>

        <div class="header-right">
            <nav class="main-nav">
                <a href="electronics.php">Electronics & Power</a>
                <a href="tools.php">Tools & Equipment</a>
                <a href="weapons.php">Weapons & Defense</a>
                <a href="food.php">Food & Cooking</a>
                <a href="other.php">Other Essentials</a>
                <a href="military.php">Military Grade</a>
            </nav>
            <div class="hamburger" onclick="toggleMenu()">☰</div>
        </div>

        <div class="dropdown-menu" id="dropdownMenu">
            <a href="#">👤 Login / Sign Up</a>
            <a href="index.php">🏠 Home</a>
            <a href="#">🛒 Cart (0)</a>
            <a href="#">📄 History</a>
            <a href="#">📍 Location</a>
            <a href="#">💬 Feedback</a>
            <a href="#">ℹ️ About Us</a>
        </div>
    </header>
</div>


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