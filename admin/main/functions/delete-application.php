<?php
// Include database connection
require_once '../../../config/conn.php';

// Process delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve client_id from POST data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;

    if (!$client_id) {
        $msg = 'user ID is missing.';
        echo json_encode(['msg' => $msg]);
        exit;
    }

    try {
        // Start a database transaction
        $DB_con->beginTransaction();


        // Delete the user record from the database
        $sql_delete_user = "DELETE FROM tbl_applications WHERE client_id = :client_id";
        $stmt_delete_user = $DB_con->prepare($sql_delete_user);
        $stmt_delete_user->bindParam(':client_id', $client_id, PDO::PARAM_INT);

        // Execute the SQL statement to delete the user
        if ($stmt_delete_user->execute()) {


            $DB_con->commit();
            echo json_encode(['success' => 'Application deleted successfully']);
            exit;


        } else {
            // Rollback the transaction if deletion of the user fails
            $DB_con->rollBack();
            echo json_encode(['msg' => 'Failed to delete Application']);
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