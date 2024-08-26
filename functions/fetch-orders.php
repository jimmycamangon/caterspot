<?php
// Include the database connection file
require_once 'config/conn.php';

// Check if the user_id is set in the session
if (isset($_SESSION['user_id'])) {
    // Prepare the SQL statement
    $sql = "SELECT A.*, B.client_id, B.package_name FROM tbl_orders AS A 
    LEFT JOIN tbl_packages AS B ON A.package_id = B.package_id
    WHERE user_id = :user_id";

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        // Execute the query
        $stmt->execute();
        // Fetch all rows
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
