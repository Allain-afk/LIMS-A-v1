<?php
// Start session at the beginning of the file
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit();
}

// Get admin name from session
$adminFirstName = $_SESSION['admin_first_name'] ?? 'Admin';
$adminLastName = $_SESSION['admin_last_name'] ?? '';

// Include the database connection
$pdo = require 'database/db_connection.php';

// Fetch branches from database
try {
    $stmt = $pdo->query('SELECT branch_id, branch_name, branch_location FROM branches ORDER BY branch_id');
    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching branches: " . $e->getMessage());
    $branches = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/user-management.css">
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="images/logo1.jpg" alt="Book King Logo">
        </div>
        <div class="nav-group">
            <a href="admin-dashboard.php" class="nav-item">
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
            <a href="book-management.php" class="nav-item">
                <div class="icon">
                    <img src="images/Books.jpg" alt="Books" width="24" height="24">
                </div>
                <div class="text">Books</div>
            </a>
            <a href="user-management.php" class="nav-item">
                <div class="icon">
                    <img src="images/people 3.png" alt="Users" width="24" height="24">
                </div>
                <div class="text">Users</div>
            </a>
            <a href="#" class="nav-item active">
                <div class="icon">
                    <img src="images/buildings-2 1.png" alt="Branches" width="24" height="24">
                </div>
                <div class="text">Branches</div>
            </a>
        </div>
        <a href="admin-logout.php" class="nav-item logout">
            <div class="icon">
                <img src="images/logout 3.png" alt="Log Out" width="24" height="24">
            </div>
            <div class="text">Log Out</div>
        </a>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="header-left">
                <div class="user-profile">
                    <div class="user-icon">
                        <img src="images/user.png" alt="User Icon">
                    </div>
                    <div class="user-info">
                        <div class="user-name"><?= htmlspecialchars($adminFirstName . ' ' . $adminLastName) ?></div>
                        <div class="user-role">Admin</div>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="datetime-profile">
                    <div class="datetime">
                        <div class="time" id="current-time"></div>
                        <div class="date" id="current-date"></div>
                    </div>
                    <div class="vertical-line"></div>
                    <div class="settings-icon">
                        <img src="images/Vector.jpg" alt="Settings">
                    </div>
                </div>
            </div>
        </div>

        <div class="page-title">Branch Management</div>

        <div class="actions-container">
            <button class="add-book-btn">
                <div class="add-book-icon"></div>
                <div class="add-book-text">Add Branch</div>
            </button>
            <div class="search-container">
                <div class="search-wrapper">
                    <div class="search-icon"></div>
                    <input type="text" class="search-input" placeholder="Search by ID or Branch Name">
                </div>
            </div>
        </div>

        <div class="content-table">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Branch ID</th>
                            <th>Branch Name</th>
                            <th>Location</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($branches)): ?>
                            <?php foreach ($branches as $branch): ?>
                                <tr>
                                    <td><?= htmlspecialchars($branch['branch_id']) ?></td>
                                    <td><?= htmlspecialchars($branch['branch_name']) ?></td>
                                    <td><?= htmlspecialchars($branch['branch_location']) ?></td>
                                    <td class="action-cell">
                                        <button class="action-btn">
                                            <img src="images/btn edit.jpg" alt="Edit">
                                        </button>
                                        <button class="action-btn">
                                            <img src="images/btn Delete.jpg" alt="Delete">
                                        </button>
                                        <button class="action-btn">
                                            <img src="images/btn view.svg" alt="Check">
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">No branches found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();

            // Update time
            const timeDiv = document.getElementById('current-time');
            timeDiv.textContent = now.toLocaleString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });

            // Update date
            const dateDiv = document.getElementById('current-date');
            dateDiv.textContent = now.toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            });
        }

        // Update immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>

</html>