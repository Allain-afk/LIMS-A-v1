<?php
// Start the session
session_start();

// Include the database connection
$pdo = require 'database/db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header('Location: admin-login.php');
    exit();
}

// Fetch the admin's first name from the session
$adminFirstName = $_SESSION['admin_first_name'] ?? 'Admin';

// Debugging: Check if the session variable is available
error_log('Admin First Name in Dashboard: ' . ($_SESSION['admin_first_name'] ?? 'Not Set'));

// Get counts from database
try {
    // Count total users
    $userCount = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();

    // Count total books
    $bookCount = $pdo->query('SELECT COUNT(*) FROM books')->fetchColumn();

    // Count total branches
    $branchCount = $pdo->query('SELECT COUNT(*) FROM branches')->fetchColumn();
} catch (PDOException $e) {
    error_log("Error fetching counts: " . $e->getMessage());
    $userCount = 0;
    $bookCount = 0;
    $branchCount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin-dashboard.css">
</head>

<body>
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
            <a href="branch-management.php" class="nav-item">
                <div class="icon">
                    <img src="images/buildings-2 1.png" alt="Branches" width="24" height="24">
                </div>
                <div class="text">Branches</div>
            </a>
        </div>
        <a href="admin-logout.php" class="nav-item">
            <div class="icon">
                <img src="images/logout 3.png" alt="Log Out" width="24" height="24">
            </div>
            <div class="text">Log Out</div>
        </a>
    </div>
    <div class="content">
        <div class="header">
            <div class="admin-profile">
                <div class="admin-info">
                    <!-- Display the admin's first name -->
                    <span class="admin-name-1">Welcome, <?= htmlspecialchars($adminFirstName) ?></span>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="stats-container">
                <div class="stats-card">
                    <div class="stats-icon-container">
                        <img src="images/people 3.png" alt="Total Users" class="stats-icon">
                    </div>
                    <div class="stats-value"><?= htmlspecialchars($userCount) ?></div>
                    <div class="stats-label">Total Users</div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon-container">
                        <img src="images/Books.jpg" alt="Total Books" class="stats-icon">
                    </div>
                    <div class="stats-value"><?= htmlspecialchars($bookCount) ?></div>
                    <div class="stats-label">Total Book Count</div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon-container">
                        <img src="images/buildings-2 1.png" alt="Branch Count" class="stats-icon">
                    </div>
                    <div class="stats-value"><?= htmlspecialchars($branchCount) ?></div>
                    <div class="stats-label">Branch Count</div>
                </div>
            </div>
            <div class="cards-column">
                <div class="card">
                    <h2 class="card-title">Overdue Borrowers</h2>
                    <div class="borrower-list">
                        <div class="borrower-item">
                            <div class="borrower-icon">
                                <img src="images/Books.jpg" alt="Book" class="borrower-icon-img">
                            </div>
                            <div class="borrower-info">
                                <span class="borrower-name">Allain Legaspi</span>
                                <span class="borrower-id">Borrowed ID : 10</span>
                            </div>
                            <div class="action-icon">
                                <img src="images/btn view.svg" alt="View" class="action-icon-img">
                            </div>
                        </div>
                        <div class="borrower-item">
                            <div class="borrower-icon">
                                <img src="images/Books.jpg" alt="Book" class="borrower-icon-img">
                            </div>
                            <div class="borrower-info">
                                <span class="borrower-name">Allain Legaspi</span>
                                <span class="borrower-id">Borrowed ID : 10</span>
                            </div>
                            <div class="action-icon">
                                <img src="images/btn view.svg" alt="View" class="action-icon-img">
                            </div>
                        </div>
                        <div class="borrower-item">
                            <div class="borrower-icon">
                                <img src="images/Books.jpg" alt="Book" class="borrower-icon-img">
                            </div>
                            <div class="borrower-info">
                                <span class="borrower-name">Allain Legaspi</span>
                                <span class="borrower-id">Borrowed ID : 10</span>
                            </div>
                            <div class="action-icon">
                                <img src="images/btn view.svg" alt="View" class="action-icon-img">
                            </div>
                        </div>
                        <div class="borrower-item">
                            <div class="borrower-icon">
                                <img src="images/Books.jpg" alt="Book" class="borrower-icon-img">
                            </div>
                            <div class="borrower-info">
                                <span class="borrower-name">Allain Legaspi</span>
                                <span class="borrower-id">Borrowed ID : 10</span>
                            </div>
                            <div class="action-icon">
                                <img src="images/btn view.svg" alt="View" class="action-icon-img">
                            </div>
                        </div>
                        <div class="borrower-item">
                            <div class="borrower-icon">
                                <img src="images/Books.jpg" alt="Book" class="borrower-icon-img">
                            </div>
                            <div class="borrower-info">
                                <span class="borrower-name">Allain Legaspi</span>
                                <span class="borrower-id">Borrowed ID : 10</span>
                            </div>
                            <div class="action-icon">
                                <img src="images/btn view.svg" alt="View" class="action-icon-img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom-row">
                    <div class="admins-section">
                        <div class="admins-title">Book King Admins</div>
                        <?php
                        // Prepare and execute query to get all admins
                        $stmt = $pdo->query('SELECT * FROM admin');
                        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Loop through each admin and create a card
                        foreach ($admins as $admin) {
                        ?>
                            <div class="admin-card">
                                <div class="admin-action-icon">
                                    <img src="images/Vector.svg" alt="Admin Action" class="admin-icon-img">
                                </div>
                                <div class="admin-content">
                                    <div class="admin-name"><?= htmlspecialchars($admin['FirstName'] . ' ' . $admin['LastName']) ?></div>
                                    <div class="admin-id">Admin ID : <?= htmlspecialchars($admin['admin_id']) ?></div>
                                    <div class="admin-status">Active</div>
                                    <div class="admin-status-dot"></div>
                                    <div class="admin-divider"></div>
                                    <div class="admin-icon">
                                        <div class="admin-icon-inner"></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="branch-card">
                        <h2 class="branch-title">Branch Network</h2>
                        <div class="branch-list">
                            <?php
                            try {
                                // Only select needed fields
                                $stmt = $pdo->query('SELECT branch_id, branch_name, branch_location FROM branches');
                                $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($branches as $branch) {
                            ?>
                                    <div class="branch-item">
                                        <div class="branch-icon">
                                            <img src="images/buildings-2 1.png" alt="Branch Building" class="branch-icon-img">
                                        </div>
                                        <div class="branch-info">
                                            <div class="branch-name"><?= htmlspecialchars($branch['branch_name']) ?></div>
                                            <div class="branch-id"><?= htmlspecialchars($branch['branch_location']) ?></div>
                                        </div>
                                        <div class="maximize-icon">
                                            <img src="images/maximize-circle 1.jpg" alt="Maximize">
                                        </div>
                                    </div>
                            <?php
                                }

                                if (empty($branches)) {
                                    echo '<p class="no-branches">No branches registered</p>';
                                }
                            } catch (PDOException $e) {
                                error_log("Error fetching branches: " . $e->getMessage());
                                echo '<p class="no-branches">Unable to load branches</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="admins-section">
                <div class="admins-title">Book King Admins</div>
                <?php
                // Prepare and execute query to get all admins
                $stmt = $pdo->query('SELECT * FROM admin');
                $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Loop through each admin and create a card
                foreach ($admins as $admin) {
                ?>
                    <div class="admin-card">
                        <div class="admin-action-icon">
                            <img src="images/Vector.svg" alt="Admin Action" class="admin-icon-img">
                        </div>
                        <div class="admin-content">
                            <div class="admin-name"><?= htmlspecialchars($admin['FirstName'] . ' ' . $admin['LastName']) ?></div>
                            <div class="admin-id">Admin ID : <?= htmlspecialchars($admin['admin_id']) ?></div>
                            <div class="admin-status">Active</div>
                            <div class="admin-status-dot"></div>
                            <div class="admin-divider"></div>
                            <div class="admin-icon">
                                <div class="admin-icon-inner"></div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>