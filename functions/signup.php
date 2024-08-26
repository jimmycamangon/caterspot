<?php

// Include database connection
require_once '../config/conn.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $verification_code = $_POST['verification_code'];



    // Check if the code is valid (exists in the database)
    $stmt_check_code = $DB_con->prepare("SELECT * FROM tbl_emailverification WHERE email = :email AND code = :code");
    $stmt_check_code->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt_check_code->bindValue(':code', $verification_code, PDO::PARAM_STR);
    $stmt_check_code->execute();

    if ($stmt_check_code->rowCount() == 0) {
        echo json_encode(['msg' => 'Invalid verification code.']);
        exit();
    }

    // Check if the code is expired
    $stmt_check_expiration = $DB_con->prepare("SELECT * FROM tbl_emailverification WHERE email = :email AND code = :code AND expiration > :current_time");
    $stmt_check_expiration->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt_check_expiration->bindValue(':code', $verification_code, PDO::PARAM_STR);
    $stmt_check_expiration->bindValue(':current_time', time(), PDO::PARAM_INT);
    $stmt_check_expiration->execute();

    if ($stmt_check_expiration->rowCount() == 0) {
        echo json_encode(['msg' => 'Your code has been expired, please try again.']);
        exit();
    }
    // Proceed with the user registration if the code is valid
    $hashed_password = password_hash($password, PASSWORD_ARGON2I);
    $user_id = mt_rand(10000, 99999);

    // Prepare SQL statement
    $sql = 'INSERT INTO tbl_users (user_id, email, username, firstname, lastname, password) VALUES (:user_id, :email, :username, :firstname, :lastname, :password)';
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);

    // Execute the prepared statement
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $user_id;
        $success = 'Account verified and successfully created! Redirecting to Home..';
        echo json_encode(['success' => $success]);
    } else {
        $msg = 'Oops! Something went wrong. Please try again later.';
        echo json_encode(['msg' => $msg]);
    }

    // Close connection
    unset($DB_con);
}
?>
