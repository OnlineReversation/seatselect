<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $previousPage = $_SERVER['HTTP_REFERER'] ?? '/index.html';

    $user_id = $_POST['user_id'] ?? '';
    $new_email = $_POST['new_email'] ?? '';

    if (!$user_id || !$new_email) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
        exit();
    }


    $stmt = $pdo->prepare("UPDATE db_users SET user_email = :new_email WHERE id = :user_id");
    $stmt->bindParam(':new_email', $new_email, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if (strpos($previousPage, 'new_password.html') !== false) {
            // Возвращаем сообщение об успешном изменении пароля
            echo json_encode(["status" => "success", "message" => "Use your new password to log in."]);
        } else {
            // Возвращаем стандартный успешный ответ
            echo json_encode(["status" => "success", "message" => "Email successfully changed."]);
        }
    } else {
        if (strpos($previousPage, 'new_password.html') !== false) {
            // Возвращаем ошибку с сообщением
            echo json_encode(["status" => "error", "message" => "Failed to update password."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update email."]);
        }
    }
    exit;
}
