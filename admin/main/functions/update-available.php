<?php
// Include database connection
require_once '../../../config/conn.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $statusId = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;


    // Validate status ID
    if (!$statusId) {
        $msg = 'Status ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    // Check if status name already exists for the specified package
    $sql_check_status_name = 'SELECT COUNT(*) AS num_status FROM tbl_clients WHERE status = :status AND client_id = :statusId';
    $stmt_check_status_name = $DB_con->prepare($sql_check_status_name);
    $stmt_check_status_name->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt_check_status_name->bindParam(':statusId', $statusId, PDO::PARAM_INT);
    $stmt_check_status_name->execute();
    $row = $stmt_check_status_name->fetch(PDO::FETCH_ASSOC);

    if ($row['num_status'] > 0) {
        $msg = 'You cannot update the existing status with same value.';
        echo json_encode(['msg' => $msg]);
        exit();
    }


        // Prepare SQL statement to update status
        $sql = 'UPDATE tbl_clients SET status = :status WHERE client_id = :statusId';
        $stmt = $DB_con->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);


    try {
        // Execute the prepared statement
        if ($stmt->execute()) {
            $success = 'Status successfully updated!';
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