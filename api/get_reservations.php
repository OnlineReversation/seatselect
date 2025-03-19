<?php
require 'db.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$date = $input['date'] ?? null;

if (!$date) {
    echo json_encode([]);
    exit();
}

try {
    $stmt = $pdo->prepare("
        SELECT r.id, r.reservation_date, r.reservation_time, r.table_id, u.user_login as user_name
        FROM reservations r
        INNER JOIN db_users u ON r.user_id = u.id
        WHERE r.reservation_date = STR_TO_DATE(?, '%d-%m-%Y')
    ");
    $stmt->execute([$date]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($reservations);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
