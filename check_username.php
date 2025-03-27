<?php
// Include the database connection
$pdo = require 'database/db_connection.php';

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Check if the username exists in the database
    $stmt = $pdo->prepare('SELECT username FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['available' => false, 'message' => 'Username is already in use.']);
    } else {
        echo json_encode(['available' => true, 'message' => 'Username is available.']);
    }
}
?>