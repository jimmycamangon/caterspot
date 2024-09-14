<?php
// Include database connection
require_once '../../../config/conn.php';


header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['client_id'])) {
    $client_id = $data['client_id'];

    // Update the isNotified field to 1
    $stmt = $DB_con->prepare("UPDATE tbl_clients SET isNotified = 1 WHERE client_id = :client_id");
    $stmt->bindParam(':client_id', $client_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Client ID not provided']);
}
?>