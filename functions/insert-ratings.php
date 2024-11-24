<?php

require_once '../config/conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo 'User not logged in.';
    exit;
}

// Check if rating  are set
if (isset($_POST['rating']) && isset($_POST['client_id']) && isset($_POST['package_id'])) {
    // Get user ID from session
    $customer_id = $_SESSION['user_id'];
    
    // Get rating and comment from POST data
    $rating = $_POST['rating'];
    $client_id = $_POST['client_id'];
    $package_id = $_POST['package_id'];

    // Check if the user has already submitted two reviews today
    $stmt_count = $DB_con->prepare("SELECT COUNT(*) AS review_count FROM tbl_packagerating WHERE customer_id = :customer_id AND DATE(createdAt) = CURDATE()");
    $stmt_count->bindParam(':customer_id', $customer_id);
    $stmt_count->execute();
    $result_count = $stmt_count->fetch(PDO::FETCH_ASSOC);

    if ($result_count['review_count'] >= 1) {
        // User has already submitted two reviews today
        echo 'You have already submitted the maximum number of reviews for today.';
        exit;
    }
    
    // Prepare and execute SQL statement to insert rated into the database
    $stmt = $DB_con->prepare("INSERT INTO tbl_packagerating (customer_id, client_id,rate, package_id) VALUES (:customer_id, :client_id, :rating, :package_id)");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':client_id', $client_id);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':package_id', $package_id);
    
    if ($stmt->execute()) {
        // rated inserted successfully
        echo 'Your rating has been successfully submitted!';
    } else {
        // Failed to insert rated
        echo 'Error submitting rating. Please try again.';
    }
} else {
    // Rating not set
    echo 'Rating are required.';
}
?>
