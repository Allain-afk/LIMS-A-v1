<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Include database connection
$pdo = require 'database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['title']) || empty($_POST['type']) || empty($_POST['author']) || empty($_POST['language'])) {
        $_SESSION['error'] = "All fields are required";
        header('Location: book-management.php');
        exit();
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO books (title, type, author, language, availability) 
                             VALUES (:title, :type, :author, :language, 'Available')");

        // Execute with the form data using named parameters
        $stmt->execute([
            ':title' => trim($_POST['title']),
            ':type' => trim($_POST['type']),
            ':author' => trim($_POST['author']),
            ':language' => trim($_POST['language'])
        ]);

        // Set success message
        $_SESSION['success'] = "Book added successfully!";
    } catch (PDOException $e) {
        error_log("Error adding book: " . $e->getMessage());
        $_SESSION['error'] = "Error adding book. Please try again.";
    }

    // Redirect back to book management page
    header('Location: book-management.php');
    exit();
}
