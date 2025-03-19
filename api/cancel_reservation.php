<?php
require 'db.php';  // Подключение к базе данных

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$reservationId = $input['id'] ?? null;

if (!$reservationId) {
    echo json_encode(['success' => false, 'error' => 'No reservation ID provided.']);
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$reservationId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Reservation not found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
