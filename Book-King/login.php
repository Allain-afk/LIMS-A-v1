Here are the contents for the `login.php` file:

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            overflow: hidden;
        }

        .input-field {
            width: 267px;
            padding: 12px 16px;
            background: white;
            border-radius: 12px;
            border: 1px solid #B07154;
            color: #727374;
            font-size: 13px;
            font-weight: 400;
            line-height: 18.20px;
            outline: none;
        }

        .input-field::placeholder {
            color: #727374;
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

        .right-section img {
            width: 314px;
            height: 237px;
            position: absolute;
            left: 85px;
            top: 68px;
            object-fit: cover;
        }

        .signup-text {
            position: absolute;
            left: 119px;
            top: 360px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            line-height: 18.20px;
            word-wrap: break-word;
        }

        .signup-btn {
            width: 185px;
            height: 42px;
            position: absolute;
            left: 142px;
            top: 408px;
            background: #F4DECB;
            border-radius: 15px;
            border: 1px solid white;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signup-btn-text {
            color: #B07154;
            font-size: 13px;
            font-weight: 700;
            line-height: 18.20px;
            word-wrap: break-word;
        }

        .logo {
            width: 314px;
            height: 237px;
            position: absolute;
            left: 73px;
            top: 10px;
            object-fit: contain;
        }

        .welcome-text {
            position: absolute;
            left: 102px;
            top: 133px;
            color: #B07154;
            font-size: 30px;
            font-weight: 500;
            line-height: 42px;
            word-wrap: break-word;
        }

        .login-subtitle {
            position: absolute;
            left: 115px;
            top: 203px;
            color: #B07154;
            font-size: 12px;
            font-weight: 400;
            line-height: 16.80px;
            word-wrap: break-word;
        }

        .username-field {
            position: absolute;
            left: 96px;
            top: 255px;
        }

        .password-field {
            position: absolute;
            left: 95px;
            top: 316px;
        }

        .forgot-password {
            position: absolute;
            left: 96px;
            top: 374px;
            color: #B07154;
            font-size: 13px;
            font-weight: 500;
            line-height: 18.20px;
            text-decoration: none;
            word-wrap: break-word;
            cursor: pointer;
        }

        .signin-btn {
            width: 267px;
            height: 42px;
            position: absolute;
            left: 96px;
            top: 420px;
            background: #B07154;
            border-radius: 15px;
            border: none;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signin-btn-text {
            color: white;
            font-size: 13px;
            font-weight: 700;
            line-height: 18.20px;
            word-wrap: break-word;
        }
        
        .decorative-elements {
            position: absolute;
            width: 264.38px;
            height: 157.41px;
            left: 103px;
            top: 125px;
        }
        
        .decorative-elements div {
            position: absolute;
            background: white;
        }
        
        /* Individual decorative elements */
        .decorative-element-1 {
            width: 47.38px;
            height: 39.57px;
            left: 96.25px;
            top: 6.52px;
        }
        
        .decorative-element-2 {
            width: 23.38px;
            height: 20.33px;
            left: 133.98px;
            top: 36.16px;
        }
        
        .decorative-element-3 {
            width: 18.44px;
            height: 18.37px;
            left: 145.29px;
            top: 14.23px;
        }
        
        .decorative-element-4 {
            width: 22.93px;
            height: 14.54px;
            left: 106.51px;
            top: 47.03px;
        }
        
        .decorative-element-5 {
            width: 16.14px;
            height: 14.05px;
            left: 160.11px;
            top: 39.34px;
        }
        
        .decorative-element-6 {
            width: 16.95px;
            height: 11.12px;
            left: 120.36px;
            top: 62.68px;
        }
        
        .decorative-element-7 {
            width: 19.66px;
            height: 9.65px;
            left: 129.19px;
            top: 4.89px;
        }
        
        .decorative-element-8 {
            width: 12.89px;
            height: 15.29px;
            left: 93.62px;
            top: 34.55px;
        }
        
        .decorative-element-9 {
            width: 11.09px;
            height: 8.77px;
            left: 153.13px;
            top: 3.27px;
        }
        
        .decorative-element-10 {
            width: 8.21px;
            height: 10.13px;
            left: 91.27px;
            top: 50.10px;
        }
        
        .decorative-element-11 {
            width: 9.83px;
            height: 4.67px;
            left: 124.26px;
            top: 0px;
        }
        
        .decorative-element-12 {
            width: 5.44px;
            height: 7.48px;
            left: 88.12px;
            top: 27.39px;
        }
        
        .decorative-element-13 {
            width: 6.98px;
            height: 6.48px;
            left: 101.08px;
            top: 9.35px;
        }
        
        .decorative-element-14 {
            width: 264.38px;
            height: 39.82px;
            left: 0px;
            top: 91.45px;
        }
        
        .decorative-element-15 {
            width: 72.76px;
            height: 13.21px;
            left: 96.06px;
            top: 144.21px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="images/logo3.png" alt="Logo" class="logo">
        <h1 class="welcome-text">Welcome Back !!</h1>
        <p class="login-subtitle">Please enter your credentials to log in</p>
        
        <form method="POST" action="">
            <input type="text" name="username" class="input-field username-field" placeholder="Username" required>
            <input type="password" name="password" class="input-field password-field" placeholder="Password" required>
            <a class="forgot-password">Forgot password?</a>
            <button type="submit" class="signin-btn">
                <span class="signin-btn-text">SIGN IN</span>
            </button>
        </form>

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
            <button class="signup-btn">
                <span class="signup-btn-text">SIGN UP</span>
            </button>
        </div>
    </div>

    <?php
    include 'database/db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Successful login
            echo "<script>alert('Login successful!');</script>";
            // Redirect to another page or perform other actions
        } else {
            // Invalid credentials
            echo "<script>alert('Invalid username or password.');</script>";
        }
    }
    ?>
</body>
</html>