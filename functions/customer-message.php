<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/PHPMailer-master/src/Exception.php';
require '../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../assets/vendor/PHPMailer-master/src/SMTP.php';

require_once '../config/conn.php';

// Check if all fields are received
if (isset($_POST['customer_name']) && isset($_POST['customer_email']) && isset($_POST['customer_subject']) && isset($_POST['customer_message']) && isset($_POST['client_email']) && isset($_POST['client_username'])) {

    // Get form data
    $name = $_POST['customer_name'];
    $email = $_POST['customer_email'];
    $subject = $_POST['customer_subject'];
    $message = $_POST['customer_message'];
    $client_email = $_POST['client_email'];
    $client_username = $_POST['client_username'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // Passing true enables exceptions

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lucaterspot@gmail.com'; // Your email
        $mail->Password = 'qaat pzqc chtx ffvx'; // Your password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom($email, $name); // Sender's email and name
        $mail->addAddress($client_email, $client_username); // Recipient's email and name

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject; // Subject from form input
        $mail->Body = '
        <html>
            <head></head>
            <body>
                <div>
                    <p> Email message from: ' . $email. '</p>
                    <p>' . $message . '</p> <!-- Message from form input -->
                </div>
            </body>
        </html>
    ';

        // Send email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // Return error if any field is missing
    echo "Error: All fields are required.";
}
?>