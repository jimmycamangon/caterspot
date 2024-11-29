<?php
// Include the database connection file
require_once '../../../../config/conn.php';

try {
    // Fetch and sanitize input parameters for date range filtering
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

    // Base SQL query to get top-rated caterers by average rating
    $sql = "SELECT c.username, AVG(f.rate) AS average_rating
            FROM tbl_feedbacks f
            INNER JOIN tbl_clients c ON f.client_id = c.client_id ";

    // Add date range filtering to the query if start_date and end_date are provided
    if ($start_date && $end_date) {
        $sql .= "WHERE f.createdAt BETWEEN :start_date AND :end_date AND c.client_id = :client_id ";
    }

    $sql .= "GROUP BY c.client_id
             ORDER BY average_rating DESC
             LIMIT 5"; // Top 5 caterers by average rating

    // Prepare the SQL statement
    $stmt = $DB_con->prepare($sql);

    // Bind parameters if date range filtering is applied
    if ($start_date && $end_date) {
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':client_id', $_SESSION['client_id'], PDO::PARAM_INT);
    }

    // Execute the query
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
