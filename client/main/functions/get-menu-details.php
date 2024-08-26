<?php
// Include database connection
require_once '../../../config/conn.php';

// Process AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve menu_id from POST data
    $menuId = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;

    if (!$menuId) {
        // Return error response if menu_id is not provided
        echo json_encode(['error' => 'Menu ID is missing']);
        exit;
    }

    // Prepare SQL statement to fetch menu details
    $sql = "SELECT * FROM tbl_menus WHERE menu_id = :menu_id";
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':menu_id', $menuId, PDO::PARAM_INT);

    try {
        // Execute the SQL statement
        if ($stmt->execute()) {
            // Fetch menu details
            $menu = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Return menu details as JSON response
            echo json_encode($menu);
            exit;
        } else {
            // Return error response if execution fails
            echo json_encode(['error' => 'Failed to fetch menu details']);
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
