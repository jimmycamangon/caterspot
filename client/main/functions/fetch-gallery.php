<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the client_id is set in the session
if (isset($_SESSION['client_id'])) {
    // Prepare the SQL statement
    $sql = "SELECT A.* FROM tblclient_gallery AS A 
    LEFT JOIN tbl_clients AS B ON A.client_id = B.client_id
    WHERE A.client_id = :client_id";

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':client_id', $_SESSION['client_id'], PDO::PARAM_INT);
        // Execute the query
        $stmt->execute();
        // Fetch all rows
        $galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
