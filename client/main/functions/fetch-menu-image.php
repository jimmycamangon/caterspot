<?php
// Include database connection
require_once '../../../config/conn.php';

// Process AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve menu_id from POST data
    $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;

    if (!$menu_id) {
        // Return error response if menu_id is not provided
        echo json_encode(['error' => 'Menu ID is missing']);
        exit;
    }

    // Prepare SQL statement to fetch menu image data
    $sql = "SELECT menu_image FROM tbl_menus WHERE menu_id = :menu_id";
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);

    try {
        // Execute the SQL statement
        if ($stmt->execute()) {
            // Fetch menu image data
            $menuImage = $stmt->fetchColumn();
            
            // Return menu image data as JSON response
            echo json_encode(['image_data' => base64_encode($menuImage)]);
            exit;
        } else {
            // Return error response if execution fails
            echo json_encode(['error' => 'Failed to fetch menu image']);
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
