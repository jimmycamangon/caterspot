<?php
// Include database connection
require_once '../../../../config/conn.php';

// Process delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve uniq_id from POST data
    $uniq_id = isset($_POST['uniq_id']) ? $_POST['uniq_id'] : null;

    if (!$uniq_id) {
        $msg = 'Uniq ID is missing.';
        echo json_encode(['msg' => $msg]);
        exit;
    }

    try {
        // Start a database transaction
        $DB_con->beginTransaction();

        // Prepare SQL statement to select the menu image file name
        $sql_select_image = "SELECT file_name FROM tblclient_gallery WHERE uniq_id = :uniq_id";
        $stmt_select_image = $DB_con->prepare($sql_select_image);
        $stmt_select_image->bindParam(':uniq_id', $uniq_id, PDO::PARAM_INT);
        $stmt_select_image->execute();
        $image_row = $stmt_select_image->fetch(PDO::FETCH_ASSOC);
        $file_name = isset($image_row['file_name']) ? $image_row['file_name'] : null;

        // Delete the menu record from the database
        $sql_delete_menu = "DELETE FROM tblclient_gallery WHERE uniq_id = :uniq_id";
        $stmt_delete_menu = $DB_con->prepare($sql_delete_menu);
        $stmt_delete_menu->bindParam(':uniq_id', $uniq_id, PDO::PARAM_INT);

        // Execute the SQL statement to delete the menu
        if ($stmt_delete_menu->execute()) {
            // Check if an image file is associated with the menu
            if (!empty($file_name)) {
                // Delete the associated image file from the menu-uploads folder
                if (unlink("../../../../assets/img/client-gallery/" . $file_name)) {
                    // Commit the transaction if deletion of both menu and image file is successful
                    $DB_con->commit();
                    echo json_encode(['success' => 'Image deleted successfully']);
                    exit;
                } else {
                    // Rollback the transaction if deletion of the image file fails
                    $DB_con->rollBack();
                    echo json_encode(['msg' => 'Failed to delete menu image file']);
                    exit;
                }
            } else {
                // No image file associated with the menu, commit the transaction
                $DB_con->commit();
                echo json_encode(['success' => 'Image deleted successfully']);
                exit;
            }
        } else {
            // Rollback the transaction if deletion of the menu fails
            $DB_con->rollBack();
            echo json_encode(['msg' => 'Failed to delete menu']);
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
