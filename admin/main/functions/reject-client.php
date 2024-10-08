<?php

require_once '../../../config/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// For email notification
require '../../../assets/vendor/PHPMailer-master/src/Exception.php';
require '../../../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../../../assets/vendor/PHPMailer-master/src/SMTP.php';

if (isset($_POST['client_id']) && isset($_POST['status']) && isset($_POST['remarks'])) {
    // Get the client ID, status, and remarks from the POST data
    $client_id = $_POST['client_id'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Validate remarks
    if (empty(trim($remarks))) {
        $msg = 'Please enter remarks.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    try {
        // Prepare and execute the SQL query to update status and remarks
        $stmt = $DB_con->prepare("UPDATE tbl_applications SET status = :status, remarks = :remarks WHERE client_id = :client_id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':remarks', $remarks);
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
                // Send Email to Client
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

                $mail2->Subject = 'Application Status Update: Rejected';
                $mail2->Body = '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Application Status Update</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                margin: 0;
                                padding: 0;
                            }
                            .email-container {
                                max-width: 600px;
                                margin: auto;
                                background-color: #ffffff;
                                padding: 20px;
                                border: 1px solid #dddddd;
                            }
                            .email-header {
                                background-color: #d9534f;
                                color: white;
                                padding: 10px;
                                text-align: center;
                                font-size: 24px;
                            }
                            .email-body {
                                padding: 20px;
                            }
                            .email-footer {
                                background-color: #d9534f;
                                color: white;
                                text-align: center;
                                padding: 10px;
                            }
                            .button-container {
                                text-align: center;
                                margin-top: 20px;
                            }
                            .view-button {
                                background-color: #d9534f;
                                color: white;
                                padding: 10px 20px;
                                text-decoration: none;
                                border-radius: 5px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="email-container">
                            <div class="email-header">
                                Application Status Update
                            </div>
                            <div class="email-body">
                                <p>Dear ' . htmlspecialchars($client['owner']) . ',</p>
                                <p>We regret to inform you that your application has been <strong>rejected</strong>.</p>
                                <p><strong>Remarks:</strong> ' . htmlspecialchars($remarks) . '</p>
                                <p>We appreciate your interest in our services. If you have any questions or require further clarification, please do not hesitate to contact us.</p>
                            </div>
                            <div class="email-footer">
                                &copy; 2024 CaterSpot
                            </div>
                        </div>
                    </body>
                    </html>
                ';

                if ($mail2->send()) {
                    $success = 'Application rejected and notification sent successfully.';
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
        // Output an error message as JSON if the query fails
        echo json_encode(['error' => 'Error rejecting request: ' . $e->getMessage()]);
    }
} else {
    // Output an error message as JSON if client ID, status, or remarks is not provided
    echo json_encode(['error' => 'Client ID, status, or remarks not provided.']);
}
?>
