<?php
session_start();

include 'db.php'; // Database connection

// Проверяем, что форма отправлена
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_login = $_POST['user_login'];
    $user_password = $_POST['user_password'];

    // Check if the user already exists
    $sql = "SELECT * FROM db_users WHERE user_login = :user_login AND user_password = :user_password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_login', $user_login);
    $stmt->bindParam(':user_password', $user_password);
    $stmt->execute();
    $existing_user = $stmt->fetch();

    if ($existing_user) {

        // Устанавливаем данные в сессии
        $_SESSION['user_id'] = $existing_user['id'];
        $_SESSION['user_login'] = $existing_user['user_login'];
        if ($existing_user['is_admin']) {
            // Если админ, добавляем роль в сессию
            $_SESSION['user_role'] = 'admin';
            echo json_encode(['status' => 'success', 'user_login' => $existing_user['user_login'], 'role' => 'admin']);
        } else {
            // Если обычный пользователь, добавляем роль в сессию
            $_SESSION['user_role'] = 'user';
            echo json_encode(['status' => 'success', 'user_login' => $existing_user['user_login'], 'role' => 'user']);
        }
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Incorrect login or password.']);
        exit();
    }
}
