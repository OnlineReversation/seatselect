<?php
$data = $_POST;
header("Content-Type: application/x-www-form-urlencoded");

if (empty($data)) {
    echo "Data did not receive";
    exit;
}

require_once 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST)) {
        try {
            // Prepare the query to update data in the table
            $stmt = $pdo->prepare("UPDATE restaurant_tables SET capacity = :table_value WHERE id = :table_id");

            // Iterate over all the passed data
            foreach ($data as $id => $value) {
            // Convert the string to an integer
            $id = str_replace("table_", "", $id); // replace "table_" with an empty string
            $id = intval($id); // convert to integer

            $value = intval($value); // Convert the string to an integer
            // Execute the query for each value
            $stmt->execute([
                ':table_id' => $id,
                ':table_value' => $value
            ]);
            }

            // Return a successful response
            echo "Data saved successfully!";
        } catch (PDOException $e) {
            // In case of an error, output the message
            echo "Error writing to the database: " . $e->getMessage();
        }
        } else {
        echo "No data received.";
    }
} else {
    echo "Invalid request method.";
}
