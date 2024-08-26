<?php

// Include database connection
require_once '../../../config/conn.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve form data
    $package_name = $_POST['package_name'];
    $package_desc = $_POST['package_desc'];
    $package_image = $_POST['package_image'];
    $client_id = $_POST['client_id'];

    // Validate email
    if (empty(trim($package_name))) {
        $msg = 'Please enter an package name.';
        // Return the email error if it exists
        echo json_encode(['msg' => $msg]);
        exit();
    } else {
        // Check if email already exists
        $sql_check_package_name = 'SELECT package_name FROM tbl_packages WHERE package_name = :package_name AND client_id = :client_id';
        $stmt_check_package_name = $DB_con->prepare($sql_check_package_name);
        $stmt_check_package_name->bindParam(':package_name', $package_name, PDO::PARAM_STR);
        $stmt_check_package_name->bindParam(':client_id', $client_id, PDO::PARAM_STR);
        $stmt_check_package_name->execute();
        if ($stmt_check_package_name->rowCount() > 0) {
            $msg = 'Package Name is already taken.';
            // Return the email error if it exists
            echo json_encode(['msg' => $msg]);
            exit();
        }
    }

    // Check if menu image already exists
    $package_image_path = "../../../assets/img/package-uploads/$package_image";
    if (file_exists($package_image_path)) {
        $msg = 'An image with the same name already exists. Please choose a different image.';
        echo json_encode(['msg' => $msg]);
        exit();
    }



    // Validate package_desc
    if (empty(trim($package_desc))) {
        $msg = 'Please enter a package description.';
        echo json_encode(['msg' => $msg]);
        exit();
    }



    if (empty($msg)) {

        // Generate 
        $package_id = mt_rand(10000, 99999);

        // Prepare SQL statement
        $sql = 'INSERT INTO tbl_packages (client_id, package_id, package_name, package_desc, package_image) VALUES (:client_id, :package_id, :package_name, :package_desc, :package_image)';
        $stmt = $DB_con->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
        $stmt->bindParam(':package_id', $package_id, PDO::PARAM_STR);
        $stmt->bindParam(':package_name', $package_name, PDO::PARAM_STR);
        $stmt->bindParam(':package_desc', $package_desc, PDO::PARAM_STR);
        $stmt->bindParam(':package_image', $package_image, PDO::PARAM_STR);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = 'Package successfully created.';
            echo json_encode(['success' => $success]);
            exit();
        } else {
            $msg = 'Oops! Something went wrong. Please try again later.';
            echo json_encode(['msg' => $msg]);
            exit();
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($DB_con);
}
?>