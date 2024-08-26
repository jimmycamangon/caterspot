<?php
// Include database connection
require_once '../../../config/conn.php';

// Process AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve package_id from POST data
    $packageId = isset($_POST['package_id']) ? $_POST['package_id'] : null;

    if (!$packageId) {
        // Return error response if package_id is not provided
        echo json_encode(['error' => 'Package ID is missing']);
        exit;
    }

    // Prepare SQL statement to fetch package details
    $sql = "SELECT * FROM tbl_packages WHERE package_id = :package_id";
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':package_id', $packageId, PDO::PARAM_INT);

    try {
        // Execute the SQL statement
        if ($stmt->execute()) {
            // Fetch package details
            $package = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Return package details as JSON response
            echo json_encode($package);
            exit;
        } else {
            // Return error response if execution fails
            echo json_encode(['error' => 'Failed to fetch package details']);
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
