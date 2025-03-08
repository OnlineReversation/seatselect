<?php
/* Author: Ganna Karpycheva
 Date: 2025-03-02 17:33
*/
include 'session.php'; // Check if the user is logged in

include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from POST
    $user_login = $_POST['user_login'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];


    // Check if the user already exists
    $sql = "SELECT * FROM db_users WHERE user_login = :user_login OR user_email = :user_email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_login', $user_login);
    $stmt->bindParam(':user_email', $user_email);
    $stmt->execute();
    $existing_user = $stmt->fetch();

    if ($existing_user) {
        echo json_encode(['status' => 'error', 'message' => 'User already exists.']);
        exit;
    }

    // Prepare the insert query
    $sql = "INSERT INTO db_users (user_login, user_name, user_email, user_password) VALUES (:user_login, :user_name, :user_email, :user_password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_login', $user_login);
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':user_email', $user_email);
    $stmt->bindParam(':user_password', $user_password);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User added successfully.']);
        // back to the login page
        header("Location: login_page.html?username=" . urlencode($user_name));
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->errorInfo()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
