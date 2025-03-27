<?php
// Start the session
session_start();

// Include the database connection
$pdo = require 'database/db_connection.php';

// Function to generate a random six-digit OTP
function generateOTP($pdo, $user_id, $email) {
    $otp = rand(100000, 999999); // This will generate a random six-digit OTP

    $stmt = $pdo->prepare('INSERT INTO otp (user_id, otp) VALUES (:user_id, :otp)');
    $stmt->execute([
        'user_id' => $user_id,
        'otp' => $otp
    ]);

    sendOTP($email, $otp);
}

function sendOTP($email, $otp) {
    $to = $email;
    $subject = 'Your OTP for Account Verification';
    $message = "Your OTP is: $otp";
    
    // Gmail SMTP settings
    $smtp_host = 'smtp.gmail.com';
    $smtp_port = 587;
    $smtp_username = 'theshinjihideaki@gmail.com';
    $smtp_password = 'binq wxqs isob fwdo';
    
    // Email headers
    $headers = "From: theshinjihideaki@gmail.com\r\n";
    $headers .= "Reply-To: theshinjihideaki@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Set up socket connection
    $socket = fsockopen($smtp_host, $smtp_port, $errno, $errstr, 30);
    if (!$socket) {
        error_log("Failed to connect to SMTP server: $errstr ($errno)");
        return false;
    }

    // Read initial response
    fgets($socket, 515);

    // Send EHLO
    fwrite($socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
    fgets($socket, 515);

    // Start TLS
    fwrite($socket, "STARTTLS\r\n");
    fgets($socket, 515);
    stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);

    // Send EHLO again after TLS
    fwrite($socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
    fgets($socket, 515);

    // Authenticate
    fwrite($socket, "AUTH LOGIN\r\n");
    fgets($socket, 515);

    fwrite($socket, base64_encode($smtp_username) . "\r\n");
    fgets($socket, 515);

    fwrite($socket, base64_encode($smtp_password) . "\r\n");
    fgets($socket, 515);

    // Send mail
    fwrite($socket, "MAIL FROM:<theshinjihideaki@gmail.com>\r\n");
    fgets($socket, 515);

    fwrite($socket, "RCPT TO:<$to>\r\n");
    fgets($socket, 515);

    fwrite($socket, "DATA\r\n");
    fgets($socket, 515);

    fwrite($socket, "Subject: $subject\r\n");
    fwrite($socket, $headers . "\r\n");
    fwrite($socket, "\r\n");
    fwrite($socket, $message . "\r\n");
    fwrite($socket, ".\r\n");
    fgets($socket, 515);

    // Quit
    fwrite($socket, "QUIT\r\n");
    fgets($socket, 515);

    fclose($socket);
    return true;
}

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

                // Get the user_id after insertion
                $user_id_stmt = $pdo->prepare('SELECT user_id FROM users WHERE username = :username');
                $user_id_stmt->execute(['username' => $username]);
                $user_id = $user_id_stmt->fetchColumn();
                
                $otp = generateOTP($pdo, $user_id, $email);

                if ($otp) {
                    // Set success message and show delayed redirect page
                    $_SESSION['signup_success'] = true;
                }
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