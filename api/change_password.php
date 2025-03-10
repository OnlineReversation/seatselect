<?php
session_start();
require 'db.php'; // Твой файл подключения к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if (!$user_id || !$new_password) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
        exit();
    }

    // Обновляем пароль в базе данных
    $stmt = $pdo->prepare("UPDATE db_users SET user_password = :new_password WHERE id = :user_id");
    $stmt->bindParam(':new_password', $new_password);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update the password.']);
    }
}
