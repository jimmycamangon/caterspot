<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/PHPMailer-master/src/Exception.php';
require '../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../assets/vendor/PHPMailer-master/src/SMTP.php';

require_once '../config/conn.php';

// Check if all fields are received
if (
    isset($_POST['business_name']) && isset($_POST['owner']) && isset($_POST['contact_number']) && isset($_POST['gmail']) && isset($_POST['edit_region']) && isset($_POST['edit_province'])
    && isset($_POST['edit_city']) && isset($_POST['street'])
) {

    // Get form data
    $business_name = $_POST['business_name'];
    $owner = $_POST['owner'];
    $contact_number = $_POST['contact_number'];
    $gmail = $_POST['gmail'];
    $edit_region = $_POST['edit_region'];
    $edit_province = $_POST['edit_province'];
    $edit_city = $_POST['edit_city'];
    $street = $_POST['street'];



    // Get ADDRESS
    // Region
    $sql = 'SELECT regDesc FROM tbl_refregion WHERE regCode = :edit_region';
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':edit_region', $edit_region, PDO::PARAM_STR);
    $stmt->execute();

    $region = $stmt->fetch(PDO::FETCH_ASSOC)['regDesc'];

    // Province
    $sql2 = 'SELECT provDesc FROM tbl_refprovince WHERE provCode = :edit_province';
    $stmt2 = $DB_con->prepare($sql2);
    $stmt2->bindParam(':edit_province', $edit_province, PDO::PARAM_STR);
    $stmt2->execute();

    $province = $stmt2->fetch(PDO::FETCH_ASSOC)['provDesc'];

    // City
    $sql3 = 'SELECT citymunDesc FROM tbl_refcitymun WHERE citymunCode = :edit_city';
    $stmt3 = $DB_con->prepare($sql3);
    $stmt3->bindParam(':edit_city', $edit_city, PDO::PARAM_STR);
    $stmt3->execute();

    $city = $stmt3->fetch(PDO::FETCH_ASSOC)['citymunDesc'];






    $email = 'lucaterspot@gmail.com';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // Passing true enables exceptions

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lucaterspot@gmail.com'; // Your email
        $mail->Password = 'swab lgbd bufz sagd'; // Your password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom($gmail, $owner); // Sender's email and name
        $mail->addAddress($email, 'Jims'); // Recipient's email and name

        // Attach Business Permit files
        if (isset($_FILES['permit'])) {
            foreach ($_FILES['permit']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['permit']['error'][$key] == UPLOAD_ERR_OK) {
                    $mail->addAttachment($tmp_name, $_FILES['permit']['name'][$key]);
                }
            }
        }

        // Attach Menu files
        if (isset($_FILES['menu'])) {
            foreach ($_FILES['menu']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['menu']['error'][$key] == UPLOAD_ERR_OK) {
                    $mail->addAttachment($tmp_name, $_FILES['menu']['name'][$key]);
                }
            }
        }

        // Attach Business Image files
        if (isset($_FILES['business_img'])) {
            foreach ($_FILES['business_img']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['business_img']['error'][$key] == UPLOAD_ERR_OK) {
                    $mail->addAttachment($tmp_name, $_FILES['business_img']['name'][$key]);
                }
            }
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Vendor Application Submission'; // Updated subject to be more specific
        $mail->Body = '
<html>
    <head></head>
    <body>
        <div style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6;">
            <p>Dear Admin,</p>

            <p>I hope this message finds you well. My name is ' . htmlspecialchars($owner) . ', and I am the owner of ' . htmlspecialchars($business_name) . '. I am writing to formally submit my application to join your platform as a vendor. Below are the details of my business:</p>

            <p>
                <strong>Business Name:</strong> ' . htmlspecialchars($business_name) . '<br>
                <strong>Owner:</strong> ' . htmlspecialchars($owner) . '<br>
                <strong>Contact Number:</strong> ' . htmlspecialchars($contact_number) . '<br>
                <strong>Email:</strong> ' . htmlspecialchars($gmail) . '<br>
                <strong>Location:</strong> ' . htmlspecialchars($street) . ', ' . htmlspecialchars($city) . ', ' . htmlspecialchars($province) . ', ' . htmlspecialchars($region) . '<br>
            </p>

            <p>Attached to this email are copies of our Business Permit, Menu, and some images related to our business. We believe that our offerings will be a valuable addition to your platform, and we are excited about the possibility of partnering with you.</p>

            <p>Thank you for considering our application. Please feel free to contact me at ' . htmlspecialchars($contact_number) . ' or via email at ' . htmlspecialchars($gmail) . ' if you require any additional information.</p>

            <p>Best regards,</p>
            <p>' . htmlspecialchars($owner) . '<br>' . htmlspecialchars($business_name) . '</p>
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