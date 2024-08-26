<?php
// Include database connection
require_once '../../../config/conn.php';

// Process delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user_id from POST data
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $id = isset($_POST['feed_id']) ? $_POST['feed_id'] : null;

    if (!$user_id) {
        $msg = 'User ID is missing.';
        echo json_encode(['msg' => $msg]);
        exit;
    }
    if (!$id) {
        $msg = 'Feed ID is missing.';
        echo json_encode(['msg' => $msg]);
        exit;
    }

    try {
        // Start a database transaction
        $DB_con->beginTransaction();
        // Delete the review record from the database
        $sql_delete_customer = "DELETE FROM tbl_feedbacks WHERE customer_id = :user_id AND id = :id";
        $stmt_delete_customer = $DB_con->prepare($sql_delete_customer);
        $stmt_delete_customer->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_delete_customer->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the SQL statement to delete the review
        if ($stmt_delete_customer->execute()) {
            // Check if an image file is associated with the review

            $DB_con->commit();
            echo json_encode(['success' => 'Review deleted successfully']);
            exit;

        } else {
            // Rollback the transaction if deletion of the review fails
            $DB_con->rollBack();
            echo json_encode(['msg' => 'Failed to delete Review']);
            exit;
        }
    } catch (PDOException $e) {
        // Rollback the transaction and return error message if an exception occurs
        $DB_con->rollBack();
        echo json_encode(['msg' => $e->getMessage()]);
        exit;
    }
} else {
    // Return error response if request method is not POST
    echo json_encode(['msg' => 'Invalid request method']);
    exit;
}
?>