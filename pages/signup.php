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
    <link rel="stylesheet" href="assets/css/shop/marketplace.css" />
    <link rel="stylesheet" href="assets/css/signup.css" />
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

    <main class="signup-container">
      <div class="signup-form-wrapper">
        <h2>Create Your Account</h2>
        <form class="signup-form" onsubmit="return validateForm()">
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
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
              <option value="">Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="others">Others</option>
            </select>
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

          <div class="form-group">
            <label for="confirm-password">Confirm Password</label>
            <input
              type="password"
              id="confirm-password"
              name="confirm-password"
              required
              placeholder="Confirm your password"
            />
          </div>

          <button type="submit" class="signup-button">Create Account</button>
          <p id="password-match-message" class="error-message"></p>
        </form>
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
      function validateForm() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const messageElement = document.getElementById('password-match-message');

        if (password !== confirmPassword) {
          messageElement.textContent = 'Passwords do not match!';
          messageElement.style.color = '#e74c3c'; // Red for error
          return false; // Prevent form submission
        } else {
          messageElement.textContent = ''; // Clear message if passwords match
          // Here, you would typically submit the form data to a server
          alert('Account created successfully!'); // For demonstration
          return true; // Allow form submission (or handle with AJAX)
        }
      }
    </script>
  </body>
</html>