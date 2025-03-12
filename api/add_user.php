<?php
/* Author: Ganna Karpycheva
 Date: 2025-03-02 17:33

include 'session.php'; // Check if the user is logged in
*/
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from POST
    $user_login = $_POST['user_login'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];

    $role = $_POST['role']; // "user" or "admin"


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
    $sql = "INSERT INTO db_users (user_login, user_email, user_password, is_admin) VALUES (:user_login, :user_email, :user_password, :is_admin)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_login', $user_login);
    $stmt->bindParam(':user_email', $user_email);
    $stmt->bindParam(':user_password', $user_password);
    $isAdmin = 0; // По умолчанию - не админ
    if ($role === 'admin') {
        $isAdmin = 1; // Если роль - админ, присваиваем 1
    }
    $stmt->bindParam(':is_admin', $isAdmin, PDO::PARAM_BOOL);

    // Execute the query
    if ($stmt->execute()) {
        // Get the ID of the last inserted user
        $user_id = $pdo->lastInsertId();

        // Add the security question
        $sql_security = "INSERT INTO user_security_questions (user_id, question, answer) VALUES (:user_id, :security_question, :security_answer)";
        $stmt_security = $pdo->prepare($sql_security);
        $stmt_security->bindParam(':user_id', $user_id);
        $stmt_security->bindParam(':security_question', $security_question);
        $stmt_security->bindParam(':security_answer', $security_answer);
        $stmt_security->execute();


        // echo json_encode(['status' => 'success', 'message' => 'User added successfully.']);
        // back to the login page
        header("Location: ../login_page.html?user_login=" . urlencode($user_login));
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->errorInfo()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
