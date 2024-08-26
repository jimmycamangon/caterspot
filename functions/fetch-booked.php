<?php
// Include the database connection file
require_once 'config/conn.php';

// Check if the client_id is set in the session
if (isset($_GET['id'])) {
    try {

        $id = $_GET['id'];
        // Prepare the SQL statement to fetch orders
        $sql = "SELECT A.* FROM tbl_orders AS A LEFT JOIN tblclient_settings AS B ON A.cater = B.cater_name WHERE B.client_id = :id AND A.status = 'Pending' OR A.status = 'Booked';";

        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        // Execute the query
        $stmt->execute();
        // Fetch all rows
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
