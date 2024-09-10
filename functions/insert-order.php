<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// For email notif
require '../assets/vendor/PHPMailer-master/src/Exception.php';
require '../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../assets/vendor/PHPMailer-master/src/SMTP.php';

// Include database connection
require_once '../config/conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect user to login page if not logged in
    header('Location: index.php#login');
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];
// Generate a random 10-digit transaction ID
$transaction_id = mt_rand(1000000, 9999999);

// Get data from POST request
$selectedItems = $_POST['selected_products'];
$totalPrice = $_POST['total_price'];
$tax = $_POST['tax'];
$totalPriceWithTax = $_POST['total_price_with_tax'];
$initial_payment = $_POST['initial_payment'];
$balance = $_POST['balance'];
$attendees = $_POST['attendeees'];
$cater = $_POST['cater'];
$client_cater_id = $_POST['client_cater_id'];
$cater_email = $_POST['cater_email'];
$package_id = $_POST['package_id'];
$event_date = $_POST['event_date']; // Retrieve event date from the form
$event_duration = $_POST['event_duration']; // Retrieve event duration from the form
$payment_method = $_POST['payment_method'];
$payment_selection = $_POST['payment_selections'];
$From = $_POST['From'];
$To = $_POST['End'];

// Serialize the array into a string before inserting into the database
$selectedItemsString = serialize($selectedItems);


// Check if the payment method is GCash
if ($payment_method === 'Gcash') {
    // Check if an image was uploaded
    if (!empty($_FILES['upload_image']['name'])) {
        // Handle file upload
        $upload_dir = '../assets/img/gcash-receipt-uploads/';
        $upload_file = $upload_dir . basename($_FILES['upload_image']['name']);

        if (move_uploaded_file($_FILES['upload_image']['tmp_name'], $upload_file)) {
            // File upload success
            $upload_image = basename($_FILES['upload_image']['name']);
        } else {
            // File upload error
            $upload_image = ''; // Set empty string if upload fails
        }
    } else {
        // No image uploaded for GCash payment method
        echo "Error: Please upload an image for GCash payment method.";
        exit();
    }
} else {
    // For Walk-In payment method or other methods that don't require an image
    $upload_image = ''; // Set empty string
}





// Insert data into tbl_orders table
$stmt1 = $DB_con->prepare("INSERT INTO tbl_orders (transactionNo, user_id, cater, package_id, selected_items, total_price, tax, total_price_with_tax, initial_payment, balance, attendees, event_date, event_duration, status, is_read, `From`, `To`, payment_selection) VALUES (:transaction_id, :user_id, :cater, :package_id, :selected_items, :total_price, :tax, :total_price_with_tax, :initial_payment, :balance, :attendees, :event_date, :event_duration, 'Pending', 0, :From, :To, :payment_selection)");

$stmt1->bindParam(':transaction_id', $transaction_id);
$stmt1->bindParam(':user_id', $user_id);
$stmt1->bindParam(':cater', $cater);
$stmt1->bindParam(':package_id', $package_id);
$stmt1->bindParam(':selected_items', $selectedItemsString); // Bind the serialized string
$stmt1->bindParam(':total_price', $totalPrice);
$stmt1->bindParam(':tax', $tax);
$stmt1->bindParam(':total_price_with_tax', $totalPriceWithTax);
$stmt1->bindParam(':initial_payment', $initial_payment);
$stmt1->bindParam(':balance', $balance);
$stmt1->bindParam(':attendees', $attendees);
$stmt1->bindParam(':event_date', $event_date); // Bind event date to the SQL query
$stmt1->bindParam(':event_duration', $event_duration); // Bind event duration to the SQL query
$stmt1->bindParam(':From', $From);
$stmt1->bindParam(':To', $To);
$stmt1->bindParam(':payment_selection', $payment_selection);


// Check if tbl_orders insertion is successful
if ($stmt1->execute()) {
    // Insert data into orders table
    $order_id = $DB_con->lastInsertId(); // Get the last inserted order ID

    // Insert data into orders table
    $stmt2 = $DB_con->prepare("INSERT INTO tbl_userinformationorder (id, user_id, transactionNo, package_id, full_name, contact_number, email, location, upload_image, payment_method) VALUES (:order_id, :user_id, :transaction_id, :package_id, :full_name, :contact_number, :email, :location, :upload_image, :payment_method)");

    // Bind parameters
    $stmt2->bindParam(':order_id', $order_id);
    $stmt2->bindParam(':user_id', $user_id);
    $stmt2->bindParam(':transaction_id', $transaction_id);
    $stmt2->bindParam(':package_id', $package_id);
    $stmt2->bindParam(':full_name', $_POST['full_name']);
    $stmt2->bindParam(':contact_number', $_POST['contact_number']);
    $stmt2->bindParam(':email', $_POST['email']);
    $stmt2->bindParam(':location', $_POST['location']);
    $stmt2->bindParam(':upload_image', $upload_image); // Bind the uploaded image filename
    $stmt2->bindParam(':payment_method', $payment_method);


    // Execute the query
    if ($stmt2->execute()) {

        // Send reservation confirmation email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lucaterspot@gmail.com';
        $mail->Password = 'qaat pzqc chtx ffvx';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('lucaterspot@gmail.com', 'CaterSpot');
        $mail->addAddress($_POST['email']);
        $mail->isHTML(true);

        $transaction_id = $transaction_id; // Ensure this variable is set correctly
        $view_reservation_url = "http://localhost/caterspot/view-reservation-detail.php?transactionNo=$transaction_id&id=$client_cater_id";

        $mail->Subject = 'Reservation Confirmation';
        $mail->Body = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/img/favicon.png" rel="icon">
        <title>Reservation Confirmation</title>
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
                CaterSpot Reservation Confirmation
            </div>
            <div class="email-body">
                <p>Dear Customer,</p>
                <p>Thank you for your reservation. Here are the summary of your reservation:</p>
                <table class="details-table">
                    <tr>
                        <th>Transaction ID</th>
                        <td>' . $transaction_id . '</td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>' . $_POST['full_name'] . '</td>
                    </tr>
                    <tr>
                        <th>Customer Contact Number</th>
                        <td>' . $_POST['contact_number'] . '</td>
                    </tr>
                    <tr>
                        <th>Customer Email</th>
                        <td>' . $_POST['email'] . '</td>
                    </tr>
                    <tr>
                    <th>Customer Location</th>
                        <td>' . $_POST['location'] . '</td>
                    </tr>
                    <tr>
                    <th>Status</th>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <th>Caterer</th>
                        <td>' . $cater . '</td>
                    </tr>
                    <tr>
                        <th>Event Date</th>
                        <td>' . $event_date . '</td>
                    </tr>
                    <tr>
                        <th>Reservation Date</th>
                        <td>'. date('Y-m-d H:i:s') . '</td>
                    </tr>
                    <tr>
                        <th>Event Duration</th>
                        <td>' . $event_duration . ' hours | ' . date('h:i A', strtotime($From)) . ' - ' . $To . '</td>
                    </tr>
                    <tr>
                        <th>Attendees</th>
                        <td>' . $attendees . '</td>
                    </tr>
                    <tr>
                        <th>Payment Method</th>
                        <td>' . $payment_method . '</td>
                    </tr>
                    <tr>
                        <th>Selected Payment</th>
                        <td>' . $payment_selection . '</td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td>Php ' . $totalPriceWithTax . '</td>
                    </tr>
                    <tr>
                        <th>Initial Payment</th>
                        <td>Php ' . $initial_payment . '</td>
                    </tr>
                    <tr>
                        <th>Balance</th>
                        <td>Php ' . $balance . '</td>
                    </tr>
                </table>
                <div class="button-container">
                    <a href="' . $view_reservation_url . '" style="color:white;" class="view-button">View Reservation Details</a>
                </div>
                <p>If you have any questions, please contact us at lucaterspot@gmail.com.</p>
                <p>Thank you for choosing CaterSpot!</p>
            </div>
            <div class="email-footer">
                &copy; 2024 CaterSpot
            </div>
        </div>
    </body>
    </html>
';



        if ($mail->send()) {


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
            $mail2->addAddress($cater_email);
            // Also send to $cater_email
            $mail2->isHTML(true);

            $transaction_id = $transaction_id;
            $view_reservation_url = "http://localhost/caterspot/client/main/reservation-details.php?transactionNo=$transaction_id&id=$client_cater_id";

            $mail2->Subject = 'Customer Request for Reservation';
            $mail2->Body = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Customer Request for Reservation</title>
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
                            Customer Reservation for Approval
                        </div>
                        <div class="email-body">
                            <p>Dear ' . $cater . ',</p>
                            <p>Customer ' . $_POST['full_name'] . ' is requesting for reservation, here are the summary of customer`s reservation:</p>
                            <table class="details-table">
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>' . $transaction_id . '</td>
                                </tr>
                                <tr>
                                    <th>Customer Name</th>
                                    <td>' . $_POST['full_name'] . '</td>
                                </tr>
                                <tr>
                                    <th>Customer Contact Number</th>
                                    <td>' . $_POST['contact_number'] . '</td>
                                </tr>
                                <tr>
                                <th>Customer Location</th>
                                    <td>' . $_POST['location'] . '</td>
                                </tr>
                                <tr>
                                    <th>Customer Email</th>
                                    <td>' . $_POST['email'] . '</td>
                                </tr>
                                <tr>
                                <th>Status</th>
                                    <td>Pending</td>
                                </tr>
                                <tr>
                                    <th>Event Date</th>
                                    <td>' . $event_date . '</td>
                                </tr>
                                <tr>
                                <th>Reservation Date</th>
                                    <td>'. date('Y-m-d H:i:s') . '</td>
                                </tr>
                                <tr>
                                    <th>Event Duration</th>
                                    <td>' . $event_duration . ' hours | ' . date('h:i A', strtotime($From)) . ' - ' . $To . '</td>
                                </tr>
                                <tr>
                                    <th>Attendees</th>
                                    <td>' . $attendees . '</td>
                                </tr>
                                <tr>
                                <th>Payment Method</th>
                                    <td>' . $payment_method . '</td>
                                </tr>
                                <tr>
                                    <th>Selected Payment</th>
                                    <td>' . $payment_selection . '</td>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <td>Php ' . $totalPriceWithTax . '</td>
                                </tr>
                                <tr>
                                    <th>Initial Payment</th>
                                    <td>Php ' . $initial_payment . '</td>
                                </tr>
                                <tr>
                                    <th>Balance</th>
                                    <td>Php ' . $balance . '</td>
                                </tr>
                            </table>
                            <div class="button-container">
                                <a href="' . $view_reservation_url . '" style="color:white;" class="view-button">View Reservation Details</a>
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
                // Redirect back to the page after successful insertion
                $_SESSION['successful_reservation'] = true;
                header('Location: ../my-reservations.php');

            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        echo "Error: Unable to insert data into orders table.";
    }


} else {
    echo "Error: Unable to insert data";
}

?>