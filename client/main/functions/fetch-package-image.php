<?php
// Include database connection
require_once '../../../config/conn.php';

// Process AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve package_id from POST data
    $package_id = isset($_POST['package_id']) ? $_POST['package_id'] : null;

    if (!$package_id) {
        // Return error response if package_id is not provided
        echo json_encode(['error' => 'Package ID is missing']);
        exit;
    }

    // Prepare SQL statement to fetch package image data
    $sql = "SELECT package_image FROM tbl_packages WHERE package_id = :package_id";
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);

    try {
        // Execute the SQL statement
        if ($stmt->execute()) {
            // Fetch package image data
            $packageImage = $stmt->fetchColumn();
            
            // Return package image data as JSON response
            echo json_encode(['image_data' => base64_encode($packageImage)]);
            exit;
        } else {
            // Return error response if execution fails
            echo json_encode(['error' => 'Failed to fetch Package image']);
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
