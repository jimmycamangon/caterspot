<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the admin_id is set in the session
if (isset($_SESSION['admin_id'])) {
    // Prepare the SQL statement
    $sql = "SELECT * FROM tbl_applications";

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        // Execute the query
        $stmt->execute();
        // Fetch all rows
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
