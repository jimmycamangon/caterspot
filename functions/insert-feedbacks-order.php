<?php

require_once '../config/conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo 'User not logged in.';
    exit;
}

// Check if rating and comment are set
if (isset($_POST['rating']) && isset($_POST['client_id']) && isset($_POST['comment']) && isset($_POST['transacNo'])) {
    // Get user ID from session
    $customer_id = $_SESSION['user_id'];

    // Get rating and comment from POST data
    $transacNo = $_POST['transacNo'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $client_id = $_POST['client_id'];

    // Check if the user has already submitted two reviews today
    $stmt_count = $DB_con->prepare("SELECT COUNT(*) AS review_count FROM tbl_feedbacks WHERE customer_id = :customer_id AND DATE(createdAt) = CURDATE()");
    $stmt_count->bindParam(':customer_id', $customer_id);
    $stmt_count->execute();
    $result_count = $stmt_count->fetch(PDO::FETCH_ASSOC);

    if ($result_count['review_count'] >= 2) {
        // User has already submitted two reviews today
        echo 'You have already submitted the maximum number of reviews for today.';
        exit;
    }

    // Update the database
    $updateRate = $DB_con->prepare("UPDATE tbl_orders SET isRated = 1, isRateDisplayed = 1 WHERE transactionNo = :transactionNo");
    $updateRate->bindParam(':transactionNo', $transacNo);
    $updateRate->execute();

    // Prepare and execute SQL statement to insert feedback into the database
    $stmt = $DB_con->prepare("INSERT INTO tbl_feedbacks (customer_id, client_id, comment, rate) VALUES (:customer_id, :client_id, :comment, :rating)");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':client_id', $client_id);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':rating', $rating);


    if ($stmt->execute()) {
        // Feedback inserted successfully
        echo 'Feedback submitted successfully!';
    } else {
        // Failed to insert feedback
        echo 'Error submitting feedback. Please try again.';
    }
} else {
    // Rating and/or comment not set
    echo 'Rating and comment are required.';
}
?>