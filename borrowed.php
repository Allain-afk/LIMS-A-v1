<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Borrowed Books</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        html, body {
            height: 100%;
            min-height: 1080px;
            background: #FEF3E8;
            position: relative;
            overflow: hidden;
        }

        .wave {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.7" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,128C672,128,768,160,864,160C960,160,1056,128,1152,117.3C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            pointer-events: none;
            z-index: 0;
        }

        .wave2 {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.5" d="M0,64L48,80C96,96,192,128,288,138.7C384,149,480,139,576,122.7C672,107,768,85,864,90.7C960,96,1056,128,1152,138.7C1248,149,1344,139,1392,133.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            pointer-events: none;
            z-index: 0;
            animation: wave 10s linear infinite;
        }

        @keyframes wave {
            0% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(-25%);
            }
            100% {
                transform: translateX(0);
            }
        }

        .sidebar {
            width: 222px;
            height: 1080px;
            background: #B07154;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 1;
        }

        .logo {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 158px;
        }

        .logo img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin: 0 auto;
        }

        .nav-group {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .nav-item {
            width: 222px;
            height: 48px;
            background: #F4DECB;
            display: flex;
            align-items: center;
            text-decoration: none;
            position: absolute;
        }

        .nav-item.active {
            background: #FFFFFF;
        }

        .nav-item .icon {
            width: 24px;
            height: 24px;
            position: absolute;
            left: 41px;
            top: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-item .text {
            position: absolute;
            left: 85px;
            top: 12px;
            color: #B07154;
            font-size: 16px;
            font-weight: 600;
            line-height: 22.4px;
        }

        /* Navigation item positions */
        .nav-group .nav-item:nth-child(1) { top: 158px; } /* Dashboard */
        .nav-group .nav-item:nth-child(2) { top: 226px; } /* Catalog */
        .nav-group .nav-item:nth-child(3) { top: 294px; } /* Books */
        .nav-group .nav-item:nth-child(4) { top: 362px; } /* Users */
        .nav-group .nav-item:nth-child(5) { top: 430px; } /* Branches */

        /* Logout position */
        .sidebar > .nav-item:last-child {
            position: fixed;
            bottom: 48px;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 222px;
            right: 0;
            height: 72px;
            background: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 1;
        }

        .user-profile {
            display: flex;
            align-items: flex-start;
            gap: 7px;
        }

        .user-icon {
            width: 34px;
            height: 34px;
            position: relative;
            overflow: hidden;
            margin-top: 4px;
        }

        .user-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .user-name {
            color: #B07154;
            font-size: 16px;
            font-weight: 600;
            line-height: 22.4px;
            margin-top: 1px;
        }

        .user-role {
            color: #B07154;
            font-size: 12px;
            font-weight: 600;
            line-height: 16.8px;
        }

        .datetime-profile {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .datetime {
            text-align: right;
            margin-right: 0;
        }

        .time {
            color: #B07154;
            font-size: 16px;
            font-weight: 700;
            line-height: 22.4px;
            margin-top: 2px;
        }

        .date {
            color: #B07154;
            font-size: 13px;
            font-weight: 500;
            line-height: 18.2px;
            margin-top: 2px;
        }

        .profile-icon {
            width: 38px;
            height: 38px;
            position: relative;
            overflow: hidden;
            margin-top: 2px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .profile-icon:hover {
            transform: scale(1.1);
        }

        .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .vertical-line {
            width: 2px;
            height: 38px;
            background: #B07154;
            margin: 0 8px;
            margin-top: 2px;
        }

        .page-title {
            position: fixed;
            top: 87px;
            left: 242px;
            height: 38px;
            background: #F4DECB;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            padding: 8px 20px;
            width: 200px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .page-title:hover {
            background: #f0d3bc;
            transform: translateY(-1px);
        }

        .page-title-text {
            color: #B07154;
            font-size: 16px;
            font-family: Montserrat;
            font-weight: 600;
            line-height: 22.40px;
            white-space: nowrap;
        }

        .overdue-section {
            position: fixed;
            top: 87px;
            left: 442px;
            height: 38px;
            background: #B07154;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 8px 20px;
            width: 200px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .overdue-section:hover {
            background: #9b634a;
            transform: translateY(-1px);
        }

        .overdue-text {
            color: white;
            font-size: 16px;
            font-family: Montserrat;
            font-weight: 600;
            line-height: 22.40px;
            white-space: nowrap;
        }

        .search-container {
            position: relative;
            margin: 20px;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 8px;
            padding: 8px 16px;
            box-shadow: 0 2px 4px rgba(176, 113, 84, 0.1);
        }

        .search-input {
            border: none;
            outline: none;
            width: 100%;
            padding: 8px;
            color: #B07154;
            font-size: 14px;
        }

        .search-input::placeholder {
            color: #B07154;
            opacity: 0.7;
        }

        .search-icon {
            width: 24px;
            height: 24px;
            background: url('images/search.jpg') no-repeat center;
            background-size: contain;
            opacity: 0.7;
        }

        .content-table {
            position: fixed;
            top: 165px;
            left: 242px;
            right: 20px;
            bottom: 20px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 4px rgba(176, 113, 84, 0.1);
            z-index: 1;
        }

        .table-container {
            overflow-y: auto;
            flex: 1;
            margin-right: -8px;
            padding-right: 8px;
        }

        .table-container::-webkit-scrollbar {
            width: 6px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #F4DECB;
            border-radius: 3px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #B07154;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead {
            position: sticky;
            top: 0;
            background: white;
            z-index: 1;
        }

        th {
            color: #B07154;
            font-size: 14px;
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #F4DECB;
            background: white;
        }

        td {
            color: #B07154;
            font-size: 14px;
            font-weight: 400;
            padding: 15px;
            border-bottom: 1px solid #F4DECB;
        }

        tbody tr:hover {
            background-color: #FEF3E8;
        }

        .action-cell {
            display: flex;
            gap: 33px;
            justify-content: center;
            align-items: center;
        }

        .action-btn {
            width: 24px;
            height: 24px;
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn img {
            width: 24px;
            height: 24px;
            transition: transform 0.2s ease;
        }

        .action-btn:hover img {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="wave"></div>
    <div class="wave2"></div>
    <div class="sidebar">
        <div class="logo">
            <img src="images/logo1.jpg" alt="Book King Logo">
        </div>
        <div class="nav-group">
            <a href="#" class="nav-item active">
                <div class="icon">
                    <img src="images/element-2 2.svg" alt="Dashboard" width="24" height="24">
                </div>
                <div class="text">Dashboard</div>
            </a>
            <a href="#" class="nav-item">
                <div class="icon">
                    <img src="images/Vector.svg" alt="Catalog" width="20" height="20">
                </div>
                <div class="text">Catalog</div>
            </a>
            <a href="#" class="nav-item">
                <div class="icon">
                    <img src="images/Books.jpg" alt="Books" width="24" height="24">
                </div>
                <div class="text">Books</div>
            </a>
            <a href="#" class="nav-item">
                <div class="icon">
                    <img src="images/people 3.png" alt="Users" width="24" height="24">
                </div>
                <div class="text">Users</div>
            </a>
            <a href="#" class="nav-item">
                <div class="icon">
                    <img src="images/buildings-2 1.png" alt="Branches" width="24" height="24">
                </div>
                <div class="text">Branches</div>
            </a>
        </div>
        <a href="#" class="nav-item">
            <div class="icon">
                <img src="images/logout 3.png" alt="Log Out" width="24" height="24">
            </div>
            <div class="text">Log Out</div>
        </a>
    </div>

    <header class="header">
        <div class="user-profile">
            <div class="user-icon">
                <img src="images/user.png" alt="User Icon">
            </div>
            <div class="user-info">
                <div class="user-name">Ayham kalsam</div>
                <div class="user-role">Admin</div>
            </div>
        </div>
        <div class="datetime-profile">
            <div class="datetime">
                <div class="time">12:29 PM</div>
                <div class="date">Sep 02, 2023</div>
            </div>
            <div class="vertical-line"></div>
            <div class="profile-icon">
                <img src="images/image.png" alt="Profile Icon">
            </div>
        </div>
    </header>

    <div class="search-container">
        <div class="search-wrapper">
            <div class="search-icon"></div>
            <input type="text" class="search-input" placeholder="Search...">
        </div>
    </div>

    <a href="Borrowed.html" class="page-title">
        <div class="page-title-text">Borrowed Books</div>
    </a>

    <a href="Overdue.html" class="overdue-section">
        <div class="overdue-text">Overdue Borrowers</div>
    </a>

    <div class="content-table">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Date & Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>002 Books</td>
                        <td>14 - 03 - 2025</td>
                        <td>25-04-2025 10:39 AM</td>
                        <td class="action-cell">
                            <button class="action-btn">
                                <img src="images/btn view.svg" alt="View">
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function updateDateTime() {
            const now = new Date();
            
            // Update time
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // convert 0 to 12
            document.querySelector('.time').textContent = `${hours}:${minutes} ${ampm}`;
            
            // Update date
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const day = now.getDate().toString().padStart(2, '0');
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            document.querySelector('.date').textContent = `${month} ${day}, ${year}`;
        }

        // Update immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>
</html>