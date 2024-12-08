<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the client_id is set in the session
if (isset($_SESSION['admin_id'])) {
    // Initialize variables to current month if not provided
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

    try {

        // Prepare the SQL statement to fetch completed orders
        $sql = "SELECT A.*, B.*, C.package_name, D.cater_name
                FROM tbl_orders AS A
                LEFT JOIN tbl_userinformationorder AS B ON A.transactionNo = B.transactionNo
                LEFT JOIN tbl_packages AS C ON B.package_id = C.package_id
                LEFT JOIN tblclient_settings AS D ON A.cater = D.cater_name
                WHERE A.status = 'Completed'
                AND DATE(A.order_date) BETWEEN :start_date AND :end_date
                ORDER BY A.is_read = 0 DESC";

        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        // Bind parameters
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
