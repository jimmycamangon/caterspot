<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the client_id is set in the session
if (isset($_SESSION['client_id'])) {
    $client_id = $_SESSION['client_id'];
    
    // Get date range from the request
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of the current month
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');   // Last day of the current month
    

    // Prepare the SQL statement
    $sql = "SELECT 
                B.cater_name,
                C.firstname,
                C.lastname,
                A.comment,
                A.rate,
                A.createdAt,
                A.customer_id
            FROM tbl_feedbacks AS A
            LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id
            LEFT JOIN tbl_users AS C ON A.customer_id = C.user_id
            WHERE A.client_id = :client_id";

    // Add date range filtering if dates are provided
    if ($startDate && $endDate) {
        $sql .= " AND DATE(A.createdAt) BETWEEN :start_date AND :end_date";
    }

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);

        // Bind parameters for date range if provided
        if ($startDate && $endDate) {
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);
        }

        // Execute the query
        $stmt->execute();

        // Fetch all rows
        $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}


?>
