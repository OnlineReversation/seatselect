<?php
// Database connection
include 'db.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_page.html");
    exit();
}

$user_id = $_SESSION['user_id']; // User ID from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['select']) && isset($_POST['date']) && isset($_POST['range'])) {
        // Get data from the form
        // Reservation date (e.g., '2025-03-10')
        $reservation_date = date('Y-m-d', strtotime($_POST['date']));
        $reservation_time = sprintf("%02d:00:00", $_POST['range']); // Формирует время из строки 10-24
        // Proceed with finding the first available table based on capacity
        $capacity = $_POST['select']; // For example, 'table_6'
        $number = str_replace('table_', '', $capacity); // Extract the number from the string, removing 'table_'

        // Check if a specific table is chosen
        if (isset($_POST['choosen_table']) && $_POST['choosen_table'] != 0) {
            $table_id = $_POST['choosen_table'];
        } else {
            // If no table is chosen (either 'choosen_table' is not set or it's set to 0)
            try {
                // Prepare SQL query to find the first available table
                $stmt = $pdo->prepare("
                    SELECT rt.id 
                    FROM restaurant_tables rt
                    LEFT JOIN reservations r 
                    ON rt.id = r.table_id AND r.reservation_date = :reservation_date AND r.reservation_time = :reservation_time
                    WHERE rt.capacity = :capacity AND r.id IS NULL
                    LIMIT 1
                ");

                // Bind parameters
                $stmt->bindParam(':capacity', $number, PDO::PARAM_INT);
                $stmt->bindParam(':reservation_date', $reservation_date, PDO::PARAM_STR);
                $stmt->bindParam(':reservation_time', $reservation_time, PDO::PARAM_STR);

                $stmt->execute();

                // Get the id of the first available table
                $table_id = $stmt->fetchColumn();
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
                exit();
            }
        }

        if ($table_id) {
            try {
                // Prepare query to add the reservation to the reservations table
                $insertStmt = $pdo->prepare("
                    INSERT INTO reservations (table_id, user_id, reservation_date, reservation_time)
                    VALUES (:table_id, :user_id, :reservation_date, :reservation_time)
                ");

                // Bind parameters
                $insertStmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
                $insertStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $insertStmt->bindParam(':reservation_date', $reservation_date, PDO::PARAM_STR);
                $insertStmt->bindParam(':reservation_time', $reservation_time, PDO::PARAM_STR);

                $insertStmt->execute();

                echo json_encode([
                    "success" => true,
                    "url" => "../confirmation.html?table_id=" . urlencode($table_id) .
                        "&user_id=" . urlencode($user_id) .
                        "&reservation_date=" . urlencode($reservation_date) .
                        "&reservation_time=" . urlencode($reservation_time) .
                        "&number=" . urlencode($number)
                ]); // Redirect to the confirmation page
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Error inserting reservation: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "No available tables with capacity $number at the specified time."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Please select capacity, date, and time."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}
