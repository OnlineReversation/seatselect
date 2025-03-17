<?php
require 'db.php';

try {
/* Author: Ganna Karpycheva
 Date: 2025-03-16 22:55
 пока не работает, жду файла с запросом от Амира
*/ 
    // Retrieving data from the form
    $user_id = (int)$_POST['user_id'];
   
    // For now, it doesn't matter which table the review is for; later, table selection can be added
    // $table_id = (int)$_POST['table_id'];
    $table_id = 1;
    $rating = (int)$_POST['rating'];
    $review_text = $_POST['review_text'];
    $review_date = $_POST['review_date'];

    // SQL query to insert data
    $sql = "INSERT INTO reviews (user_id, table_id, rating, review_text, review_date) 
            VALUES (:user_id, :table_id, :rating, :review_text, :review_date)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':table_id', $table_id);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':review_text', $review_text);
    $stmt->bindParam(':review_date', $review_date);

    $stmt->execute();

    echo "<script>alert('Your feedback has been successfully submitted!'); window.location.href = 'index.html';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Closing the connection
$conn = null;
