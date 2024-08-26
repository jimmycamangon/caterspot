<?php
// Include database connection
require_once '../../../config/conn.php';

// Process AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve client_id from POST data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;

    if (!$client_id) {
        // Return error response if client_id is not provided
        echo json_encode(['error' => 'Client ID is missing']);
        exit;
    }

    // Prepare SQL statement to fetch bg image data
    $sql = "SELECT client_image FROM tbl_clients WHERE client_id = :client_id";
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);

    try {
        // Execute the SQL statement
        if ($stmt->execute()) {
            // Fetch bg image data
            $bgImage = $stmt->fetchColumn();
            
            // Return bg image data as JSON response
            echo json_encode(['image_data' => base64_encode($bgImage)]);
            exit;
        } else {
            // Return error response if execution fails
            echo json_encode(['error' => 'Failed to fetch Profile image']);
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
