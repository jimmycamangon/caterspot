<?php
// Include database connection
require_once '../../../config/conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $newPassword = isset($_POST['newpass']) ? $_POST['newpass'] : null;

    // Validate user ID
    if (!$client_id) {
        $msg = 'Client ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Fetch existing data from the database
    $sql_fetch_user = "SELECT * FROM tbl_clients WHERE client_id = :client_id";
    $stmt_fetch_user = $DB_con->prepare($sql_fetch_user);
    $stmt_fetch_user->bindParam(':client_id', $client_id);
    $stmt_fetch_user->execute();
    $existingUserData = $stmt_fetch_user->fetch(PDO::FETCH_ASSOC);

    // Compare form data with existing data
    if (
        empty(trim($newPassword))
    ) {
        $msg = 'No changes were made.';
        echo json_encode(['msg' => $msg]);
        exit();
    }


    // Validate password
    if (!empty(trim($newPassword))) {
        if (strlen($newPassword) < 13) {
            $msg = 'Password must be at least 13 characters long. <br> And Password must contain at least one uppercase letter and one special character.';
            echo json_encode(['msg' => $msg]);
            exit();
        } elseif (!preg_match('/[A-Z]/', $newPassword) || !preg_match('/[^a-zA-Z0-9]/', $newPassword)) {
            $msg = 'Password must contain at least one uppercase letter and one special character.';
            echo json_encode(['msg' => $msg]);
            exit();
        }
    }

    // Retrieve old password from the database
    $sql_select_password = "SELECT password FROM tbl_clients WHERE client_id = :client_id";
    $stmt_select_password = $DB_con->prepare($sql_select_password);
    $stmt_select_password->bindParam(':client_id', $client_id);
    $stmt_select_password->execute();
    $row = $stmt_select_password->fetch(PDO::FETCH_ASSOC);
    $oldPassword = $row['password'];

    // Compare old password with new password
    if (!empty(trim($newPassword))) {
        if (password_verify($newPassword, $oldPassword)) {
            $msg = 'New password must be different from the old password.';
            echo json_encode(['msg' => $msg]);
            exit();
        } else {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            // Update data in the database
            $sql = "UPDATE tbl_clients SET password = :password WHERE client_id = :client_id";
            $stmt = $DB_con->prepare($sql);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':client_id', $client_id);

            try {
                // Execute the prepared statement
                if ($stmt->execute()) {
                    $success = 'Password successfully updated!';
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
        }
    } 

} else {
    $msg = 'Invalid request method.';
    echo json_encode(['msg' => $msg]);
    exit();
}
?>