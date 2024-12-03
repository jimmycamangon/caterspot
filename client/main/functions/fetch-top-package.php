<?php

require_once '../../config/conn.php';
// Initialize results variable
$topPackages = [];

try {
    // Fetch and sanitize input parameters for date range filtering
    $start_date = $startDate;
    $end_date = $endDate;

    // Base SQL query to get top-rated caterers by average rating
    $sql = "SELECT 
            C.username,
            B.package_id,
            D.firstname,
            D.lastname,
            A.package_name, 
            A.package_image,
           B.rate AS average_rate
        FROM 
            tbl_packages AS A
        LEFT JOIN 
            tbl_packagerating AS B 
        ON 
            A.package_id = B.package_id 
        LEFT JOIN tbl_clients AS C ON A.client_id = C.client_id
        LEFT JOIN tbl_users AS D ON B.customer_id = D.user_id
            
            ";

    // Add date range filtering to the query if start_date and end_date are provided
    if ($start_date && $end_date) {
        $sql .= "WHERE 
            B.customer_id <> '' 
            AND B.client_id = :client_id
            AND B.createdAt BETWEEN :start_date AND :end_date ";
    }

    $sql .= "GROUP BY 
            A.package_name, A.package_image
        ORDER BY 
            average_rate DESC"; // Top 5 caterers by average rating

    // Prepare the SQL statement
    $stmt = $DB_con->prepare($sql);

    // Bind parameters if date range filtering is applied
    if ($start_date && $end_date) {
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
    }

    // Execute the query
    $stmt->execute();

    // Fetch the results into an associative array
    $topPackages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle any errors that occur during the process
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}