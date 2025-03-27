<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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

        .left-section {
            width: 469px;
            height: 575px;
            position: absolute;
            left: 0;
            top: 0;
            background: #B07154;
            border-top-right-radius: 40px;
            border-bottom-right-radius: 40px;
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
            left: 73px;
            top: 62px;
            object-fit: cover;
        }

        .subtitle {
            position: absolute;
            left: 622px;
            top: 266px;
            color: #B07154;
            font-size: 12px;
            font-weight: 400;
            line-height: 16.80px;
            word-wrap: break-word;
        }

        .title {
            position: absolute;
            left: 578px;
            top: 207px;
            color: #B07154;
            font-size: 30px;
            font-weight: 500;
            line-height: 42px;
            word-wrap: break-word;
        }

        .input-container {
            width: 267px;
            padding: 12px 16px;
            position: absolute;
            left: 573px;
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

        .reset-btn {
            width: 267px;
            height: 42px;
            position: absolute;
            left: 573px;
            top: 391px;
            background: #B07154;
            border-radius: 15px;
            border: none;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reset-btn-text {
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
            left: 879px;
            top: 12px;
            background: #B07154;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
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
            left: 550px;
            top: 10px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="images/logo1.jpg" alt="Main Logo" class="main-logo">
            <p class="tagline">"Your premier digital library for borrowing and reading books"</p>
        </div>

        <h1 class="title">Forgot Password</h1>
        <p class="subtitle">Please enter your username</p>
        
        <div class="input-container">
            <input type="text" class="input-field" placeholder="Username">
        </div>
        
        <button class="reset-btn">
            <span class="reset-btn-text">RESET PASSWORD</span>
        </button>
        
        <button class="back-btn" onclick="window.location.href='login.html'">
            <span class="back-btn-text">BACK</span>
        </button>
        
        <img src="images/logo3.png" alt="Logo" class="small-logo">
    </div>
</body>
</html>