<?php
// Start output buffering at the very beginning
ob_start();
session_start();

// Include the database connection
$pdo = require 'database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        try {
            // Check if the user exists in the database
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
            $stmt->execute([
                'username' => $username,
                'password' => $password // Note: Use password_hash() and password_verify() in production
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Check if the user has verified their email
                $stmt = $pdo->prepare('SELECT * FROM otp WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1');
                $stmt->execute([
                    'user_id' => $user['user_id']
                ]);

                $otp = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$otp || $otp['status'] == 0) {
                    // Store user data in session for OTP verification
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['first_name'] = $user['FirstName'];
                    $_SESSION['last_name'] = $user['LastName'];
                    $_SESSION['error'] = 'Please verify your email first';
                    
                    // Redirect to OTP verification page
                    header('Location: otp.php');
                    exit();
                } else {
                    // Store user data in session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['first_name'] = $user['FirstName'];
                    $_SESSION['last_name'] = $user['LastName'];
                    $_SESSION['verified'] = true;

                    // Clear any existing output
                    ob_end_clean();

                    // Redirect to user-dashboard.php
                    header('Location: user-dashboard.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Login error: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = 'Please fill in all fields';
    }
}

// Initialize variables for error/success messages
$message = '';

// Check if user is already verified
if (isset($_SESSION['verified']) && $_SESSION['verified'] === true) {
    header('Location: user-dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($firstName) && !empty($lastName) && !empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (FirstName, LastName, username, password) VALUES (:firstName, :lastName, :username, :password)');
            $stmt->execute([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $username,
                'password' => $password // Note: In production, use password_hash()
            ]);
            $message = 'Account created successfully!';
        } catch (PDOException $e) {
            $message = 'Error creating account: ' . $e->getMessage();
        }
    } else {
        $message = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
    <div class="container">
        <!-- Existing login section -->
        <img src="images/logo3.png" alt="Logo" class="logo">
        <h1 class="welcome-text">Welcome Back !!</h1>
        <p class="login-subtitle">Please enter your credentials to log in</p>

        <form method="POST" action="index.php">
            <input type="text" name="username" class="input-field username-field" placeholder="Username" required>
            <input type="password" name="password" class="input-field password-field" placeholder="Password" required>

            <?php if (isset($_SESSION['error'])): ?>
                <p class="error-message" style="color: red; text-align: center;">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <a class="forgot-password">Forgot password?</a>
            <button type="submit" name="login" class="signin-btn">
                <span class="signin-btn-text">SIGN IN</span>
            </button>
        </form>

        <!-- Right section with signup -->
        <div class="right-section">
            <div class="decorative-elements">
                <div class="decorative-element-1"></div>
                <div class="decorative-element-2"></div>
                <div class="decorative-element-3"></div>
                <div class="decorative-element-4"></div>
                <div class="decorative-element-5"></div>
                <div class="decorative-element-6"></div>
                <div class="decorative-element-7"></div>
                <div class="decorative-element-8"></div>
                <div class="decorative-element-9"></div>
                <div class="decorative-element-10"></div>
                <div class="decorative-element-11"></div>
                <div class="decorative-element-12"></div>
                <div class="decorative-element-13"></div>
                <div class="decorative-element-14"></div>
                <div class="decorative-element-15"></div>
            </div>
            <img src="images/logo1.jpg" alt="Decorative Image">
            <p class="signup-text">New to our platform? Sign Up now.</p>

            <!-- Message Display -->
            <?php if (!empty($message)): ?>
                <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <button onclick="window.location.href='signup.php'" class="signup-btn" id="show-signup-btn">
                <span class="signup-btn-text">SIGN UP</span>
            </button>
        </div>
    </div>
</body>

</html>