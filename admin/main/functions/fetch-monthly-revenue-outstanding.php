<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the admin_id is set in the session
if (isset($_SESSION['admin_id'])) {
    $currentYear = date('Y');
    $currentDate = date('Y-m-d'); // Current date in 'Y-m-d' format
    
    // Set startDate to the first day of the current year
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-01-01');
    
    // Set endDate to the provided date if it exists and is not later than the current date
    // Otherwise, use the current date as the default endDate
    $endDate = isset($_GET['end_date']) && $_GET['end_date'] <= $currentDate ? $_GET['end_date'] : $currentDate;
    

    // Prepare the SQL statement
    $sql = "SELECT t2.id, t2.transactionNo, t2.status, t3.username, t2.tax, t2.collectedAt, t1.month AS month, t2.tax,  t4.revenue
            FROM tblref_month t1 
            LEFT JOIN tbladmin_taxcollected_stats t2 ON t1.month_id = MONTH(t2.collectedAt) 
            LEFT JOIN tbl_clients t3 ON t2.client_id = t3.client_id
            LEFT JOIN tblclient_revenue_stats t4 ON t2.transactionNo = t4.transactionNo AND t2.client_id = t4.client_id
            WHERE YEAR(t2.collectedAt) = :year
            AND DATE(t2.collectedAt) BETWEEN :start_date AND :end_date AND (t2.status = 'Not Paid' OR t2.status = '')";

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        $stmt->bindParam(':year', $currentYear, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->execute();
        // Fetch all rows
        $outstandings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
