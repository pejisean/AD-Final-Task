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
    <script src="assets/js/script.js"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
  </head>

  <body>
    <div id="preloader">
      <div class="loader"></div>
    </div>

    <div class="sticky-header">
      <header>
        <div class="logo">
          <a href="../index.php"
            ><img
              src="assets/img/HomeLogo.png"
              draggable="false"
              alt="The Last Trade Post Logo"
          /></a>
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
          <a href="#"> Login / Sign Up</a>
          <a href="../index.php"> Home</a>
          <a href="#"> Cart (0)</a>
          <a href="#"> History</a>
          <a href="#"> Feedback</a>
          <a href="#"> About Us</a>
        </div>
      </header>
    </div>

    <main class="login-container">
      <div class="login-form-wrapper">
        <h2>Welcome Back!</h2>
        <form class="login-form" onsubmit="return handleLogin()">
          <div class="form-group">
            <label for="codename">Codename</label>
            <input
              type="text"
              id="codename"
              name="codename"
              required
              placeholder="Enter your codename"
            />
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              required
              placeholder="Enter your password"
            />
          </div>

          <button type="submit" class="login-button">Login</button>
          <p id="login-message" class="error-message"></p>
        </form>
        <p class="signup-link-text">
          Don't have an account? <a href="signup.html">Sign Up Here</a>
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

    <script>
      function handleLogin() {
        const codename = document.getElementById('codename').value;
        const password = document.getElementById('password').value;
        const messageElement = document.getElementById('login-message');

        // In a real application, you would send this data to a server for authentication.
        // For demonstration purposes, we'll just show a success message.
        if (codename && password) {
          messageElement.textContent = 'Attempting to log in...';
          messageElement.style.color = '#3498db'; // Blue for info
          // Simulate a network request
          setTimeout(() => {
            messageElement.textContent = 'Login successful! Redirecting...';
            messageElement.style.color = '#2ecc71'; // Green for success
            // In a real app, you'd redirect: window.location.href = 'dashboard.html';
          }, 1500);
          return false; // Prevent actual form submission for this demo
        } else {
          messageElement.textContent = 'Please enter both codename and password.';
          messageElement.style.color = '#e74c3c'; // Red for error
          return false; // Prevent form submission
        }
      }
    </script>
  </body>
</html>