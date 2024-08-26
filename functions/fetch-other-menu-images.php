<?php
// Include the database connection file
require_once '../config/conn.php';

// Check if the menu ID is set and not empty
if(isset($_POST['menu_id']) && !empty($_POST['menu_id'])) {
    // Sanitize the input to prevent SQL injection
    $menu_id = $_POST['menu_id'];

    
    try {
        // Prepare a SQL query to fetch images based on the menu ID
        $query_images = "SELECT file_name FROM tblclient_othermenus WHERE menu_id = :menu_id";
        $stmt_images = $DB_con->prepare($query_images);
        $stmt_images->bindParam(':menu_id', $menu_id);
        $stmt_images->execute();
        
        // Fetch the images as an associative array
        $rows_images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);
        
        // Store the fetched images in an array
        $images = array();
        foreach ($rows_images as $row) {
            $images[] = $row['file_name'];
        }
        
        // Return the images as JSON data
        echo json_encode(array('images' => $images)); // This is correct JSON output
        
    } catch (PDOException $e) {
        // Handle any database errors
        echo json_encode(array('error' => 'Database error: ' . $e->getMessage())); // This is also correct JSON output
    }
} else {
    // Return an error message if the menu ID is not provided
    echo json_encode(array('error' => 'Menu ID is required.')); // This is correct JSON output
}
?>
