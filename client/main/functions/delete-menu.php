<?php
// Include database connection
require_once '../../../config/conn.php';

// Process delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve menu_id from POST data
    $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;

    if (!$menu_id) {
        echo json_encode(['msg' => 'Menu ID is missing.']);
        exit;
    }

    try {
        // Start a database transaction
        $DB_con->beginTransaction();

        // Delete menu record from tbl_menus
        $sql_delete_menu = "DELETE FROM tbl_menus WHERE menu_id = :menu_id";
        $stmt_delete_menu = $DB_con->prepare($sql_delete_menu);
        $stmt_delete_menu->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);

        // Execute the SQL statement to delete the menu
        if (!$stmt_delete_menu->execute()) {
            throw new Exception('Failed to delete menu.');
        }

        // Check if an image file is associated with the menu
        $sql_select_image = "SELECT menu_image FROM tbl_menus WHERE menu_id = :menu_id";
        $stmt_select_image = $DB_con->prepare($sql_select_image);
        $stmt_select_image->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmt_select_image->execute();
        $image_row = $stmt_select_image->fetch(PDO::FETCH_ASSOC);
        $menu_image = isset($image_row['menu_image']) ? $image_row['menu_image'] : null;

        if (!empty($menu_image)) {
            // Delete the associated image file
            if (!unlink("../../../assets/img/menu-uploads/" . $menu_image)) {
                throw new Exception('Failed to delete menu image file.');
            }
        }

        // Check if any images are associated with the other menu
        $sql_select_other_images = "SELECT file_name FROM tblclient_othermenus WHERE menu_id = :menu_id";
        $stmt_select_other_images = $DB_con->prepare($sql_select_other_images);
        $stmt_select_other_images->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
        $stmt_select_other_images->execute();

        while ($image_row = $stmt_select_other_images->fetch(PDO::FETCH_ASSOC)) {
            $file_name = isset($image_row['file_name']) ? $image_row['file_name'] : null;
            if (!empty($file_name)) {
                // Delete the associated image file
                if (!unlink("../../../assets/img/other-menu-uploads/" . $file_name)) {
                    throw new Exception('Failed to delete other menu image file.');
                }
            }
        }

        // Delete menu records from tblclient_othermenus
        $sql_delete_other_menu = "DELETE FROM tblclient_othermenus WHERE menu_id = :menu_id";
        $stmt_delete_other_menu = $DB_con->prepare($sql_delete_other_menu);
        $stmt_delete_other_menu->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);

        // Execute the SQL statement to delete the menu records
        if (!$stmt_delete_other_menu->execute()) {
            throw new Exception('Failed to delete other menu.');
        }
        // Commit the transaction if all deletions are successful
        $DB_con->commit();
        echo json_encode(['success' => 'Item deleted successfully']);
        exit;
    } catch (Exception $e) {
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