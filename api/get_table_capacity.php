<?php
/* Author: Ganna Karpycheva
 Date: 2025-03-03 19:22
*/

require_once 'db.php';  // Include the file with connection settings
header("Content-Type: application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin: *"); // Allows requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allows methods
header("Access-Control-Allow-Headers: Content-Type"); // Allows headers

// Check that the connection to the database is successfully established
if (!$pdo) {
    die('Connection to the database is not established.');
} else {
    echo "Connection to the database is established.<br>";
}
// Query to get data about tables
$query = $pdo->query('SELECT id, capacity FROM restaurant_tables WHERE id <= 20');

if (!$query) {
    die('Error executing query. Check the query.');
} else {
    echo "Query executed successfully.<br>";
}

// Get all rows from the query result
$tables = $query->fetchAll(PDO::FETCH_ASSOC);

// Check if there is no data
if (!$tables) {
    die('No data to process.');
}

$response = [];
foreach ($tables as $table) {
    $response[] = 'table_' . $table['id'] . '=' . $table['capacity'];
}

// Output the result
echo implode('&', $response);
