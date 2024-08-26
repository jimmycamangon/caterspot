<?php
// Include the database connection file
require_once '../config/conn.php';

// Check if the client_id is set in the query parameters
if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    
    // Prepare the SQL statement
    $stmt = $DB_con->prepare("SELECT A.* FROM tbl_feedbacks AS A LEFT JOIN tbl_clients AS B ON A.client_id = B.client_id WHERE B.client_id = :client_id");
    $stmt->bindValue(":client_id", $client_id, PDO::PARAM_STR);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch all rows from the result as an associative array
    $feedbackData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the database connection
    $DB_con = null;

    // Return feedback data as JSON
    echo json_encode($feedbackData);
} else {
    echo "No Client ID Found.";
}
?>
