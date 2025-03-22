<?php
require_once 'db.php';

try {
    $stmt = $pdo->prepare("
        SELECT 
            r.review_text AS comment,
            r.rating,
            r.review_date,
            u.user_login AS username
        FROM reviews r
        JOIN db_users u ON r.user_id = u.id
        ORDER BY r.review_date DESC
        LIMIT 3
    ");

    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($reviews);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
