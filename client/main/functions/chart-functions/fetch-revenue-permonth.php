<?php
// Include the database connection file
require_once '../../../../config/conn.php';

try {
    // Get start_date and end_date from request
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of the current month
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');   // Last day of the current month

    // Prepare the SQL query to fetch the revenue collected for each month within the date range
    $sql = "SELECT t1.month AS month, SUM(t2.revenue) AS total_revenue 
            FROM tblref_month t1 
            LEFT JOIN tblclient_revenue_stats t2 ON t1.month_id = MONTH(t2.collectedAt) 
            WHERE t2.collectedAt BETWEEN :start_date AND :end_date
            AND t2.client_id = :client_id
            GROUP BY t1.month
            ORDER BY MONTH(t2.collectedAt)";

    // Execute the query
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
    $stmt->bindParam(':client_id', $_SESSION['client_id'], PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the results into an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send JSON response
    echo json_encode($results);

} catch (PDOException $e) {
    // Handle any errors that occur during the process
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
