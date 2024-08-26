<?php
// Include database connection
require_once '../config/conn.php';

// Initialize variables
$username = $password = '';
$err = $password_err = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate username
    if (empty($username)) {
        $err = 'Please enter username.';
    }

    // Validate password
    if (empty($password)) {
        $password_err = 'Please enter password.';
    }

    // Check for input errors
    if (empty($err) && empty($password_err)) {
        // Prepare SQL statement to check if username exists
        $sql_check_username = 'SELECT admin_id, password FROM tbl_admin WHERE username = :username';
        $stmt_check_username = $DB_con->prepare($sql_check_username);
        $stmt_check_username->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt_check_username->execute();
        $user = $stmt_check_username->fetch(PDO::FETCH_ASSOC);

        if ($stmt_check_username->rowCount() == 1) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_id'] = $user['admin_id'];
                echo json_encode(['success' => 'Login successful. Redirecting...']);
                exit();
            } else {
                $password_err = 'Invalid password.';
            }
        } else {
            $err = 'No account found with that username.';
        }
    }
    // Send error messages as JSON response
    echo json_encode(['msg' => $err . ' ' . $password_err]);
    exit();
}
?>
