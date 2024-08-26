<?php
// Include database connection
require_once '../../../../config/conn.php';

// Process AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve faq_id from POST data
    $faq_id = isset($_POST['faq_id']) ? $_POST['faq_id'] : null;

    if (!$faq_id) {
        // Return error response if faq_id is not provided
        echo json_encode(['error' => 'FAQ ID is missing']);
        exit;
    }

    // Prepare SQL statement to fetch faq details
    $sql = "SELECT faq_id, cater_answer, cater_question FROM tblclient_faqs WHERE faq_id = :faq_id";
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':faq_id', $faq_id, PDO::PARAM_INT);

    try {
        // Execute the SQL statement
        if ($stmt->execute()) {
            // Fetch faq details
            $faq = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Return faq details as JSON response
            echo json_encode($faq);
            exit;
        } else {
            // Return error response if execution fails
            echo json_encode(['error' => 'Failed to fetch faq details']);
            exit;
        }
    } catch (PDOException $e) {
        // Return error response if an exception occurs
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
} else {
    // Return error response if request method is not POST
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}
?>
