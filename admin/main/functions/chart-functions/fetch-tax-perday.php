<?php
// Include the database connection file
require_once '../../../../config/conn.php';

try {
    // Get start_date and end_date from request or default to the current month's date range
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of the current month
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');   // Last day of the current month

    // Prepare the SQL query to fetch the tax collected for each day within the date range
    $sql = "SELECT t1.day AS day, SUM(t2.tax) AS total_tax 
            FROM tblref_day t1 
            LEFT JOIN tbladmin_taxcollected_stats t2 ON t1.day = DAY(t2.collectedAt) 
            WHERE t2.collectedAt BETWEEN :start_date AND :end_date AND t2.status = 'Paid'
            GROUP BY t1.day";

    // Execute the query
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
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
