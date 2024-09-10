<?php

require_once '../../../config/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// For email notification
require '../../../assets/vendor/PHPMailer-master/src/Exception.php';
require '../../../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../../../assets/vendor/PHPMailer-master/src/SMTP.php';

if (isset($_POST['transactionNo']) && isset($_POST['status'])) {
    // Get the transaction number and status from the POST data
    $transactionNo = $_POST['transactionNo'];
    $status = $_POST['status'];
    $client_cater_id = $_SESSION['client_id'];

    try {
        // Prepare and execute the SQL query to update status
        $stmt = $DB_con->prepare("UPDATE tbl_orders SET status = :status WHERE transactionNo = :transactionNo");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':transactionNo', $transactionNo);

        if ($stmt->execute()) {
            // Fetch the order details using the transaction number
            $query = $DB_con->prepare("SELECT A.transactionNo, A.status, A.event_date, A.cater, B.created_at, B.full_name, B.email, B.contact_number 
                                       FROM tbl_orders AS A
                                       LEFT JOIN tbl_userinformationorder AS B ON A.transactionNo = B.transactionNo 
                                       WHERE A.transactionNo = :transactionNo");
            $query->bindParam(':transactionNo', $transactionNo);
            $query->execute();
            $order = $query->fetch(PDO::FETCH_ASSOC);

            if ($order) {
                
                $subject = $order['status'] == 'Booked' ? 'Your Cater Reservation has been Booked' : 'Your request for cancellation has been Approved';

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
                $mail2->addAddress($order['email']);
                $mail2->isHTML(true);

                $view_reservation_url = "http://localhost/caterspot/view-reservation-detail.php?transactionNo=$transactionNo&id=$client_cater_id";

                $mail2->Subject = $subject;
                $mail2->Body = '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Cater Reservation Approved</title>
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
                                <p>Dear ' . htmlspecialchars($order['full_name']) . ',</p>
                                <p>' . $subject . '</p>
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
                    $success = 'Reservation successfully tagged as booked.';
                    echo json_encode(['success' => $success]);
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
        // Output an error message if the query fails
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Output an error message if transactionNo or status is not set
    echo json_encode(['error' => 'Transaction number or status not provided']);
}
?>
