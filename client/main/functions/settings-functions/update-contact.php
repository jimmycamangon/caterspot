<?php
// Include database connection
require_once '../../../../config/conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $cater_name = isset($_POST['cater_location']) ? $_POST['cater_name'] : null;
    $cater_location = isset($_POST['cater_location']) ? $_POST['cater_location'] : null;
    $cater_email = isset($_POST['cater_email']) ? $_POST['cater_email'] : null;
    $cater_contactno = isset($_POST['cater_contactno']) ? $_POST['cater_contactno'] : null;
    $cater_gmaplink = isset($_POST['cater_gmaplink']) ? $_POST['cater_gmaplink'] : null;
    $socmed_link = isset($_POST['socmed_link']) ? $_POST['socmed_link'] : null;

    // Validate user ID
    if (!$client_id) {
        $msg = 'Client ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    if (!$cater_location) {
        $msg = 'Location is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    if (!$cater_name) {
        $msg = 'Catering Name is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    if (!$cater_email) {
        $msg = 'Email is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    if (!$cater_contactno) {
        $msg = 'Contact Number is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // if (!$cater_gmaplink) {
    //     $msg = 'Google Map Address Link is required.';
    //     echo json_encode(['msg' => $msg]);
    //     exit();
    // }


    // Fetch existing data from the database
    $sql_check_existing = "SELECT cater_name, cater_location, cater_email, cater_contactno, cater_gmaplink, socmed_link FROM tblclient_settings WHERE client_id = :client_id";
    $stmt_check_existing = $DB_con->prepare($sql_check_existing);
    $stmt_check_existing->bindParam(':client_id', $client_id);
    $stmt_check_existing->execute();
    $existingData = $stmt_check_existing->fetch(PDO::FETCH_ASSOC);
    
    // Check if the fetched data matches the POST data
    if ($existingData['cater_name'] === $cater_name && $existingData['cater_location'] === $cater_location && $existingData['cater_email'] === $cater_email
    && $existingData['cater_contactno'] === $cater_contactno  && $existingData['cater_gmaplink'] === $cater_gmaplink && $existingData['socmed_link'] === $socmed_link
    ) {
        // If both question and answer are unchanged, no changes were made
        $msg = 'No changes were made.';
        echo json_encode(['msg' => $msg]);
        exit();
    }




    // Update data in the database
    $sql = "UPDATE tblclient_settings SET cater_name = :cater_name, cater_location = :cater_location, cater_email = :cater_email, cater_contactno = :cater_contactno, socmed_link = :socmed_link, cater_gmaplink = :cater_gmaplink  WHERE client_id = :client_id";
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':cater_name', $cater_name);
    $stmt->bindParam(':cater_location', $cater_location);
    $stmt->bindParam(':cater_email', $cater_email);
    $stmt->bindParam(':cater_contactno', $cater_contactno);
    $stmt->bindParam(':socmed_link', $socmed_link);
    $stmt->bindParam(':cater_gmaplink', $cater_gmaplink);
    $stmt->bindParam(':client_id', $client_id);

    try {
        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = 'Contact information successfully updated!';
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