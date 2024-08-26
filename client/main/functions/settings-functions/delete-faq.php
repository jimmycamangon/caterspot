<?php
// Include database connection
require_once '../../../../config/conn.php';

// Process delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve faq_id from POST data
    $faq_id = isset($_POST['faq_id']) ? $_POST['faq_id'] : null;

    if (!$faq_id) {
        $msg = 'FAQ ID is missing.';
        echo json_encode(['msg' => $msg]);
        exit;
    }

    try {
        // Start a database transaction
        $DB_con->beginTransaction();

        // Delete the faq record from the database
        $sql_delete_faq = "DELETE FROM tblclient_faqs WHERE faq_id = :faq_id";
        $stmt_delete_faq = $DB_con->prepare($sql_delete_faq);
        $stmt_delete_faq->bindParam(':faq_id', $faq_id, PDO::PARAM_INT);

        // Execute the SQL statement to delete the faq
        if ($stmt_delete_faq->execute()) {

            $DB_con->commit();
            echo json_encode(['success' => 'FAQ deleted successfully']);
            exit;
        } else {
            // Rollback the transaction if deletion of the faq fails
            $DB_con->rollBack();
            echo json_encode(['msg' => 'Failed to delete faq']);
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