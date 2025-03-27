<?php
session_start();
$pdo = require 'database/db_connection.php';

// Handle form submission
if (isset($_POST['confirm_return'])) {
    $book_id = $_POST['book_id'];
    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Update borrowed_books table
        $stmt = $pdo->prepare("UPDATE borrowed_books 
                             SET return_date = CURRENT_TIMESTAMP 
                             WHERE book_id = ? AND user_id = ? AND return_date IS NULL");
        $stmt->execute([$book_id, $_SESSION['user_id']]);

        // Commit transaction
        $pdo->commit();

        // Show success message and close popup
        echo "<script>
            alert('Book Returned Successfully');
            window.opener.sessionStorage.setItem('bookReturned', 'true');
            window.close();
        </script>";
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

// Get book details for display
$book_id = $_GET['id'] ?? null;
if (!$book_id) {
    echo "<script>alert('No book selected'); window.close();</script>";
    exit();
}

try {
    // Fetch book details with borrow information
    $stmt = $pdo->prepare("
        SELECT b.*, bb.borrow_date, bb.due_date 
        FROM borrowed_books bb 
        JOIN books b ON bb.book_id = b.book_id 
        WHERE b.book_id = ? AND bb.user_id = ? AND bb.return_date IS NULL
    ");
    $stmt->execute([$book_id, $_SESSION['user_id']]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        echo "<script>alert('Book not found or already returned'); window.close();</script>";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/user-return-confirm.css">
</head>

<body>
    <div class="container">
        <div class="table-container">
            <div class="table-header">
                <div>Book ID</div>
                <div>Name</div>
                <div>Type</div>
                <div>Language</div>
            </div>
            <div class="table-row">
                <div class="book-id"><?php echo htmlspecialchars($book['book_id']); ?></div>
                <div class="book-name"><?php echo htmlspecialchars($book['title']); ?></div>
                <div class="book-type"><?php echo htmlspecialchars($book['type']); ?></div>
                <div class="book-language"><?php echo htmlspecialchars($book['language']); ?></div>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-left">
                <div class="summary-id">ID</div>
                <div class="summary-count">1</div>
            </div>
            <div class="summary-right">
                <div class="summary-row">
                    <div class="summary-label">Total Books :</div>
                    <div class="summary-value">01 Book</div>
                </div>
                <div class="summary-row">
                    <div class="summary-label">Due Date :</div>
                    <div class="summary-value"><?php echo date('F d, Y', strtotime($book['due_date'])); ?></div>
                </div>
            </div>
            <div class="summary-divider"></div>
        </div>

        <button class="close-button" onclick="confirmReturn(<?php echo $book['book_id']; ?>)">CONFIRM RETURN</button>
    </div>

    <script>
        function confirmReturn(bookId) {
            if (confirm('Are you sure you want to return this book?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                <input type="hidden" name="book_id" value="${bookId}">
                <input type="hidden" name="confirm_return" value="1">
            `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>

</html>