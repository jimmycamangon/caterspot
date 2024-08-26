<?php
// Include database connection
require_once '../../../config/conn.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $packageId = isset($_POST['package_id']) ? $_POST['package_id'] : null;
    $packageName = isset($_POST['package_name']) ? $_POST['package_name'] : null;
    $packageDesc = isset($_POST['package_desc']) ? $_POST['package_desc'] : null;
    $package_image = isset($_POST['package_image']) ? $_POST['package_image'] : null;





    // Validate package ID
    if (!$packageId) {
        $msg = 'Package ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate package name
    if (empty(trim($packageName))) {
        $msg = 'Please enter a Package name.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate package description
    if (empty(trim($packageDesc))) {
        $msg = 'Please enter a package description.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    // Check if package name already exists for the specified package
    $sql_check_package_name = 'SELECT COUNT(*) AS num_packages FROM tbl_packages WHERE package_id != :package_id AND package_name = :package_name';
    $stmt_check_package_name = $DB_con->prepare($sql_check_package_name);
    $stmt_check_package_name->bindParam(':package_id', $packageId, PDO::PARAM_INT);
    $stmt_check_package_name->bindParam(':package_name', $packageName, PDO::PARAM_STR);
    $stmt_check_package_name->execute();
    $row = $stmt_check_package_name->fetch(PDO::FETCH_ASSOC);

    if ($row['num_packages'] > 0) {
        $msg = 'A package with the same name already exists for this package.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // // Check if package image already exists
    // $package_image_path = "../../../assets/img/package-uploads/$package_image";
    // if (file_exists($package_image_path)) {
    //     $msg = 'An image with the same name already exists. Please choose a different image.';
    //     echo json_encode(['msg' => $msg]);
    //     exit();
    // }

    if (empty(trim($package_image))) {

        // Prepare SQL statement to update package
        $sql = 'UPDATE tbl_packages SET package_name = :package_name, package_desc = :package_desc WHERE package_id = :package_id';
        $stmt = $DB_con->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':package_id', $packageId, PDO::PARAM_INT);
        $stmt->bindParam(':package_name', $packageName, PDO::PARAM_STR);
        $stmt->bindParam(':package_desc', $packageDesc, PDO::PARAM_STR);
        $stmt->bindParam(':package_id', $packageId, PDO::PARAM_INT);

    } else {
        // Retrieve the last image associated with the package
        $sql_select_last_image = "SELECT package_image FROM tbl_packages WHERE package_id = :package_id";
        $stmt_select_last_image = $DB_con->prepare($sql_select_last_image);
        $stmt_select_last_image->bindParam(':package_id', $packageId, PDO::PARAM_INT);
        $stmt_select_last_image->execute();
        $last_image_row = $stmt_select_last_image->fetch(PDO::FETCH_ASSOC);
        $last_package_image = isset($last_image_row['package_image']) ? $last_image_row['package_image'] : null;

        // Check if there's a last image associated with the package and delete it
        if (!empty($last_package_image)) {
            $last_package_image_path = "../../../assets/img/package-uploads/$last_package_image";
            if (file_exists($last_package_image_path)) {
                if (!unlink($last_package_image_path)) {
                    $msg = 'Failed to delete the last package image file.';
                    echo json_encode(['msg' => $msg]);
                    exit();
                }
            }
        }


        $sql = 'UPDATE tbl_packages SET  package_name = :package_name, package_desc = :package_desc, package_image = :package_image WHERE package_id = :package_id';
        $stmt = $DB_con->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':package_id', $packageId, PDO::PARAM_INT);
        $stmt->bindParam(':package_name', $packageName, PDO::PARAM_STR);
        $stmt->bindParam(':package_desc', $packageDesc, PDO::PARAM_STR);
        $stmt->bindParam(':package_image', $package_image, PDO::PARAM_STR);



    }

    try {
        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = 'Package successfully updated!';
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