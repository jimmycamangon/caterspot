<?php
require_once '../../../config/conn.php';

// Ensure the client_id is set in the session
if (!isset($_SESSION['client_id'])) {
    echo json_encode(['error' => 'Client ID not found in session.']);
    exit;
}

$client_id = $_SESSION['client_id'];

// Get start_date and end_date from request, default to current date if not provided
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');  // Default to today's date
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');        // Default to today's date

// SQL query to fetch package data with the selected date range
$sql = "SELECT 
            A.package_name, 
            A.package_image,
            COALESCE(AVG(B.rate), 0) AS average_rate
        FROM 
            tbl_packages AS A
        LEFT JOIN 
            tbl_packagerating AS B 
        ON 
            A.package_id = B.package_id
        WHERE 
            B.customer_id <> '' 
            AND B.client_id = :client_id
            AND B.createdAt BETWEEN :start_date AND :end_date
        GROUP BY 
            A.package_name, A.package_image
        ORDER BY 
            average_rate DESC";

$stmt = $DB_con->prepare($sql);
$stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
$stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
$stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
$stmt->execute();
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Return the result as JSON
echo json_encode($packages); 
?>
