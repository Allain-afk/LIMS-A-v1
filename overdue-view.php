<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>overdue view</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            width: 1140px;
            height: 740px;
            position: relative;
            background: #FEF3E8;
            overflow: hidden;
            border-radius: 12px;
            outline: 1px #E8E8E8 solid;
            outline-offset: -0.5px;
        }

        .books-table {
            width: 1087px;
            height: 558px;
            left: 26px;
            top: 25px;
            position: absolute;
            background: white;
            overflow: hidden;
            border-radius: 12px;
            outline: 1px #E8E8E8 solid;
            outline-offset: -1px;
        }

        .table-header-divider {
            width: 1029px;
            height: 0px;
            left: 29px;
            top: 58px;
            position: absolute;
            outline: 1px #E8E8E8 solid;
            outline-offset: -0.50px;
        }

        .header-text {
            color: #B07154;
            font-size: 16px;
            font-family: Montserrat;
            font-weight: 500;
            line-height: 22.40px;
            word-wrap: break-word;
            position: absolute;
            top: 24px;
        }

        .header-language {
            left: 910px;
        }

        .header-bookid {
            left: 85px;
        }

        .header-name {
            left: 355px;
        }

        .header-type {
            left: 645px;
        }

        .book-row {
            width: 1034px;
            height: 68px;
            left: 24px;
            position: absolute;
        }

        .row-1 {
            top: 58px;
        }

        .row-2 {
            top: 126px;
        }

        .row-3 {
            top: 194px;
        }

        .row-4 {
            top: 262px;
        }

        .row-5 {
            top: 330px;
        }

        .row-6 {
            top: 398px;
        }

        .row-7 {
            top: 466px;
        }

        .book-text {
            color: #B07154;
            font-size: 16px;
            font-family: Montserrat;
            font-weight: 400;
            line-height: 22.40px;
            word-wrap: break-word;
            position: absolute;
            top: 23px;
        }

        .book-id {
            left: 91px;
        }

        .book-name {
            left: 288px;
        }

        .book-language {
            left: 897px;
        }

        .book-type {
            left: 595px;
        }

        .book-summary {
            width: 408px;
            height: 115px;
            left: 26px;
            top: 600px;
            position: absolute;
            overflow: hidden;
            border-radius: 12px;
            outline: 1px #E8E8E8 solid;
            outline-offset: -1px;
        }

        .total-books-text {
            left: 258px;
            top: 21px;
            position: absolute;
            color: #B07154;
            font-size: 20px;
            font-family: Montserrat;
            font-weight: 400;
            line-height: 28px;
            word-wrap: break-word;
        }

        .book-count {
            left: 37px;
            top: 63px;
            position: absolute;
            color: #B07154;
            font-size: 30px;
            font-family: Montserrat;
            font-weight: 400;
            line-height: 42px;
            word-wrap: break-word;
        }

        .due-date {
            left: 237px;
            top: 68px;
            position: absolute;
            color: #B07154;
            font-size: 20px;
            font-family: Montserrat;
            font-weight: 400;
            line-height: 28px;
            word-wrap: break-word;
        }

        .total-books-label {
            left: 122px;
            top: 21px;
            position: absolute;
            color: #B07154;
            font-size: 19px;
            font-family: Montserrat;
            font-weight: 600;
            line-height: 26.60px;
            word-wrap: break-word;
        }

        .id-label {
            left: 34px;
            top: 14px;
            position: absolute;
            color: #B07154;
            font-size: 25px;
            font-family: Montserrat;
            font-weight: 600;
            line-height: 35px;
            word-wrap: break-word;
        }

        .due-date-label {
            left: 122px;
            top: 68px;
            position: absolute;
            color: #B07154;
            font-size: 19px;
            font-family: Montserrat;
            font-weight: 600;
            line-height: 26.60px;
            word-wrap: break-word;
        }

        .vertical-divider {
            width: 100px;
            height: 0px;
            left: 103px;
            top: 108px;
            position: absolute;
            transform: rotate(-90deg);
            transform-origin: top left;
            outline: 1.50px #B07154 solid;
            outline-offset: -0.75px;
        }

        .close-button {
            width: 259px;
            height: 54px;
            left: 824px;
            top: 636px;
            position: absolute;
            background: #B07154;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .close-text {
            color: white;
            font-size: 16px;
            font-family: Montserrat;
            font-weight: 700;
            line-height: 22.40px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="books-table">
            <div class="table-header-divider"></div>
            <div class="header-text header-language">Language</div>
            <div class="header-text header-bookid">Book ID</div>
            <div class="header-text header-name">Name</div>
            <div class="header-text header-type">Type</div>
            
            <div class="book-row row-1">
                <div class="book-text book-id">1</div>
                <div class="book-text book-name">Hibernate - Core</div>
                <div class="book-text book-language">English</div>
                <div class="book-text book-type">Educational</div>
            </div>
            
            <div class="book-row row-2">
                <div class="book-text book-id">2</div>
                <div class="book-text book-name">Java Programming</div>
                <div class="book-text book-language">English</div>
                <div class="book-text book-type">Educational</div>
            </div>
            
            <div class="book-row row-3">
                <div class="book-text book-id">3</div>
                <div class="book-text book-name">Web Development</div>
                <div class="book-text book-language">English</div>
                <div class="book-text book-type">Educational</div>
            </div>
            
            <div class="book-row row-4">
                <div class="book-text book-id">4</div>
                <div class="book-text book-name">Database Design</div>
                <div class="book-text book-language">English</div>
                <div class="book-text book-type">Educational</div>
            </div>
            
            <div class="book-row row-5">
                <div class="book-text book-id">5</div>
                <div class="book-text book-name">Python Basics</div>
                <div class="book-text book-language">English</div>
                <div class="book-text book-type">Educational</div>
            </div>
            
            <div class="book-row row-6">
                <div class="book-text book-id">6</div>
                <div class="book-text book-name">Data Structures</div>
                <div class="book-text book-language">English</div>
                <div class="book-text book-type">Educational</div>
            </div>
            
            <div class="book-row row-7">
                <div class="book-text book-id">7</div>
                <div class="book-text book-name">Algorithms</div>
                <div class="book-text book-language">English</div>
                <div class="book-text book-type">Educational</div>
            </div>
        </div>
        
        <div class="book-summary">
            <div class="total-books-text">07 Books</div>
            <div class="book-count">7</div>
            <div class="due-date">13 - 12 - 2024</div>
            <div class="total-books-label">Total Books :</div>
            <div class="id-label">ID</div>
            <div class="due-date-label">Due Date :</div>
            <div class="vertical-divider"></div>
        </div>
        
        <div class="close-button" onclick="window.location.href='dashboard.html'">
            <div class="close-text">CLOSE</div>
        </div>
    </div>

    <script>
        // Add functionality to close button
        document.querySelector('.close-button').addEventListener('click', function() {
            window.location.href = 'dashboard.html';
        });
    </script>
</body>
</html>
