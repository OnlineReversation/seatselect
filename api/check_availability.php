<?php

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $date = $_POST['date'] ?? null;
    $date = date('Y-m-d', strtotime($_POST['date']));
    // $time = $_POST['time'] ?? null;
    $time = sprintf("%02d:00:00", $_POST['time']); // Формирует время из строки 10-24

    if ($date && $time) {
        $stmt = $pdo->prepare("SELECT table_id FROM reservations WHERE reservation_date = :date AND reservation_time = :time");
        $stmt->execute(['date' => $date, 'time' => $time]);
        $reservedTables = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode([
            'success' => true,
            'reservedTables' => $reservedTables
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid input'
        ]);
    }
}
