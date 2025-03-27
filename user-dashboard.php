<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Include database connection
$pdo = require 'database/db_connection.php';

// Get the logged-in user's full name
$userFullName = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];

// Get borrow and return counts
try {
    // Get total borrows count
    $stmtBorrows = $pdo->prepare("SELECT COUNT(*) FROM borrowed_books WHERE user_id = ?");
    $stmtBorrows->execute([$_SESSION['user_id']]);
    $totalBorrows = $stmtBorrows->fetchColumn();

    // Get total returns count
    $stmtReturns = $pdo->prepare("SELECT COUNT(*) FROM borrowed_books WHERE user_id = ? AND return_date IS NOT NULL");
    $stmtReturns->execute([$_SESSION['user_id']]);
    $totalReturns = $stmtReturns->fetchColumn();
} catch (PDOException $e) {
    $totalBorrows = 0;
    $totalReturns = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/user-dashboard.css">
    <script>
        function updateTime() {
            const now = new Date();

            // Update time
            const timeString = now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
            document.getElementById('current-time').textContent = timeString;

            // Update date
            const dateString = now.toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            });
            document.getElementById('current-date').textContent = dateString;
        }

        // Update time every second
        setInterval(updateTime, 1000);

        // Initial call to display time immediately
        document.addEventListener('DOMContentLoaded', updateTime);
    </script>
</head>

<body>
    <div class="sidebar">
        <div class="logo-container">
            <img src="images/logo1.png" alt="Book King Logo">
        </div>
        <div class="sidebar-item home" onclick="window.location.href='user-dashboard.php'">
            <img src="images/element-2 2.svg" alt="Home" class="icon-image">
        </div>
        <div class="sidebar-item list" onclick="window.location.href='user-return-books.php'">
            <img src="images/Vector.svg" alt="List" class="icon-image">
        </div>
        <div class="sidebar-item book" onclick="window.location.href='user-borrow-books.php'">
            <img src="images/Books.png" alt="Book" class="icon-image">
        </div>
        <div class="sidebar-item logout" onclick="handleLogout()">
            <img src="images/logout 3.png" alt="Logout" class="icon-image">
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="user-info">
                <div class="user-icon">
                    <img src="images/user.png" alt="User">
                </div>
                <div>
                    <div class="user-name"><?php echo htmlspecialchars($userFullName); ?></div>
                    <div class="user-role">User</div>
                </div>
            </div>
            <div class="time">
                <div id="current-time" class="current-time"></div>
                <div id="current-date" class="current-date"></div>
            </div>
            <div class="settings-icon">
                <a href="User Settings Form.html">
                    <img src="images/Vector.png" alt="Settings">
                </a>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-icon">
                    <img src="images/book-square 2.png" alt="Borrowed Books">
                </div>
                <div class="card-content">
                    <div class="card-title">Your Borrowed<br>Book Logs</div>
                    <div class="card-divider"></div>
                    <div class="card-count"><?php echo $totalBorrows; ?> Books</div>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <img src="images/redo 1.png" alt="Returned Books">
                </div>
                <div class="card-content">
                    <div class="card-title">Your Returned<br>Book Logs</div>
                    <div class="card-divider"></div>
                    <div class="card-count"><?php echo $totalReturns; ?> Books</div>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <img src="images/image 1.png" alt="Browse Books">
                </div>
                <div class="card-content">
                    <div class="card-title">Let's browse available book inventory</div>
                </div>
            </div>

            <div class="quote-card">
                <div class="quote-text">"Embarking on the journey of reading fosters personal growth, nurturing a path towards excellence and the refinement of character."</div>
                <div class="quote-author">~ Book king Team</div>
            </div>
        </div>
    </div>

    <script>
        function handleLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>

</html>