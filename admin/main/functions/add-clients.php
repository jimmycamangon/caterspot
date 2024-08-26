<?php

// Include database connection
require_once '../../../config/conn.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve form data
    $cater_name = $_POST['cater_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate catering name
    if (empty(trim($cater_name))) {
        $msg = 'Please enter a Catering Name.';
        // Return the error message
        echo json_encode(['msg' => $msg]);
        exit();
    } else {
        // Check if catering name already exists
        $sql_check_cater_name = 'SELECT username FROM tbl_clients WHERE username = :cater_name';
        $stmt_check_cater_name = $DB_con->prepare($sql_check_cater_name);
        $stmt_check_cater_name->bindParam(':cater_name', $cater_name, PDO::PARAM_STR);
        $stmt_check_cater_name->execute();
        if ($stmt_check_cater_name->rowCount() > 0) {
            $msg = 'Catering Name is already taken.';
            // Return the error message
            echo json_encode(['msg' => $msg]);
            exit();
        }
    }

    // Validate email
    if (empty(trim($email))) {
        $msg = 'Please enter a client email.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate password
    if (empty(trim($password))) {
        $msg = 'Please enter a password.';
        echo json_encode(['msg' => $msg]);
        exit();
    } elseif (strlen($password) < 8) {
        $msg = 'Password must be at least 8 characters long.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Generate a unique client ID
    $client_id = mt_rand(10000, 99999);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_ARGON2I);

    // Prepare and execute the first SQL statement
    $sql = 'INSERT INTO tbl_clients (client_id, email, username, password) VALUES (:client_id, :email, :cater_name, :password)';
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
    $stmt->bindParam(':cater_name', $cater_name, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        // Prepare and execute the second SQL statement
        $sql2 = 'INSERT INTO tblclient_settings (client_id, cater_name, cater_email) VALUES (:client_id, :cater_name, :email)';
        $stmt2 = $DB_con->prepare($sql2);
        $stmt2->bindParam(':client_id', $client_id, PDO::PARAM_STR);
        $stmt2->bindParam(':cater_name', $cater_name, PDO::PARAM_STR);
        $stmt2->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt2->execute();
        
        // Return success message
        $success = 'Client account successfully created.';
        echo json_encode(['success' => $success]);
        exit();
    } else {
        // Return error message if something goes wrong
        $msg = 'Oops! Something went wrong. Please try again later.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Close statement and connection
    unset($stmt);
    unset($stmt2);
    unset($DB_con);
}
?>
