<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the client_id is set in the session
if (isset($_SESSION['client_id'])) {
    // Initialize variables to current month if not provided
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

    try {
        // Fetch the username from tbl_clients using the client_id
        $sql_username = "SELECT B.cater_name 
                         FROM tbl_clients AS A 
                         LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id 
                         WHERE A.client_id = :client_id";
        $stmt_username = $DB_con->prepare($sql_username);
        $stmt_username->bindParam(':client_id', $_SESSION['client_id'], PDO::PARAM_INT);
        $stmt_username->execute();
        $username_row = $stmt_username->fetch(PDO::FETCH_ASSOC);

        $username = isset($username_row['cater_name']) ? $username_row['cater_name'] : null;
        
        // Prepare the SQL statement to fetch completed orders
        $sql = "SELECT A.*, B.*, C.package_name 
                FROM tbl_orders AS A
                LEFT JOIN tbl_userinformationorder AS B ON A.transactionNo = B.transactionNo
                LEFT JOIN tbl_packages AS C ON B.package_id = C.package_id
                LEFT JOIN tblclient_settings AS D ON A.cater = D.cater_name
                WHERE D.cater_name = :username 
                AND A.status = 'Completed'
                AND DATE(A.order_date) BETWEEN :start_date AND :end_date
                ORDER BY A.is_read = 0 DESC";

        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        // Execute the query
        $stmt->execute();
        // Fetch all rows
        $completed_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
