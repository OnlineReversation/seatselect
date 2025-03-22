<?php
require 'db.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_page.html");
    exit();
}

$user_id = $_SESSION['user_id']; // User ID from session

try {

    // For now, it doesn't matter which table the review is for; later, table selection can be added
    // $table_id = (int)$_POST['table_id'];
    $table_id = 1;

    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

    $review_text = $_POST['review_text'];
    $review_date = $_POST['review_date'];

    // SQL query to insert data
    $sql = "INSERT INTO reviews (user_id, table_id, rating, review_text, review_date) 
            VALUES (:user_id, :table_id, :rating, :review_text, :review_date)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':table_id', $table_id);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':review_text', $review_text);
    $stmt->bindParam(':review_date', $review_date);

    $stmt->execute();

     echo "<script>alert('Your feedback has been successfully submitted!'); window.location.href = '../review.html';</script>";
    // echo "<script>alert('Your feedback has been successfully submitted!')";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
