<?php
// Include database connection
require_once '../../../config/conn.php';

// Process delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve client_id from POST data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;

    if (!$client_id) {
        $msg = 'Client ID is missing.';
        echo json_encode(['msg' => $msg]);
        exit;
    }

    try {
        // Start a database transaction
        $DB_con->beginTransaction();
        
        
        // Prepare SQL statement to delete records from tblclient_settings
        $sql_delete_settings = "DELETE FROM tblclient_settings WHERE client_id = :client_id";
        $stmt_delete_settings = $DB_con->prepare($sql_delete_settings);
        $stmt_delete_settings->bindParam(':client_id', $client_id, PDO::PARAM_INT);

        // Execute the SQL statement to delete settings associated with the client
        if (!$stmt_delete_settings->execute()) {
            // Rollback the transaction if deletion of settings fails
            $DB_con->rollBack();
            echo json_encode(['msg' => 'Failed to delete client settings']);
            exit;
        }

        // Prepare SQL statement to select the client image file name
        $sql_select_image = "SELECT client_image FROM tbl_clients WHERE client_id = :client_id";
        $stmt_select_image = $DB_con->prepare($sql_select_image);
        $stmt_select_image->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt_select_image->execute();
        $image_row = $stmt_select_image->fetch(PDO::FETCH_ASSOC);
        $client_image = isset($image_row['client_image']) ? $image_row['client_image'] : null;

        // Delete the client record from the database
        $sql_delete_client = "DELETE FROM tbl_clients WHERE client_id = :client_id";
        $stmt_delete_client = $DB_con->prepare($sql_delete_client);
        $stmt_delete_client->bindParam(':client_id', $client_id, PDO::PARAM_INT);

        // Execute the SQL statement to delete the client
        if ($stmt_delete_client->execute()) {
            // Check if an image file is associated with the client
            if (!empty($client_image)) {
                // Delete the associated image file from the client-uploads folder
                if (unlink("../../../assets/img/client-images/" . $client_image)) {
                    // Commit the transaction if deletion of both client and image file is successful
                    $DB_con->commit();
                    echo json_encode(['success' => 'Client deleted successfully']);
                    exit;
                } else {
                    // Rollback the transaction if deletion of the image file fails
                    $DB_con->rollBack();
                    echo json_encode(['msg' => 'Failed to delete client image file']);
                    exit;
                }
            } else {
                // No image file associated with the client, commit the transaction
                $DB_con->commit();
                echo json_encode(['success' => 'Client deleted successfully']);
                exit;
            }
        } else {
            // Rollback the transaction if deletion of the client fails
            $DB_con->rollBack();
            echo json_encode(['msg' => 'Failed to delete client']);
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
