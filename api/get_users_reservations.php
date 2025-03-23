<?php

require 'db.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_page.html");
    exit();
}

$user_id = (int)$_SESSION['user_id']; // User ID from session

// Fetch reservations along with table capacity
$stmt = $pdo->prepare("SELECT r.*, t.capacity FROM reservations r 
                        JOIN restaurant_tables t ON r.table_id = t.id
                        WHERE r.user_id = :user_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($reservations);
