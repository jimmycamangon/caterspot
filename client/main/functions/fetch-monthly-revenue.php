<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the client_id is set in the session
if (isset($_SESSION['client_id'])) {
    // Initialize variables
    $currentYear = date('Y');
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

    // Prepare the SQL statement
    $sql = "SELECT t2.transactionNo, t3.username, t2.revenue, t2.collectedAt, t1.month AS month, SUM(t2.revenue) AS total_revenue
            FROM tblref_month t1 
            LEFT JOIN tblclient_revenue_stats t2 ON t1.month_id = MONTH(t2.collectedAt) 
            LEFT JOIN tbl_users t3 ON t2.user_id = t3.user_id
            WHERE YEAR(t2.collectedAt) = :year AND t2.client_id = :client_id
            AND DATE(t2.collectedAt) BETWEEN :start_date AND :end_date
            GROUP BY t1.month";

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare($sql);
        $stmt->bindParam(':year', $currentYear, PDO::PARAM_INT);
        $stmt->bindParam(':client_id', $_SESSION['client_id'], PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->execute();
        // Fetch all rows
        $revenues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
