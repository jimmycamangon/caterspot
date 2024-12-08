<?php
// Include the database connection file
require_once '../../config/conn.php';

// Check if the admin_id is set in the session
if (isset($_SESSION['admin_id'])) {
    // Initialize variables to current year if not provided
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-01-01'); // First day of the current year
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-12-31');       // Last day of the current year

    // Prepare the SQL statement
    $sql = "SELECT 
                t2.client_id, 
                t3.cater_name, 
                t4.month AS month, 
                SUM(t2.revenue) AS total_revenue
            FROM tblclient_revenue_stats t2
            LEFT JOIN tblclient_settings t3 ON t2.client_id = t3.client_id
            LEFT JOIN tblref_month t4 ON t4.month_id = MONTH(t2.collectedAt)
            WHERE t2.collectedAt BETWEEN :start_date AND :end_date
            GROUP BY t2.client_id, DATE_FORMAT(t2.collectedAt, '%Y-%m')";

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
