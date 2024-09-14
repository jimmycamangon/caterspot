<?php

// Include database connection
require_once '../config/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/PHPMailer-master/src/Exception.php';
require '../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../assets/vendor/PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Validate email
    if (empty(trim($email))) {
        $msg = 'Please enter an email address.';
        echo json_encode(['msg' => $msg]);
        exit();
    } else {
        // Check if email already exists
        $sql_check_email = 'SELECT email FROM tbl_users WHERE email = :email';
        $stmt_check_email = $DB_con->prepare($sql_check_email);
        $stmt_check_email->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_check_email->execute();
        if ($stmt_check_email->rowCount() > 0) {
            $msg = 'Email address is already taken.';
            echo json_encode(['msg' => $msg]);
            exit();
        }
    }

    // Validate username
    if (empty(trim($username))) {
        $msg = 'Please enter a username.';
        echo json_encode(['msg' => $msg]);
        exit();
    } else {
        // Check if username already exists
        $sql_check_username = 'SELECT username FROM tbl_users WHERE username = :username';
        $stmt_check_username = $DB_con->prepare($sql_check_username);
        $stmt_check_username->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt_check_username->execute();
        if ($stmt_check_username->rowCount() > 0) {
            $msg = 'Username is already taken.';
            echo json_encode(['msg' => $msg]);
            exit();
        }
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
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
        $msg = 'Password must contain at least one uppercase letter and one special character.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate last name
    if (empty(trim($lastname))) {
        $msg = 'Please enter your last name.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Generate a random 4-digit number
    $code = random_int(1000, 9999);

    // Set expiration time to 5 minutes
    $expiration = time() + (5 * 60); // 5 minutes from now

    // Insert code and email into database
    $stmt_email = $DB_con->prepare("INSERT INTO tbl_emailverification (code, email, expiration) VALUES (:code, :email, :expiration)");
    $stmt_email->bindValue(':code', $code, PDO::PARAM_INT);
    $stmt_email->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt_email->bindValue(':expiration', $expiration, PDO::PARAM_INT);
    $stmt_email->execute();

    // Send verification email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lucaterspot@gmail.com';
    $mail->Password = 'qaat pzqc chtx ffvx';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('lucaterspot@gmail.com', 'CaterSpot');
    $mail->addAddress($email);
    $mail->isHTML(true);

    $mail->Subject = 'Verification code for Caterspot';
    $mail->Body = '
    <html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .code-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            text-align: center;
        }
        h1 {
            color: #2487ce;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
        }
        .verification-code {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
        }
    </style>
    </head>
    <body>
    <div class="code-container">
        <h1>Verify your email</h1>
        <p>Thank you for signing up with Caterspot!</p>
        <p>Please use the following verification code to verify your email:</p>
        <p class="verification-code"> ' . htmlspecialchars($code) . '</p>
    </div>
    </body>
    </html>
    ';

    if ($mail->send()) {
        $success = 'Verification code has been sent.';
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['msg' => 'Email could not be sent. Please try again.']);
    }
}
?>