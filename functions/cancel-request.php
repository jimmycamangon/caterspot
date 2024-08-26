<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// For email notif
require '../assets/vendor/PHPMailer-master/src/Exception.php';
require '../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../assets/vendor/PHPMailer-master/src/SMTP.php';

require_once '../config/conn.php';



if (isset($_POST['transactionNo']) && isset($_POST['status']) && isset($_POST['remarks'])) {
    // Get the transaction number, status, and remarks from the POST data
    $transactionNo = $_POST['transactionNo'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Validate remarks
    if (empty(trim($remarks))) {
        $msg = 'Please enter reason';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    try {
        // Prepare and execute the SQL query to update status and remarks
        $stmt = $DB_con->prepare("UPDATE tbl_orders SET status = :status, remarks = :remarks , is_read = 0 WHERE transactionNo = :transactionNo");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':remarks', $remarks);
        $stmt->bindParam(':transactionNo', $transactionNo);
        if ($stmt->execute()) {
            // Fetch the order details using the transaction number
            $query = $DB_con->prepare("SELECT A.transactionNo, A.status, A.event_date, A.cater, B.created_at, B.full_name, D.email, B.contact_number, C.client_id FROM tbl_orders AS A 
            LEFT JOIN tbl_userinformationorder AS B ON A.transactionNo = B.transactionNo 
            LEFT JOIN tblclient_settings AS C ON A.cater = C.cater_name 
            LEFT JOIN tbl_clients AS D ON C.client_id = D.client_id
            WHERE A.transactionNo = :transactionNo");
                                       
            $query->bindParam(':transactionNo', $transactionNo);
            $query->execute();
            $order = $query->fetch(PDO::FETCH_ASSOC);

            if ($order) {

                $client_cater_id = $order['client_id'];
                // Send Email to Client / Cater
                $mail2 = new PHPMailer();
                $mail2->isSMTP();
                $mail2->Host = 'smtp.gmail.com';
                $mail2->SMTPAuth = true;
                $mail2->Username = 'lucaterspot@gmail.com';
                $mail2->Password = 'swab lgbd bufz sagd';
                $mail2->SMTPSecure = 'tls';
                $mail2->Port = 587;

                $mail2->setFrom('lucaterspot@gmail.com', 'CaterSpot');
                $mail2->addAddress($order['email']);
                $mail2->isHTML(true);

                $view_reservation_url = "http://localhost/caterspot/client/main/reservation-details.php?transactionNo=$transactionNo&id=$client_cater_id";

                $mail2->Subject = 'Cater Reservation Request for Cancellation';
                $mail2->Body = '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Cater Reservation Rejected</title>
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
                                background-color: #2487ce;
                                color: white;
                                padding: 10px;
                                text-align: center;
                                font-size: 24px;
                            }
                            .email-body {
                                padding: 20px;
                            }
                            .email-footer {
                                background-color: #2487ce;
                                color: white;
                                text-align: center;
                                padding: 10px;
                            }
                            .button-container {
                                text-align: center;
                                margin-top: 20px;
                            }
                            .view-button {
                                background-color: #2487ce;
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
                                Cater Reservation Updated Status
                            </div>
                            <div class="email-body">
                                <p>Dear ' . htmlspecialchars($order['cater']) . ',</p>
                                <p>' . htmlspecialchars($remarks) . '</p>
                                <br>
                                <p><strong>Customer Name: </strong> ' . htmlspecialchars($order['full_name']) . '</p>
                                <p><strong>Customer Contact Number: </strong> ' . htmlspecialchars($order['contact_number']) . '</p>
                                <p><strong>Transaction Number:</strong> ' . htmlspecialchars($transactionNo) . '</p>
                                <p><strong>Status:</strong> ' . htmlspecialchars($status) . '</p>
                                <div class="button-container">
                                    <a href="' . htmlspecialchars($view_reservation_url) . '" class="view-button" style="color:white;">View Reservation Details</a>
                                </div>
                            </div>
                            <div class="email-footer">
                                &copy; 2024 CaterSpot
                            </div>
                        </div>
                    </body>
                    </html>
                ';
                if ($mail2->send()) {
                    // Output a success message as JSON
                    echo json_encode(['success' => 'Successfully Requested for Cancellation']);
                } else {
                    echo json_encode(['error' => 'Email sending failed.']);
                }
            } else {
                echo json_encode(['error' => 'Order not found.']);
            }
        } else {
            echo json_encode(['error' => 'Database update failed.']);
        }
    } catch (PDOException $e) {
        // Output an error message as JSON if the query fails
        echo json_encode(['error' => 'Error rejecting request: ' . $e->getMessage()]);
    }
} else {
    // Output an error message as JSON if transactionNo, status, or remarks is not provided
    echo json_encode(['error' => 'Transaction number, status, or remarks not provided']);
}
?>