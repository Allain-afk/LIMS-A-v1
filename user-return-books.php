<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Include the database connection
$pdo = require 'database/db_connection.php';

// Get user's full name from session
$userFullName = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Returned Books Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/user-return-books.css">
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
                <div class="current-time">12:29 PM</div>
                <div class="current-date">Sep 02, 2023</div>
            </div>
            <div class="settings-icon">
                <img src="images/Vector.png" alt="Settings">
            </div>
        </div>

        <div class="tabs">
            <div class="tab active">Return Books</div>
        </div>

        <div class="search-container">
            <div class="search-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.58317 17.5C13.9554 17.5 17.4998 13.9555 17.4998 9.58329C17.4998 5.21104 13.9554 1.66663 9.58317 1.66663C5.21092 1.66663 1.6665 5.21104 1.6665 9.58329C1.6665 13.9555 5.21092 17.5 9.58317 17.5Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18.3332 18.3333L16.6665 16.6666" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <input type="text" class="search-input" placeholder="Search by ID or Type">
        </div>

        <div class="content-card">
            <div class="table-container">
                <div class="table-header">
                    <div>ID</div>
                    <div>Book Title</div>
                    <div>Type</div>
                    <div>Language</div>
                    <div>Borrow Date</div>
                    <div>Status</div>
                    <div>Action</div>
                </div>

                <?php
                // Fetch borrowed books from database
                $user_id = $_SESSION['user_id'];
                try {
                    $stmt = $pdo->prepare("
                        SELECT b.*, bb.borrow_date, bb.due_date, bb.return_date 
                        FROM borrowed_books bb 
                        JOIN books b ON bb.book_id = b.book_id 
                        WHERE bb.user_id = ?
                        ORDER BY bb.borrow_date DESC
                    ");
                    $stmt->execute([$user_id]);
                    $borrowed_books = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($borrowed_books as $book) {
                        $isReturned = !is_null($book['return_date']);
                        $statusClass = $isReturned ? 'status-returned' : 'status-borrowed';
                        $statusText = $isReturned ? 'Returned' : 'Borrowed';

                        $buttonAttr = $isReturned ? 'disabled' : sprintf('onclick="openReturnConfirm(%d)"', $book['book_id']);
                        $imageStyle = $isReturned ? 'style="opacity: 0.5;"' : '';

                        echo "<div class='table-row'>
                            <div>{$book['book_id']}</div>
                            <div>{$book['title']}</div>
                            <div>{$book['type']}</div>
                            <div>{$book['language']}</div>
                            <div>" . date('d-m-Y', strtotime($book['borrow_date'])) . "</div>
                            <div class='{$statusClass}'>{$statusText}</div>
                            <div>
                                <button class='action-btn' {$buttonAttr}>
                                    <img src='images/btn view.jpg' alt='View' style='width: 17px; height: 17px;' {$imageStyle}>
                                </button>
                            </div>
                        </div>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </div>

    <div class="book-king-sidebar">
        <div>B</div>
        <div>O</div>
        <div>O</div>
        <div>K</div>
        <div>&nbsp;</div>
        <div>K</div>
        <div>I</div>
        <div>N</div>
        <div>G</div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const timeElement = document.querySelector('.current-time');
            const dateElement = document.querySelector('.current-date');

            timeElement.textContent = now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            dateElement.textContent = now.toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            });
        }

        setInterval(updateTime, 1000);
        updateTime();

        // Replace the existing openReturnConfirm function
        function openReturnConfirm(bookId) {
            // Open the confirmation popup with the book ID as a query parameter
            const popup = window.open(`user-return-book-confirm.php?id=${bookId}`, 'ReturnBookConfirm',
                'width=1200,height=700,resizable=no');

            // Center the popup
            const left = (screen.width - 1200) / 2;
            const top = (screen.height - 700) / 2;
            popup.moveTo(left, top);

            // Add event listener to handle popup window closing
            window.addEventListener('storage', function(e) {
                if (e.key === 'bookReturned' && e.newValue === 'true') {
                    location.reload();
                    sessionStorage.removeItem('bookReturned');
                }
            });
        }

        function handleLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>

</html>