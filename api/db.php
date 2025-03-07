<?php
/* Author: Ganna Karpycheva
 Date: 2025-03-01 10:00
 manual: https://metanit.com/php/mysql/2.1.php
*/
$host = 'databasess.cvwwyq4ws4kg.eu-west-2.rds.amazonaws.com';
$dbname = 'db_seat_select';
$username = 'admin';
$password = 'SSelect123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}
?>

