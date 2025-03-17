<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $previousPage = $_SERVER['HTTP_REFERER'] ?? '/index.html';

    $user_id = $_POST['user_id'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if (!$user_id || !$new_password) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
        exit();
    }

    // Update the password in the database
    // $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $hashed_password = $new_password; // Remove the hashing for the sake of the demo
    $stmt = $pdo->prepare("UPDATE db_users SET user_password = :new_password WHERE id = :user_id");
    $stmt->bindParam(':new_password', $hashed_password);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if (strpos($previousPage, 'new_password.html') !== false) {
            // If we came from the new_password.html page, redirect to login
            header("Location: ../login_page.html?message=Use%20your%20new%20password%20to%20log%20in.");
        } else {
            // Otherwise, return to the previous page
            header("Location: $previousPage");
        }
    } else {
        if (strpos($previousPage, 'new_password.html') !== false) {
            header("Location: /index.html");
        } else {
            header("Location: $previousPage");
        }
    }
    exit;
}
