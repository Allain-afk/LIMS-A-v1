<?php
// Start the session
session_start();

// Include the database connection
$pdo = require 'database/db_connection.php';

// Initialize variables for error messages
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if username and password are provided
    if (!empty($username) && !empty($password)) {
        // Change the query to check the admin table instead of users
        $stmt = $pdo->prepare('SELECT * FROM admin WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password (plain text comparison)
        if ($admin && $password === $admin['password']) {
            // Set session variables for admin
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_first_name'] = $admin['FirstName'];
            $_SESSION['admin_id'] = $admin['admin_id'];

            // Redirect to the admin dashboard
            header('Location: admin-dashboard.php');
            exit();
        } else {
            // Invalid credentials
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Please fill in both fields.';
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
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="container">
        <img src="images/logo3.png" alt="Logo" class="logo">
        <h1 class="welcome-text">Welcome Back !!</h1>
        <p class="login-subtitle">Please enter your credentials to log in</p>

        <!-- Display error message -->
        <?php if (!empty($error)): ?>
            <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Login form -->
        <form method="POST" action="">
            <input type="text" name="username" class="input-field" placeholder="Username" required>
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            <button type="submit" class="signin-btn">
                <span class="signin-btn-text">SIGN IN</span>
            </button>
        </form>
    </div>
</body>
</html>