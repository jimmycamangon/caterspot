<?php
// Include database connection
require_once '../../../../config/conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $cater_description = isset($_POST['description']) ? $_POST['description'] : null;

    // Validate user ID
    if (!$client_id) {
        $msg = 'Client ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Fetch existing data from the database
    $sql_fetch_description = "SELECT cater_description FROM tblclient_settings WHERE client_id = :client_id";
    $stmt_fetch_description = $DB_con->prepare($sql_fetch_description);
    $stmt_fetch_description->bindParam(':client_id', $client_id);
    $stmt_fetch_description->execute();
    $existingCaterDescription = $stmt_fetch_description->fetchColumn();

    // Compare new description with existing description
    if ($cater_description === $existingCaterDescription) {
        // If the descriptions are the same, no changes were made
        $msg = 'No changes were made.';
        echo json_encode(['msg' => $msg]);
        exit();
    }


    // Validate description
    if (empty(trim($cater_description))) {
        $msg = 'Please enter cater_description.';
        echo json_encode(['msg' => $msg]);
        exit();
    }





    // Update data in the database
    $sql = "UPDATE tblclient_settings SET cater_description = :cater_description WHERE client_id = :client_id";
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':cater_description', $cater_description);
    $stmt->bindParam(':client_id', $client_id);

    try {
        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = 'Description successfully updated!';
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