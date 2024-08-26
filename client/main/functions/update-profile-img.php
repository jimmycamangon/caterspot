<?php
// Include database connection
require_once '../../../config/conn.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $client_image = isset($_POST['client_image']) ? $_POST['client_image'] : null;
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;

    // Check if client_image is empty
    if (empty($client_image)) {
        $msg = 'Profile image is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    // Retrieve the last image associated with the bg
    $sql_select_last_image = "SELECT client_image FROM tbl_clients WHERE client_id = :client_id";
    $stmt_select_last_image = $DB_con->prepare($sql_select_last_image);
    $stmt_select_last_image->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmt_select_last_image->execute();
    $last_image_row = $stmt_select_last_image->fetch(PDO::FETCH_ASSOC);
    $last_client_image = isset($last_image_row['client_image']) ? $last_image_row['client_image'] : null;

    // Check if the provided image is the same as the last image
    if ($client_image === $last_client_image) {
        $msg = 'No changes were made. Same image already set.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Check if there's a last image associated with the bg and delete it
    if (!empty($last_client_image)) {
        $last_client_image_path = "../../../assets/img/client-images/$last_client_image";
        if (file_exists($last_client_image_path)) {
            if (!unlink($last_client_image_path)) {
                $msg = 'Failed to delete the last Background image file.';
                echo json_encode(['msg' => $msg]);
                exit();
            }
        }
    }
    

    $sql = 'UPDATE tbl_clients SET client_image = :client_image WHERE client_id = :client_id';
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':client_image', $client_image, PDO::PARAM_STR);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);

    try {
        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = 'Profile image successfully updated!';
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
