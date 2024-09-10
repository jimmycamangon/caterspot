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



    // DATABASE

    // Generate a unique client ID
    $client_id = mt_rand(10000, 99999);

    // Directory for uploads
    $uploadDir = '../assets/img/client-applications/';

    // Save file paths
    $permitPaths = [];
    $menuPaths = [];
    $businessImgPaths = [];

    // Upload and save permit files
    if (isset($_FILES['permit'])) {
        foreach ($_FILES['permit']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['permit']['error'][$key] == UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . basename($_FILES['permit']['name'][$key]);
                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($tmp_name, $filePath)) {
                    $permitPaths[] = $filePath;
                }
            }
        }
    }

    // Upload and save menu files
    if (isset($_FILES['menu'])) {
        foreach ($_FILES['menu']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['menu']['error'][$key] == UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . basename($_FILES['menu']['name'][$key]);
                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($tmp_name, $filePath)) {
                    $menuPaths[] = $filePath;
                }
            }
        }
    }

    // Upload and save business image files
    if (isset($_FILES['business_img'])) {
        foreach ($_FILES['business_img']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['business_img']['error'][$key] == UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . basename($_FILES['business_img']['name'][$key]);
                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($tmp_name, $filePath)) {
                    $businessImgPaths[] = $filePath;
                }
            }
        }
    }

    // Convert file paths to JSON for storage
    $permit = json_encode($permitPaths);
    $menu = json_encode($menuPaths);
    $business_img = json_encode($businessImgPaths);
    $status = 'Pending';

    // Prepare SQL statement to insert data into tbl_applications
    $sqlInsert = 'INSERT INTO tbl_applications (business_name, owner, contact_number, gmail, region, province, city, street, permit, menu, business_img, client_id, status) 
               VALUES (:business_name, :owner, :contact_number, :gmail, :region, :province, :city, :street, :permit, :menu, :business_img, :client_id, :status)';

    $stmtInsert = $DB_con->prepare($sqlInsert);
    $stmtInsert->bindParam(':business_name', $business_name, PDO::PARAM_STR);
    $stmtInsert->bindParam(':owner', $owner, PDO::PARAM_STR);
    $stmtInsert->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
    $stmtInsert->bindParam(':gmail', $gmail, PDO::PARAM_STR);
    $stmtInsert->bindParam(':region', $region, PDO::PARAM_STR);
    $stmtInsert->bindParam(':province', $province, PDO::PARAM_STR);
    $stmtInsert->bindParam(':city', $city, PDO::PARAM_STR);
    $stmtInsert->bindParam(':street', $street, PDO::PARAM_STR);
    $stmtInsert->bindParam(':permit', $permit, PDO::PARAM_STR);
    $stmtInsert->bindParam(':menu', $menu, PDO::PARAM_STR);
    $stmtInsert->bindParam(':business_img', $business_img, PDO::PARAM_STR);
    $stmtInsert->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmtInsert->bindParam(':status', $status, PDO::PARAM_INT);

    // Execute the insert statement
    try {
        $stmtInsert->execute();
        // echo 'Application successfully recorded in the database.';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }


    // // EMAIL



    $email = 'lucaterspot@gmail.com';

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
        $mail->setFrom($gmail, $owner); // Sender's email and name
        $mail->addAddress($email, 'Admin'); // Recipient's email and name

        // Attach Business Permit files from client-uploads
        if (!empty($permitPaths)) {
            foreach ($permitPaths as $permitPath) {
                $mail->addAttachment($permitPath);
            }
        }

        // Attach Menu files from client-uploads
        if (!empty($menuPaths)) {
            foreach ($menuPaths as $menuPath) {
                $mail->addAttachment($menuPath);
            }
        }

        // Attach Business Image files from client-uploads
        if (!empty($businessImgPaths)) {
            foreach ($businessImgPaths as $imgPath) {
                $mail->addAttachment($imgPath);
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
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // Return error if any field is missing
    echo "Error: All fields are required.";
}


?>