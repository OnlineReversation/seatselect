<?php
/* Author: Ganna Karpycheva
 Date: 2025-03-02 17:00
*/
require 'db.php';

if (empty($_POST['user_email']) || empty($_POST['security_question']) || empty($_POST['security_answer'])) {
    echo json_encode(['error' => 'Not all data was provided.']);
    exit;
}

header("Content-Type: application/json");
$query = "
    SELECT u.id AS user_id, uq.answer
    FROM user_security_questions uq
    JOIN db_users u ON uq.user_id = u.id
    WHERE u.user_email = :user_email
    AND uq.question = :question
";
$stmt = $pdo->prepare($query);
$stmt->execute([
    ':user_email' => $_POST['user_email'],
    ':question' => $_POST['security_question']
]);

$user_questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Checking the user's answer
$is_correct = false;
$user_id = null;

foreach ($user_questions as $question) {
    if ($_POST['security_answer'] === $question['answer']) {
        $is_correct = true;
        $user_id = $question['user_id']; // Retrieve user_id from the query
        break; // Answer found, exit the loop
    }
}

// Redirecting based on the verification result
if ($is_correct) {
    header('Location: /new_password.html?user_id=' . $user_id);
    exit;
} else {
    $user_email = urlencode($_POST['user_email']);
    $question = urlencode($_POST['security_question']);
    $error_message = urlencode('Incorrect answer. Please try again.');
    header("Location: /forgotten_password.html?error=$error_message&user_email=$user_email&question=$question");
    exit;
}
