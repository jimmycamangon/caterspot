<?php

require_once '../../../config/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// For email notification
require '../../../assets/vendor/PHPMailer-master/src/Exception.php';
require '../../../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../../../assets/vendor/PHPMailer-master/src/SMTP.php';

if (isset($_POST['client_id']) && isset($_POST['status'])) {
    // Get the client ID and status from the POST data
    $client_id = $_POST['client_id'];
    $status = $_POST['status'];

    try {
        // Prepare and execute the SQL query to update status
        $stmt = $DB_con->prepare("UPDATE tbl_applications SET status = :status WHERE client_id = :client_id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':client_id', $client_id);

        if ($stmt->execute()) {
            // Fetch the client details using the client ID
            $query = $DB_con->prepare("SELECT A.*
                                       FROM tbl_applications AS A
                                       WHERE A.client_id = :client_id");
            $query->bindParam(':client_id', $client_id);
            $query->execute();
            $client = $query->fetch(PDO::FETCH_ASSOC);

            if ($client) {
                $subject = 'Application Status Update';

                // Send Email to Client / Cater
                $mail2 = new PHPMailer();
                $mail2->isSMTP();
                $mail2->Host = 'smtp.gmail.com';
                $mail2->SMTPAuth = true;
                $mail2->Username = 'lucaterspot@gmail.com';
                $mail2->Password = 'qaat pzqc chtx ffvx';
                $mail2->SMTPSecure = 'tls';
                $mail2->Port = 587;

                $mail2->setFrom('lucaterspot@gmail.com', 'CaterSpot');
                $mail2->addAddress($client['gmail']);
                $mail2->isHTML(true);

                $mail2->Subject = $subject;
                $mail2->Body = '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>CaterSpot Application Status Update</title>
                    </head>
                    <body>
                        <div style="font-family: Arial, sans-serif; line-height: 1.6;">
                            <div style="padding: 20px; border-bottom: 1px solid #ddd;">
                                <h2>CaterSpot Application Status Update</h2>
                            </div>
                            <div style="padding: 20px;">
                                <p>Dear ' . htmlspecialchars($client['owner']) . ',</p>
                                <p>We are pleased to inform you that your application has been approved. Our team will reach out to you shortly to discuss the next steps and finalize the necessary agreements. Should you have any questions in the meantime, please feel free to contact us.</p>
                                <p>As part of our commitment to security, we kindly request that you update your temporary password as soon as possible by accessing your profile settings. This will help safeguard your account and ensure the integrity of your information.</p>
                                <p>Thank you for choosing CaterSpot.</p>
                            </div>
                            <div style="padding: 20px; border-top: 1px solid #ddd; text-align: center;">
                                <p>&copy; 2024 CaterSpot. All rights reserved.</p>
                            </div>
                        </div>
                    </body>
                    </html>
            ';


                if ($mail2->send()) {
                    $success = 'Application successfully approved.';
                    echo json_encode(['success' => $success]);
                } else {
                    echo json_encode(['error' => 'Email sending failed.']);
                }
            } else {
                echo json_encode(['error' => 'Client not found.']);
            }
        } else {
            echo json_encode(['error' => 'Database update failed.']);
        }
    } catch (PDOException $e) {
        // Output an error message if the query fails
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Output an error message if client ID or status is not set
    echo json_encode(['error' => 'Client ID or status not provided']);
}
?>