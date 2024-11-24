<?php
// Include the database connection file
require_once 'config/conn.php';

header('Content-Type: application/json'); // Set the content type to JSON

// If a search query is provided
if (isset($_GET['query'])) {
    $query = "%" . trim($_GET['query']) . "%"; // Prepare the search term with wildcards

    try {
        // Fetch data from the database including average rating
        $stmt = $DB_con->prepare("SELECT A.cater_name, A.cater_description, A.client_id, 
            COALESCE(AVG(B.rate), 0) AS average_rating
            FROM tblclient_settings AS A
            LEFT JOIN tbl_feedbacks AS B ON A.client_id = B.client_id
            WHERE A.cater_name LIKE ?
            GROUP BY A.cater_name, A.cater_description, A.client_id
            ORDER BY average_rating DESC");

        $stmt->execute([$query]);
        $cateringServices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($cateringServices); // Return results as JSON
    } catch (PDOException $e) {
        // Handle any potential errors
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // If no query is provided, fetch all catering services
    try {
        // Fetch data from the database including average rating
        $stmt = $DB_con->prepare("SELECT A.cater_name, A.cater_description, A.client_id, 
            AVG(B.rate) AS average_rating
            FROM tblclient_settings AS A
            LEFT JOIN tbl_feedbacks AS B ON A.client_id = B.client_id
            GROUP BY A.cater_name, A.cater_description, A.client_id
            ORDER BY average_rating DESC");

        $stmt->execute();
        $cateringServices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($cateringServices); // Return all results as JSON
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

?>