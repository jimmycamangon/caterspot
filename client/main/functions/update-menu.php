<?php
// Include database connection
require_once '../../../config/conn.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $menuId = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;
    $packageId = isset($_POST['package_id']) ? $_POST['package_id'] : null;
    $menuName = isset($_POST['menu_name']) ? $_POST['menu_name'] : null;
    $menuDesc = isset($_POST['menu_description']) ? $_POST['menu_description'] : null;
    $menuPrice = isset($_POST['menu_price']) ? $_POST['menu_price'] : null;
    $availability = isset($_POST['availability']) ? $_POST['availability'] : null;
    $menu_image = isset($_POST['menu_image']) ? $_POST['menu_image'] : null;




    // Validate menu ID
    if (!$menuId) {
        $msg = 'Menu ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate package ID
    if (!$packageId) {
        $msg = 'Package is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate menu name
    if (empty(trim($menuName))) {
        $msg = 'Please enter a menu name.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate menu description
    if (empty(trim($menuDesc))) {
        $msg = 'Please enter a menu description.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate menu price
    if (!is_numeric($menuPrice) || $menuPrice <= 0) {
        $msg = 'Please enter a valid menu price.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Check if menu name already exists for the specified package
    $sql_check_menu_name = 'SELECT COUNT(*) AS num_menus FROM tbl_menus WHERE package_id = :package_id AND menu_name = :menu_name AND menu_id != :menu_id';
    $stmt_check_menu_name = $DB_con->prepare($sql_check_menu_name);
    $stmt_check_menu_name->bindParam(':package_id', $packageId, PDO::PARAM_INT);
    $stmt_check_menu_name->bindParam(':menu_name', $menuName, PDO::PARAM_STR);
    $stmt_check_menu_name->bindParam(':menu_id', $menuId, PDO::PARAM_INT);
    $stmt_check_menu_name->execute();
    $row = $stmt_check_menu_name->fetch(PDO::FETCH_ASSOC);

    if ($row['num_menus'] > 0) {
        $msg = 'A menu with the same name already exists for this package.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // // Check if menu image already exists
    // $menu_image_path = "../../../assets/img/menu-uploads/$menu_image";
    // if (file_exists($menu_image_path)) {
    //     $msg = 'An image with the same name already exists. Please choose a different image.';
    //     echo json_encode(['msg' => $msg]);
    //     exit();
    // }

    if (empty(trim($menu_image))) {

        // Prepare SQL statement to update menu
        $sql = 'UPDATE tbl_menus SET package_id = :package_id, menu_name = :menu_name, menu_description = :menu_desc, menu_price = :menu_price, availability = :availability WHERE menu_id = :menu_id';
        $stmt = $DB_con->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':package_id', $packageId, PDO::PARAM_INT);
        $stmt->bindParam(':menu_name', $menuName, PDO::PARAM_STR);
        $stmt->bindParam(':menu_desc', $menuDesc, PDO::PARAM_STR);
        $stmt->bindParam(':menu_price', $menuPrice, PDO::PARAM_STR);
        $stmt->bindParam(':availability', $availability, PDO::PARAM_STR);
        $stmt->bindParam(':menu_id', $menuId, PDO::PARAM_INT);

    } else {
        // Retrieve the last image associated with the menu
        $sql_select_last_image = "SELECT menu_image FROM tbl_menus WHERE menu_id = :menu_id";
        $stmt_select_last_image = $DB_con->prepare($sql_select_last_image);
        $stmt_select_last_image->bindParam(':menu_id', $menuId, PDO::PARAM_INT);
        $stmt_select_last_image->execute();
        $last_image_row = $stmt_select_last_image->fetch(PDO::FETCH_ASSOC);
        $last_menu_image = isset($last_image_row['menu_image']) ? $last_image_row['menu_image'] : null;

        // Check if there's a last image associated with the menu and delete it
        if (!empty($last_menu_image)) {
            $last_menu_image_path = "../../../assets/img/menu-uploads/$last_menu_image";
            if (file_exists($last_menu_image_path)) {
                if (!unlink($last_menu_image_path)) {
                    $msg = 'Failed to delete the last menu image file.';
                    echo json_encode(['msg' => $msg]);
                    exit();
                }
            }
        }


        $sql = 'UPDATE tbl_menus SET package_id = :package_id, menu_name = :menu_name, menu_description = :menu_desc, menu_price = :menu_price,  availability = :availability, menu_image = :menu_image WHERE menu_id = :menu_id';
        $stmt = $DB_con->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':package_id', $packageId, PDO::PARAM_INT);
        $stmt->bindParam(':menu_name', $menuName, PDO::PARAM_STR);
        $stmt->bindParam(':menu_desc', $menuDesc, PDO::PARAM_STR);
        $stmt->bindParam(':menu_price', $menuPrice, PDO::PARAM_STR);
        $stmt->bindParam(':availability', $availability, PDO::PARAM_STR);
        $stmt->bindParam(':menu_image', $menu_image, PDO::PARAM_STR);
        $stmt->bindParam(':menu_id', $menuId, PDO::PARAM_INT);



    }

    try {
        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = 'Item successfully updated!';
            echo json_encode(['success' => $success]);
            exit();
        } else {
            $msg = 'Oops! Something went wrong. Please try again later.';
            echo json_encode(['msg' => $msg]);
            exit();
        }
    } catch (PDOException $e) {
        $msg = 'Error: ' . $e->getMessage();
        echo json_encode(['msg' => $msg]);
        exit();
    }
} else {
    $msg = 'Invalid request method.';
    echo json_encode(['msg' => $msg]);
    exit();
}
?>