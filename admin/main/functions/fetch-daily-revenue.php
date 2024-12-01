<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the admin_id is set in the session
if (isset($_SESSION['admin_id'])) {
    // Initialize variables to current month if not provided
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

    

    // Prepare the SQL statement
    $sql = "SELECT t2.transactionNo, t3.username, t2.tax, t2.collectedAt, t1.day AS day, SUM(t2.tax) AS total_tax
            FROM tblref_day t1
            LEFT JOIN tbladmin_taxcollected_stats t2 ON t1.day = DAY(t2.collectedAt)
            LEFT JOIN tbl_clients t3 ON t2.client_id = t3.client_id
            WHERE DATE(t2.collectedAt) BETWEEN :start_date AND :end_date AND t2.status = 'Paid'
            GROUP BY t1.day
            ORDER BY t2.collectedAt ASC";

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->execute();
        // Fetch all rows
        $taxs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
