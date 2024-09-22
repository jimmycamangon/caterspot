<?php
// Include database connection
require_once '../config/conn.php';

header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Ensure user_id is provided
if (isset($data['user_id'])) {
    $user_id = $data['user_id'];

    // Update the isNotified field to 1 to mark that the user has been notified
    $stmt = $DB_con->prepare("UPDATE tbl_users SET isNotified = 1 WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update the notification status.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
}
