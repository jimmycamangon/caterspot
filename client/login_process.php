<?php
// Include database connection
require_once '../config/conn.php';

// Initialize variables
$email = $password = '';
$email_err = $password_err = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email
    if (empty($email)) {
        $email_err = 'Please enter your email.';
    }

    // Validate password
    if (empty($password)) {
        $password_err = 'Please enter your password.';
    }

    // Check for input errors
    if (empty($email_err) && empty($password_err)) {
        // Prepare SQL statement to check if email exists
        $sql_check_email = 'SELECT client_id, password FROM tbl_clients WHERE email = :email';
        $stmt_check_email = $DB_con->prepare($sql_check_email);
        $stmt_check_email->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_check_email->execute();
        $user = $stmt_check_email->fetch(PDO::FETCH_ASSOC);

        if ($stmt_check_email->rowCount() == 1) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['client_id'] = $user['client_id'];
                echo json_encode(['success' => 'Login successful. Redirecting...']);
                exit();
            } else {
                $password_err = 'Invalid password.';
            }
        } else {
            $email_err = 'No account found with that email.';
        }
    }
    // Send error messages as JSON response
    echo json_encode(['msg' => $email_err . ' ' . $password_err]);
    exit();
}
?>
