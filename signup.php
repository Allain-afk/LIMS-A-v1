<?php
// Start the session
session_start();

// Include the database connection
$pdo = require 'database/db_connection.php';

// Initialize message variable
$message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $contactNo = $_POST['contactNo'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($firstName) && !empty($lastName) && !empty($contactNo) && 
        !empty($email) && !empty($username) && !empty($password)) {
        
        try {
            // Check if username already exists
            $checkStmt = $pdo->prepare('SELECT username FROM users WHERE username = :username');
            $checkStmt->execute(['username' => $username]);
            
            if ($checkStmt->rowCount() > 0) {
                $message = 'Username already exists. Please choose another.';
            } else {
                // Updated SQL query with correct column name
                $stmt = $pdo->prepare('INSERT INTO users (FirstName, LastName, contactNo, Email, username, password) 
                                     VALUES (:firstName, :lastName, :contactNo, :email, :username, :password)');
                
                $stmt->execute([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'contactNo' => $contactNo,
                    'email' => $email,
                    'username' => $username,
                    'password' => $password
                ]);

                // Set success message and show delayed redirect page
                $_SESSION['signup_success'] = true;
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Signup Successful</title>
                    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
                    <style>
                        .success-container {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            height: 100vh;
                            font-family: 'Montserrat', sans-serif;
                        }
                        .success-message {
                            color: #155724;
                            background-color:rgb(255, 255, 255);
                            border: 1px solid #c3e6cb;
                            padding: 20px;
                            border-radius: 5px;
                            text-align: center;
                            margin-bottom: 20px;
                        }
                    </style>
                </head>
                <body>
                    <div class="success-container">
                        <div class="success-message">
                            User created successfully. Please login again.
                        </div>
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 2000);
                    </script>
                </body>
                </html>
                <?php
                exit();
            }
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
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/signup.css">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="images/logo1.jpg" alt="Main Logo" class="main-logo">
            <p class="signin-text">Already have Account? Sign In now.</p>
            <button class="signin-btn" onclick="window.location.href='index.php'">
                <span class="signin-btn-text">SIGN IN</span>
            </button>
        </div>

        <h1 class="title">Sign Up</h1>
        <p class="subtitle">Please provide your information to sign up.</p>
        
        <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="" id="signup-form">
            <div class="input-container firstname">
                <input type="text" name="firstName" class="input-field" placeholder="First Name" required>
            </div>
            
            <div class="input-container lastname">
                <input type="text" name="lastName" class="input-field" placeholder="Last Name" required>
            </div>
            
            <div class="input-container contact">
                <input type="text" name="contactNo" class="input-field" placeholder="Contact No" required>
            </div>
            
            <div class="input-container email">
                <input type="email" name="email" class="input-field" placeholder="Email" required>
            </div>
            
            <div class="input-container username">
                <input type="text" name="username" class="input-field" placeholder="Username" required>
                <small class="username-message" style="display: block; margin-top: 5px; color: red;"></small>
            </div>
            
            <div class="input-container password">
                <input type="password" name="password" class="input-field" placeholder="Password" required>
            </div>
            
            <button type="submit" class="signup-btn">
                <span class="signup-btn-text">SIGN UP</span>
            </button>
        </form>
        
        <img src="images/logo3.png" alt="Logo" class="small-logo">
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const usernameInput = document.querySelector('input[name="username"]');
        const messageContainer = document.querySelector('.username-message'); // Select the <small> element

        usernameInput.addEventListener('input', function () {
            const username = usernameInput.value;

            if (username.length > 0) {
                fetch('check_username.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({ username }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.available) {
                        messageContainer.textContent = data.message;
                        messageContainer.style.color = 'green';
                    } else {
                        messageContainer.textContent = data.message;
                        messageContainer.style.color = 'red';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                messageContainer.textContent = '';
            }
        });
    });
    </script>
</body>
</html>
