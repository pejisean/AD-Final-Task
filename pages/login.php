<?php
require_once '../bootstrap.php';
require_once '../components/auth.component.php';

// TEMPORARY DEBUG - Remove after testing
if (isset($_GET['debug'])) {
    echo "<h3>Database Debug Test</h3>";

    // Test 1: Check connection
    try {
        $conn = ConnectDB();
        if ($conn) {
            echo "✅ Database connection works<br>";

            // Test 2: Check if users table exists
            $result = pg_query($conn, "SELECT COUNT(*) FROM users");
            if ($result) {
                $count = pg_fetch_row($result)[0];
                echo "✅ Users table exists with $count records<br>";

                // Test 3: List usernames
                $result2 = pg_query($conn, "SELECT username FROM users LIMIT 5");
                if ($result2) {
                    echo "👥 Sample usernames:<br>";
                    while ($row = pg_fetch_row($result2)) {
                        echo "- " . htmlspecialchars($row[0]) . "<br>";
                    }
                }
            } else {
                echo "❌ Users table query failed: " . pg_last_error($conn) . "<br>";
            }

            pg_close($conn);
        } else {
            echo "❌ Database connection failed<br>";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "<br>";
    }

    echo "<hr>";
}

// Redirect if already logged in
if (AuthUtil::isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="hide-scrollbar">

<head>
    <title>The Last Trade Post - Login</title>
    <?php require_once '../components/head.component.php'; ?>
    <?php require_once '../components/script.component.php'; ?>
    <?php require_once '../components/dropdown.component.php'; ?>
    <link rel="stylesheet" href="assets/css/shop/login.css" />

</head>



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