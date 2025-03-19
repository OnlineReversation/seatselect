<?php
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['time'])) {
    $reservationId = $data['id'];
    $newTime = $data['time'] . ':00:00'; // Add minutes and seconds to the time

    try {

        $stmt = $pdo->prepare(
            "UPDATE reservations SET reservation_time = :new_time WHERE id = :id"
        );
        $stmt->execute([
            'new_time' => $newTime,
            'id' => $reservationId
        ]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data provided.']);
}
