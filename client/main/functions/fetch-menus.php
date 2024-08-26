<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the client_id is set in the session
if (isset($_SESSION['client_id'])) {
    // Prepare the SQL statement
    $sql = "SELECT A.*, B.package_name FROM tbl_menus AS A 
    LEFT JOIN tbl_packages AS B ON A.package_id = B.package_id
    WHERE A.client_id = :client_id";

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':client_id', $_SESSION['client_id'], PDO::PARAM_INT);
        // Execute the query
        $stmt->execute();
        // Fetch all rows
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
