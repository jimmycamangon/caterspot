<?php
// Include database connection
require_once '../../../config/conn.php';
// Process AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve  from POST data
    $statusId = isset($_POST['client_id']) ? $_POST['client_id'] : null;

    if (!$statusId) {
        // Return error response if  is not provided
        echo json_encode(['error' => 'Client ID is missing']);
        exit;
    }

    // Prepare SQL statement to fetch status details
    $sql = "SELECT * FROM tbl_clients WHERE client_id = :statusId";
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);

    try {
        // Execute the SQL statement
        if ($stmt->execute()) {
            // Fetch status details
            $status = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Return status details as JSON response
            echo json_encode($status);
            exit;
        } else {
            // Return error response if execution fails
            echo json_encode(['error' => 'Failed to fetch Status details']);
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
