<?php

// Include database connection
require_once '../../../config/conn.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Retrieve form data
    $package_id = $_POST['package_id'];
    $menu_name = $_POST['menu_name'];
    $menu_description = $_POST['menu_description'];
    $menu_price = $_POST['menu_price'];
    $client_id = $_POST['client_id'];
    $menu_image = $_POST['menu_image'];


    // Validate menu_name
    if (empty(trim($menu_name))) {
        $msg = 'Please enter a menu name.';
        // Return the error message if it exists
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate menu_description
    if (empty(trim($menu_description))) {
        $msg = 'Please enter a menu description.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate menu_price
    if (!is_numeric($menu_price) || $menu_price <= 0) {
        $msg = 'Please enter a valid menu price.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Check if menu name already exists for the specified package
    $sql_check_menu_name = 'SELECT COUNT(*) AS num_menus FROM tbl_menus WHERE package_id = :package_id AND menu_name = :menu_name AND client_id = :client_id';
    $stmt_check_menu_name = $DB_con->prepare($sql_check_menu_name);
    $stmt_check_menu_name->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt_check_menu_name->bindParam(':menu_name', $menu_name, PDO::PARAM_STR);
    $stmt_check_menu_name->bindParam(':client_id', $client_id, PDO::PARAM_STR);
    $stmt_check_menu_name->execute();
    $row = $stmt_check_menu_name->fetch(PDO::FETCH_ASSOC);

    if ($row['num_menus'] > 0) {
        $msg = 'A menu with the same name already exists for this package.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Check if menu image already exists
    $menu_image_path = "../../../assets/img/menu-uploads/$menu_image";
    if (file_exists($menu_image_path)) {
        $msg = 'An image with the same name already exists. Please choose a different image.';
        echo json_encode(['msg' => $msg]);
        exit();
    }



    // // Validate menu_description
    // if (empty(trim($menu_image))) {
    //     $msg = 'No image uploaded.';
    //     echo json_encode(['msg' => $msg]);
    //     exit();
    // }

    $menu_id = mt_rand(10000, 99999);
    // Prepare SQL statement
    $sql = 'INSERT INTO tbl_menus (menu_id, package_id, client_id, menu_name, menu_description, menu_price, menu_image, availability) VALUES (:menu_id, :package_id, :client_id, :menu_name, :menu_description, :menu_price, :menu_image, "Available")';
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmt->bindParam(':menu_name', $menu_name, PDO::PARAM_STR);
    $stmt->bindParam(':menu_description', $menu_description, PDO::PARAM_STR);
    $stmt->bindParam(':menu_price', $menu_price, PDO::PARAM_STR);
    $stmt->bindParam(':menu_image', $menu_image, PDO::PARAM_STR);

    // Execute the prepared statement
    if ($stmt->execute()) {
        $success = 'Item successfully added.';
        echo json_encode(['success' => $success]);
        exit();
    } else {
        $msg = 'Oops! Something went wrong. Please try again later.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Close statement
    unset($stmt);
    // Close connection
    unset($DB_con);
}
?>