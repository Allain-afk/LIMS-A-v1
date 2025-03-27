<?php
session_start();

// Include the database connection
$pdo = require 'database/db_connection.php';

// Fetch books data from the database
try {
    $stmt = $pdo->query('SELECT * FROM books ORDER BY book_id');
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error fetching books: ' . $e->getMessage());
}

// Get user's full name from session
$userFullName = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Borrow Books</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/user-borrow-books.css">
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
                <a href="#" class="clickable-icon">
                    <img src="images/Vector.png" alt="Settings">
                </a>
            </div>
        </div>

        <div class="page-title">Library Lane Books</div>

        <div class="search-container">
            <div class="search-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.58317 17.5C13.9554 17.5 17.4998 13.9555 17.4998 9.58329C17.4998 5.21104 13.9554 1.66663 9.58317 1.66663C5.21092 1.66663 1.6665 5.21104 1.6665 9.58329C1.6665 13.9555 5.21092 17.5 9.58317 17.5Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18.3332 18.3333L16.6665 16.6666" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <input type="text" class="search-input" placeholder="Search by ID, Type or Title" oninput="searchBooks()">
        </div>

        <div class="table-container">
            <div class="table-header">
                <div>ID</div>
                <div>Name</div>
                <div>Type</div>
                <div>Language</div>
                <div>Availability</div>
                <div>Add to Cart</div>
            </div>
            <?php foreach ($books as $book): ?>
                <div class="table-row">
                    <div class="book-id"><?php echo htmlspecialchars($book['book_id']); ?></div>
                    <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
                    <div class="book-type"><?php echo htmlspecialchars($book['type']); ?></div>
                    <div class="book-language"><?php echo htmlspecialchars($book['language']); ?></div>
                    <div class="book-availability"><?php echo isset($book['availability']) ? htmlspecialchars($book['availability']) : 'Available'; ?></div>
                    <div>
                        <input type="checkbox" class="book-checkbox"
                            data-book-id="<?php echo htmlspecialchars($book['book_id']); ?>"
                            data-book-title="<?php echo htmlspecialchars($book['title']); ?>"
                            data-book-type="<?php echo htmlspecialchars($book['type']); ?>"
                            data-book-language="<?php echo htmlspecialchars($book['language']); ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="acquire-button" onclick="processSelectedBooks()">
            <div class="acquire-icon"></div>
            <span>Acquire</span>
        </button>
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
        // Add real-time clock functionality
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

        // Add this after your existing script
        function processSelectedBooks() {
            const selectedBooks = [];
            document.querySelectorAll('.book-checkbox:checked').forEach(checkbox => {
                selectedBooks.push({
                    id: checkbox.dataset.bookId,
                    title: checkbox.dataset.bookTitle,
                    type: checkbox.dataset.bookType,
                    language: checkbox.dataset.bookLanguage
                });
            });

            if (selectedBooks.length === 0) {
                alert('Please select at least one book');
                return;
            }

            // Store selected books in session storage
            sessionStorage.setItem('selectedBooks', JSON.stringify(selectedBooks));
            window.location.href = 'user-borrow-confirm.php';
        }

        // Replace the existing searchBooks function with this one
        function searchBooks() {
            const searchInput = document.querySelector('.search-input');
            const searchTerm = searchInput.value.toLowerCase().trim();
            const tableRows = document.querySelectorAll('.table-row');

            tableRows.forEach(row => {
                const id = row.querySelector('.book-id').textContent.toLowerCase();
                const title = row.querySelector('.book-title').textContent.toLowerCase();
                const type = row.querySelector('.book-type').textContent.toLowerCase();

                const matches = id.includes(searchTerm) ||
                    title.includes(searchTerm) ||
                    type.includes(searchTerm);

                row.style.display = matches ? '' : 'none';
            });
        }

        // a function to handle the logout button
        function handleLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }

        // Add these event listeners at the bottom of your script section
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');

            // Add input event listener for real-time search
            searchInput.addEventListener('input', searchBooks);

            // Add keyup event for immediate search on backspace
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Backspace' || e.key === 'Delete') {
                    searchBooks();
                }
            });
        });
    </script>
</body>

</html>