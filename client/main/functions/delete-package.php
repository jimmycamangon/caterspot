<?php
// Include database connection
require_once '../../../config/conn.php';

// Process delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve package_id from POST data
    $package_id = isset($_POST['package_id']) ? $_POST['package_id'] : null;

    if (!$package_id) {
        $msg = 'Package ID is missing.';
        echo json_encode(['msg' => $msg]);
        exit;
    }

    try {
        // Start a database transaction
        $DB_con->beginTransaction();

        // Prepare SQL statement to select the menu image file name
        $sql_select_image = "SELECT package_image FROM tbl_packages WHERE package_id = :package_id";
        $stmt_select_image = $DB_con->prepare($sql_select_image);
        $stmt_select_image->bindParam(':package_id', $package_id, PDO::PARAM_INT);
        $stmt_select_image->execute();
        $image_row = $stmt_select_image->fetch(PDO::FETCH_ASSOC);
        $package_image = isset($image_row['package_image']) ? $image_row['package_image'] : null;

        // Delete the package record from the database
        $sql_delete_package = "DELETE FROM tbl_packages WHERE package_id = :package_id";
        $stmt_delete_package = $DB_con->prepare($sql_delete_package);
        $stmt_delete_package->bindParam(':package_id', $package_id, PDO::PARAM_INT);

        // Execute the SQL statement to delete the menu
        if ($stmt_delete_package->execute()) {
            // Check if an image file is associated with the menu
            if (!empty($package_image)) {
                // Delete the associated image file from the menu-uploads folder
                $image_path = "../../../assets/img/package-uploads/" . $package_image;
                if (file_exists($image_path)) {
                    if (unlink($image_path)) {
                        // Commit the transaction if deletion of both menu and image file is successful
                        $DB_con->commit();
                        echo json_encode(['success' => 'Package deleted successfully']);
                        exit;
                    } else {
                        // Rollback the transaction if deletion of the image file fails
                        $DB_con->rollBack();
                        echo json_encode(['msg' => 'Failed to delete menu image file']);
                        exit;
                    }
                } else {
                    // If the image file does not exist, still commit the transaction
                    $DB_con->commit();
                    echo json_encode(['success' => 'Package deleted successfully']);
                    exit;
                }
            } else {
                // No image file associated with the menu, commit the transaction
                $DB_con->commit();
                echo json_encode(['success' => 'Package deleted successfully']);
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
