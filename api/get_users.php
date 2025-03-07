<?php
/* Author: Ganna Karpycheva
 Date: 2025-03-02 17:00
*/
require 'db.php';

header("Content-Type: application/json");

$stmt = $pdo->query("SELECT * FROM db_users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
