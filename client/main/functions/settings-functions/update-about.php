<?php
// Include database connection
require_once '../../../../config/conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $cater_about_us = isset($_POST['about_us']) ? $_POST['about_us'] : null;

    // Validate user ID
    if (!$client_id) {
        $msg = 'Client ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Fetch existing data from the database
    $sql_fetch_about_us = "SELECT about_us FROM tblclient_settings WHERE client_id = :client_id";
    $stmt_fetch_about_us = $DB_con->prepare($sql_fetch_about_us);
    $stmt_fetch_about_us->bindParam(':client_id', $client_id);
    $stmt_fetch_about_us->execute();
    $existingCaterabout_us = $stmt_fetch_about_us->fetchColumn();

    // Compare new about_us with existing about_us
    if ($cater_about_us === $existingCaterabout_us) {
        // If the about_uss are the same, no changes were made
        $msg = 'No changes were made.';
        echo json_encode(['msg' => $msg]);
        exit();
    }


    // Validate about_us
    if (empty(trim($cater_about_us))) {
        $msg = 'Please enter information about your catering service.';
        echo json_encode(['msg' => $msg]);
        exit();
    }





    // Update data in the database
    $sql = "UPDATE tblclient_settings SET about_us = :cater_about_us WHERE client_id = :client_id";
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':cater_about_us', $cater_about_us);
    $stmt->bindParam(':client_id', $client_id);

    try {
        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = 'About info successfully updated!';
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