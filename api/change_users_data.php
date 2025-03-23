<?php

require 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

$user_id = (int)$_SESSION['user_id']; // User ID from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new data (either password or email)
    $new_password = $_POST['new_password'] ?? '';
    $new_email = $_POST['new_email'] ?? '';

    // Check if the user provided either a new password or new email
    if (!$user_id || (!$new_password && !$new_email)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
        exit();
    }

    if ($new_password) {
        // Update the password
        // $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $hashed_password = $new_password; // Remove the hashing for the sake of the demo
        $stmt = $pdo->prepare("UPDATE db_users SET user_password = :new_password WHERE id = :user_id");
        $stmt->bindParam(':new_password', $hashed_password);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to change password.']);
        }
    } elseif ($new_email) {
        // Update the email
        $stmt = $pdo->prepare("UPDATE db_users SET user_email = :new_email WHERE id = :user_id");
        $stmt->bindParam(':new_email', $new_email);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Email changed successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to change email.']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
