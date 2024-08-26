<?php

require_once '../../../config/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// For email notification
require '../../../assets/vendor/PHPMailer-master/src/Exception.php';
require '../../../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../../../assets/vendor/PHPMailer-master/src/SMTP.php';

if (isset($_POST['transactionNo']) && isset($_POST['status']) && isset($_POST['client_id']) && isset($_POST['tax']) && isset($_POST['user_id']) && isset($_POST['total_price']) && isset($_POST['balance_paid'])) {
    // Get the transaction number and status from the POST data
    $transactionNo = $_POST['transactionNo'];
    $status = $_POST['status'];
    $client_id = $_POST['client_id'];
    $tax = $_POST['tax'];
    $user_id = $_POST['user_id'];
    $revenue = $_POST['total_price'];
    $balance_paid = $_POST['balance_paid'];
    try {

        // Prepare and execute the SQL query to update status and insert balance_paid
        $stmt = $DB_con->prepare("UPDATE tbl_orders SET status = :status, balance_paid = :balance_paid WHERE transactionNo = :transactionNo");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':balance_paid', $balance_paid);
        $stmt->bindParam(':transactionNo', $transactionNo);
        $stmt->execute();

        if ($stmt) {



            // Admin 10% tax collected
            $stmt2 = $DB_con->prepare("INSERT INTO tbladmin_taxcollected_stats (transactionNo, client_id, tax) VALUES (:transactionNo, :client_id, :tax)");
            $stmt2->bindParam(':transactionNo', $transactionNo);
            $stmt2->bindParam(':client_id', $client_id);
            $stmt2->bindParam(':tax', $tax);
            $stmt2->execute();

            // Client Revenue
            $stmt2 = $DB_con->prepare("INSERT INTO tblclient_revenue_stats (transactionNo, client_id, user_id, revenue) VALUES (:transactionNo, :client_id, :user_id, :revenue)");
            $stmt2->bindParam(':transactionNo', $transactionNo);
            $stmt2->bindParam(':client_id', $client_id);
            $stmt2->bindParam(':user_id', $user_id);
            $stmt2->bindParam(':revenue', $revenue);
            $stmt2->execute();


            if ($stmt2) {
                // Fetch the order details using the transaction number
                $query = $DB_con->prepare("SELECT A.transactionNo, A.status, A.event_date, A.cater, A.payment_selection, A.total_price, A.initial_payment, A.tax, A.total_price_with_tax, A.balance, B.payment_method, B.created_at, B.full_name,B.location, B.email, B.contact_number 
            FROM tbl_orders AS A
            LEFT JOIN tbl_userinformationorder AS B ON A.transactionNo = B.transactionNo 
            WHERE A.transactionNo = :transactionNo");
                $query->bindParam(':transactionNo', $transactionNo);
                $query->execute();
                $order = $query->fetch(PDO::FETCH_ASSOC);

                $new_balance = $balance_paid - $order['balance'];

                $new_balance = (float) $new_balance; // Cast $new_balance to float
                if ($order) {
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

                    $view_reservation_url = "http://localhost/caterspot/view-reservation-detail.php?transactionNo=$transactionNo&id=$client_id";

                    $mail2->Subject = 'Catering Reservation Transaction Completed ';
                    $mail_body = '
                                    <!DOCTYPE html>
                                    <html lang="en">
                                    <head>
                                        <meta charset="UTF-8">
                                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                        <title>Cater Reservation</title>
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
                                        .details-table {
                                            width: 100%;
                                            border-collapse: collapse;
                                        }
                                        .details-table th, .details-table td {
                                            border: 1px solid #dddddd;
                                            padding: 8px;
                                            text-align: left;
                                        }
                                        .details-table th {
                                            background-color: #f2f2f2;
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
                                                <p>Thank you for choosing ' . htmlspecialchars($order['cater']) . '. Transaction Summary:</p>

                                                <table class="details-table">
                                                <tr>
                                                    <th>Transaction ID</th>
                                                    <td>' . $transactionNo . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <td>' . htmlspecialchars($order['full_name']) . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Contact Number</th>
                                                    <td>' . htmlspecialchars($order['contact_number']) . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Email</th>
                                                    <td>' . htmlspecialchars($order['email']) . '</td>
                                                </tr>
                                                <tr>
                                                <th>Customer Location</th>
                                                    <td>' . htmlspecialchars($order['location']) . '</td>
                                                </tr>
                                                <tr>
                                                <th>Status</th>
                                                    <td>' . $status . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <td>' . htmlspecialchars($order['payment_method']) . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Selected Payment</th>
                                                    <td>' . htmlspecialchars($order['payment_selection']) . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Price</th>
                                                    <td>Php ' . htmlspecialchars($order['total_price']) . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Initial Payment</th>
                                                    <td>Php ' . htmlspecialchars($order['initial_payment']) . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Amount Tendered</th>
                                                    <td>Php ' . $balance_paid . '</td>
                                                </tr>
                                                <tr>
                                                    <th>New Balance</th>
                                                    <td>Php 0.00</td>
                                                    </tr>';

                                                    // Conditional part
                                                    if ($new_balance > 0) {
                                                        $mail_body .= '
                                                                        <tr>
                                                                            <th>Change</th>
                                                                            <td>Php ' . $new_balance . '</td>
                                                                        </tr>';
                                                    }
                                                
                                                    // End of the email body
                                                    $mail_body .= '
                                                                    </table>
                                                                    <br>
                                                                    <p>We value your feedback and would love to hear about your experience with our service.</p>
                                                                    <div class="button-container">
                                                                        <a href="' . htmlspecialchars($view_reservation_url) . '" class="view-button" style="color:white;">Provide Feedback</a>
                                                                    </div>
                                                                </div>
                                                                <div class="email-footer">
                                                                    &copy; 2024 CaterSpot
                                                                </div>
                                                            </div>
                                                        </body>
                                                        </html>';

                                                        $mail2->Body = $mail_body;

                    if ($mail2->send()) {
                        $success = 'Transaction successfully completed.';
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