<?php
session_start();
require 'database/db_connection.php';

$message = '';
$messageClass = '';

// Check if user is already verified
if (isset($_SESSION['verified']) && $_SESSION['verified'] === true) {
    header('Location: user-dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'] ?? '';
    
    if (!empty($entered_otp)) {
        try {
            // Get the latest OTP for the user from the session
            $user_id = $_SESSION['user_id'] ?? null;
            
            if ($user_id) {
                $stmt = $pdo->prepare('SELECT * FROM otp WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1');
                $stmt->execute(['user_id' => $user_id]);
                $otp_data = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($otp_data && $entered_otp == $otp_data['otp']) {
                    // Update OTP status to verified
                    $update_stmt = $pdo->prepare('UPDATE otp SET status = 1 WHERE id = :id');
                    $update_stmt->execute(['id' => $otp_data['id']]);
                    
                    // Set verification status in session
                    $_SESSION['verified'] = true;
                    
                    // Redirect to dashboard
                    header('Location: user-dashboard.php');
                    exit();
                } else {
                    $message = 'Invalid OTP. Please try again.';
                    $messageClass = 'error';
                }
            } else {
                $message = 'Session expired. Please try again.';
                $messageClass = 'error';
            }
        } catch (PDOException $e) {
            $message = 'Error verifying OTP: ' . $e->getMessage();
            $messageClass = 'error';
        }
    } else {
        $message = 'Please enter the OTP.';
        $messageClass = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Montserrat, sans-serif;
        }

        body {
            background: #FEF3E8;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .container {
            width: 930px;
            height: 575px;
            position: relative;
            background: #FEF3E8;
            overflow: hidden;
        }

        .right-section {
            width: 469px;
            height: 575px;
            position: absolute;
            right: 0;
            top: 0;
            background: #B07154;
            border-top-left-radius: 40px;
            border-bottom-left-radius: 40px;
            overflow: hidden;
        }

        .tagline {
            width: 276px;
            position: absolute;
            left: 97px;
            top: 362px;
            text-align: center;
            color: white;
            font-size: 19px;
            font-weight: 400;
            line-height: 26.60px;
            word-wrap: break-word;
        }

        .main-logo {
            width: 314px;
            height: 237px;
            position: absolute;
            left: 77px;
            top: 83px;
            object-fit: cover;
        }

        .subtitle {
            position: absolute;
            left: 138px;
            top: 266px;
            color: #B07154;
            font-size: 12px;
            font-weight: 400;
            line-height: 16.80px;
            word-wrap: break-word;
        }

        .title {
            position: absolute;
            left: 86px;
            top: 207px;
            color: #B07154;
            font-size: 30px;
            font-weight: 500;
            line-height: 42px;
            word-wrap: break-word;
        }

        .input-container {
            width: 267px;
            height: 42px;
            padding: 12px 16px;
            position: absolute;
            left: 102px;
            top: 328px;
            background: white;
            border-radius: 12px;
            border: 1px solid #B07154;
            display: flex;
            align-items: center;
        }

        .input-field {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: #727374;
            font-size: 13px;
            font-weight: 400;
            line-height: 18.20px;
        }

        .input-field::placeholder {
            color: #727374;
        }

        .verify-btn {
            width: 267px;
            height: 42px;
            position: absolute;
            left: 102px;
            top: 391px;
            background: #B07154;
            border-radius: 15px;
            border: none;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .verify-btn-text {
            color: white;
            font-size: 13px;
            font-weight: 700;
            line-height: 18.20px;
            word-wrap: break-word;
        }

        .back-btn {
            width: 53px;
            height: 22px;
            position: absolute;
            left: -1px;
            top: 12px;
            background: #B07154;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            border: 1px solid white;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .back-btn-text {
            color: white;
            font-size: 9px;
            font-weight: 700;
            line-height: 12.60px;
            word-wrap: break-word;
        }

        .small-logo {
            width: 314px;
            height: 237px;
            position: absolute;
            left: 73px;
            top: 10px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="right-section">
            <img src="images/logo1.jpg" alt="Main Logo" class="main-logo">
            <p class="tagline">"Your premier digital library for borrowing and reading books"</p>
        </div>

        <h1 class="title">Check your Mailbox</h1>
        <p class="subtitle">Please enter the OTP to proceed</p>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageClass; ?>" style="position: absolute; left: 102px; top: 290px; color: red; font-size: 13px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="input-container">
                <input type="text" name="otp" class="input-field" placeholder="OTP" required>
            </div>
            
            <button type="submit" class="verify-btn">
                <span class="verify-btn-text">VERIFY</span>
            </button>
        </form>
        
        <button class="back-btn" onclick="window.location.href='forgot-password.html'">
            <span class="back-btn-text">BACK</span>
        </button>
        
        <img src="images/logo3.png" alt="Logo" class="small-logo">
    </div>
</body>
</html>