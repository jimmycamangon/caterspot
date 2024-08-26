<?php
// Include database connection
require_once '../../../config/conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $contact = isset($_POST['contact']) ? $_POST['contact'] : null;
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
        $email == $existingUserData['email'] &&
        $contact == $existingUserData['contact'] &&
        $username == $existingUserData['username'] &&
        empty(trim($newPassword))
    ) {
        $msg = 'No changes were made.';
        echo json_encode(['msg' => $msg]);
        exit();
    }


    // Validate email
    if (empty(trim($email))) {
        $msg = 'Please enter email.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate Contact
    if (empty(trim($contact))) {
        $msg = 'Please enter contact no.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    // Validate contact number format
    if (!preg_match('/^(\(\d{3}\)\s?\d{3}\s?\d{4}|\d{3}-\d{3}-\d{4}|\d{11})$/', $contact)) {
        $msg = 'Contact number must be in the format (xxx) xxx xxxx or xxx-xxx-xxxx or 09xxxxxxxxx.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Limit contact number to 11 characters
    if (strlen(preg_replace('/[^0-9]/', '', $contact)) > 11) {
        $msg = 'Contact number must not exceed 11 digits.';
        echo json_encode(['msg' => $msg]);
        exit();
    }


    // Validate username
    if (empty(trim($username))) {
        $msg = 'Please enter a username.';
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
            $sql = "UPDATE tbl_clients SET password = :password, email = :email, username = :username, contact = :contact WHERE client_id = :client_id";
            $stmt = $DB_con->prepare($sql);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':client_id', $client_id);

            try {
                // Execute the prepared statement
                if ($stmt->execute()) {
                    $success = 'Profile successfully updated!';
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
    } else {

        // Update data in the database
        $sql = "UPDATE tbl_clients SET email = :email, username = :username, contact = :contact WHERE client_id = :client_id";
        $stmt = $DB_con->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':client_id', $client_id);

        try {
            // Execute the prepared statement
            if ($stmt->execute()) {
                $success = 'Profile successfully updated!';
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

} else {
    $msg = 'Invalid request method.';
    echo json_encode(['msg' => $msg]);
    exit();
}
?>