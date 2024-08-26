<?php
include_once 'functions/fetch-pendings.php';
include_once 'functions/fetch-completed.php';
include_once 'functions/fetch-booked.php';
include_once 'functions/fetch_reject_cancel.php';
require_once 'functions/sessions.php';


redirectToLogin();
$transactionNo = isset($_GET['transactionNo']) ? $_GET['transactionNo'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$transactionNo) {
    header("Location: reservations.php");
}

if (!empty($id)) {
    if($_SESSION['client_id'] != $id) {
        header("Location: logout.php");
        exit(); 
    }
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CaterSpot</title>
    <!-- Favicons -->
    <link href="../../assets/img/favicon.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../vendor/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <!-- Toastify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.js"
        integrity="sha512-0M1OKuNQKhBhA/vqxH7OaS1LZlDwSrSbL3QzcmrlNbkWV0U4ewn8SWfVuRS5nLGV9IXsuNnkdqzyXOYXc0Eo9w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.css"
        integrity="sha512-1xBbDQd2ydreJtocowqI+QS+xYVYdv96rB4xu/Peb5uD3SEtCJkGjnMCV3m8oH7XW35KsjqcTR6AytS5H8h8NA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.min.css"
        integrity="sha512-RJJdSTKOf+e0vTbZvyS5JTWtIBNC44IDUbkH8IF3MkJUP+YfLcK3K2nlxLS8V98m407CUgBdQrbcyRihb9e5gQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.min.js"
        integrity="sha512-DxteqSgafF6N5gacKCDX24qeqrYjuzdxQ5pNdmDLd1eJ6gibN7tlo7UD2+9qv1+8+Tu/uiYMdCuvHXlwTwZ+Ew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

</head>

<body class="sb-nav-fixed">
    <?php require_once 'includes/top-nav.php'; ?>
    <div id="layoutSidenav">
        <?php require_once 'includes/left-nav.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <br>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php" class="link-ref">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reservation Details</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-user"></i>&nbsp;
                                <b>Customer Reservation Details</b>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-center">
                            <div class="container reservation-con">
                                <div class="row gy-4">
                                    <div class="col-lg-8 package-menu-parent p-4">

                                        <?php
                                        // Fetch package data based on the provided package name
                                        $transactionNo = isset($_GET['transactionNo']) ? $_GET['transactionNo'] : '';
                                        $client_id = $_SESSION['client_id'];
                                        // Fetch data from the database
                                        $stmt = $DB_con->prepare("SELECT B.*, C.*, D.package_name,  E.cater_name, E.cater_location, E.cater_contactno
                                        FROM tbl_orders AS B 
                                        LEFT JOIN tbl_userinformationorder AS C ON B.transactionNo = C.transactionNo
                                        LEFT JOIN tbl_packages AS D ON C.package_id = D.package_id
                                        LEFT JOIN tblclient_settings AS E ON B.cater = E.cater_name
                                        WHERE  C.transactionNo = :transactionNo AND E.client_id = :client_id");

                                        $stmt->bindParam(':client_id', $client_id);
                                        $stmt->bindParam(':transactionNo', $transactionNo);
                                        $stmt->execute();
                                        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($orders as $order) {
                                            // Deserialize the selected_items column value into an array
                                            $selectedItemsSerialized = $order['selected_items'];
                                            // Extract the JSON string from the serialized data using regular expressions
                                            preg_match('/s:\d+:"(.*?)";/', $selectedItemsSerialized, $matches);
                                            $selectedItemsJSON = $matches[1];

                                            // Unserialize the JSON string into an array
                                            $selectedItemsArray = json_decode($selectedItemsJSON, true);

                                            // Output the selected items
                                            echo "<h5 style='color: #2487ce;'><b>Details:</b></h5>";
                                            echo "<div class='menu-details-container'>";

                                            foreach ($selectedItemsArray as $menu) {
                                                // Fetch the menu details based on the menu ID
                                                $menu_id = $menu['menu_id'];
                                                $quantity = $menu['quantity'];
                                                // Fetch the menu details based on the menu ID
                                                $stmt = $DB_con->prepare("SELECT A.menu_id, A.menu_name, A.menu_price ,A.menu_image, A.menu_description
                                                FROM tbl_menus AS A 
                                                WHERE A.menu_id = :menu_id");
                                                $stmt->bindParam(':menu_id', $menu_id);
                                                $stmt->execute();
                                                $menu = $stmt->fetch(PDO::FETCH_ASSOC);

                                                // Output menu details
                                                if ($menu) {
                                                    echo "<div class='menu-item'>";
                                                    echo '<div class="col-lg-8 col-md-12 d-lg-flex gy-4">';
                                                    echo '<a href="../../assets/img/menu-uploads/' . $menu['menu_image'] . '" class="glightbox menu-img" data-glightbox="gallery">';
                                                    echo "<img src='../../assets/img/menu-uploads/" . $menu['menu_image'] . "'  class='img-details'>";
                                                    echo '</a>&nbsp;&nbsp;&nbsp;&nbsp;';

                                                    echo "<div class='menu-info'><br>";
                                                    echo "<h5 class='menu-name'>" . $order['package_name'] . " - " . $menu['menu_name'] . "</h5>";
                                                    echo "<p class='menu-desc'>" . $menu['menu_description'] . "</p>";
                                                    echo "<p class='menu-price'><b>Price:</b> " . $menu['menu_price'] . "PHP | <b>Quantity:</b> " . $quantity . "</p>";
                                                    echo "</div>";
                                                    echo "</div>"; // Close menu-info div
                                                    echo "</div>"; // Close menu-item div
                                                } else {
                                                    echo "<p class='menu-not-found'>Menu with ID " . $menu_id . " not found.</p>";
                                                }
                                            }

                                            echo "</div>"; // Close menu-details-container div
                                        }

                                        ?>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="package-info">
                                            <h5 style="color: #2487ce;font-weight:bold;">Customer Information:</h5>
                                            <?php
                                            foreach ($orders as $order) {
                                                // Output menu details
                                                if ($order) {
                                                    echo "<div class='reservation-item'>";
                                                    echo "<div class='reservation-info'>";
                                                    echo "<span class='reservation-name'><b>Full name: </b>&nbsp;" . $order['full_name'] . "</span><br>";
                                                    echo "<span class='reservation-name'><b>Contact Number: </b>&nbsp;" . $order['contact_number'] . "</span><br>";
                                                    echo "<span class='reservation-name'><b>Email: </b>&nbsp;" . $order['email'] . "</span><br>";
                                                    echo "<span class='reservation-name'><b>Location: </b>&nbsp;" . $order['location'] . "</span><br>";
                                                    echo "<span class='reservation-name'><b>Payment Method: </b>&nbsp;" . $order['payment_method'] . " | " . $order['payment_selection'] . "</span><br><hr>";
                                                    echo "<span class='reservation-name'><b>No. of attendees: </b>&nbsp;" . $order['attendees'] . "</span><br>";
                                                    echo "<span class='reservation-name'><b>Event Date: </b>&nbsp;" . $order['event_date'] . "</span><br>";
                                                    echo "<span class='reservation-name'><b>Event Duration: </b>&nbsp;" . $order['event_duration'] . " Hours</span><br>";
                                                    echo "<span class='reservation-name'><b>Time Schedule: </b>&nbsp;" . date('h:i A', strtotime($order['From'])) . " - " . $order['To'] . "</span><br>";

                                                    if ($order['payment_method'] == "Gcash") {
                                                        echo "<span class='reservation-name'><b>Gcash Receipt: </b>&nbsp;<img src=../../assets/img/gcash-receipt-uploads/" . $order['upload_image'] . " class='glightboxs' data-glightboxs='gallery' style='width:50px;cursor:pointer;border-radius:0.5em;'><br><hr>";
                                                    }


                                                    echo "</div>";
                                                    echo "</div><br>";
                                                } else {
                                                    echo "<p class='menu-not-found'>Customer with ID " . $menu_id . " not found.</p>";
                                                }
                                            }

                                            ?>

                                            <h5 style="color: #2487ce;font-weight:bold;">Payment Summary:</h5>
                                            <?php

                                            foreach ($orders as $order) {


                                                // Output menu details
                                                if ($order) {
                                                    echo "<div class='reservation-item'>";
                                                    echo "<div class='reservation-info'>";

                                                    foreach ($selectedItemsArray as $menu) {
                                                        // Fetch the menu details based on the menu ID
                                                        $menu_id = $menu['menu_id'];
                                                        $quantity = $menu['quantity'];
                                                        $menuName = $menu['menuName'];
                                                        $menuPrice = $menu['price'];
                                                        // Fetch the menu details based on the menu ID
                                                        $stmt = $DB_con->prepare("SELECT A.menu_id, A.menu_name, A.menu_price ,A.menu_image, A.menu_description
                                                        FROM tbl_menus AS A 
                                                        WHERE A.menu_id = :menu_id");
                                                        $stmt->bindParam(':menu_id', $menu_id);
                                                        $stmt->execute();
                                                        $menu = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        // Output menu details
                                                        if ($menu) {
                                                            $sum = $menuPrice * $quantity;
                                                            echo "<span class='payment-name'>" . $menuName . ' - x' . $quantity . "<span>₱ " . $sum . "</span></span>";
                                                        } else {
                                                            echo "<p class='menu-not-found'>Menu with ID " . $menu_id . " not found.</p>";
                                                        }
                                                    }


                                                    echo "<br><span class='payment-name'><b>Subtotal: </b>&nbsp;₱ " . $order['total_price'] . "</span>";
                                                    echo "<span class='payment-name'><b>Revenue: <i class='fa-solid fa-circle-info' style='color:#2487ce;cursor:pointer;' data-toggle='modal' data-target='#paymentinfoModal' data-dismiss='modal'  title='Gcash (Image Receipt) | Walkin (Generated Receipt)'></i> </b>&nbsp; + ₱ " . $order['tax'] . "</span>";
                                                    echo "<span class='payment-name'><b>Grand Total: </b>&nbsp;<b>₱ " . $order['total_price_with_tax'] . "</b></span>";
                                                    if ($order['initial_payment'] > 0 || $order['balance']) {
                                                        echo "<hr><span class='payment-name'><span>Initial Payment: </span>&nbsp;<span>- ₱ " . $order['initial_payment'] . "</span></span>";
                                                        if ($order['status'] == "Booked") {
                                                            echo "<span class='payment-name'><b>Balance Due: </b>&nbsp;<b>₱ " . $order['balance'] . "</b></span>";
                                                            echo "<div class='form-group'>";
                                                            echo "<div class='alert alert-danger' id='message' role='alert' style='display:none'></div>";
                                                            echo "<div class='row'>";
                                                            echo "<div class='col'>";
                                                            echo "<label for='balance_paid'>Balance to be paid:</label>";
                                                            echo "<input type='number' class='form-control' name='balance_paid' id='balance_paid'  oninput='validateBalance()'>";
                                                            echo "</div>";
                                                            echo "<div class='col'></div>";
                                                            echo "</div>";
                                                            echo "</div>";
                                                        } else if ($order['status'] == "Pending") {
                                                            echo "<span class='payment-name'><b>Balance Due: </b>&nbsp;<b>₱ " . $order['balance'] . "</b></span>";

                                                        } else if ($order['status'] == "Completed") {
                                                            echo "<span class='payment-name'>Previous Balance: &nbsp;<span>₱ " . $order['balance'] . "</span></span>";
                                                            echo "<span class='payment-name'>Amount Tendered: &nbsp;<span>₱ " . $order['balance_paid'] . "</span></span>";

                                                            $new_balance = number_format(($order['balance_paid'] - $order['balance']), 2);



                                                            echo "<span class='payment-name'><b>New Balance: </b>&nbsp;<b>₱ 0.00</b></span>";
                                                            if ($new_balance > 0) {
                                                                echo "<span class='payment-name'><b>Change: </b>&nbsp;<b>₱ " . $new_balance . "</b></span>";
                                                            }
                                                        }
                                                    }

                                                    echo "</div>";
                                                    echo "</div>";
                                                } else {
                                                    echo "<p class='menu-not-found'>Customer with ID " . $menu_id . " not found.</p>";
                                                }
                                            }
                                            ?>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    validateBalance();
                                                });

                                                // Validation input balance
                                                function validateBalance() {
                                                    var balancePaidInput = document.getElementById('balance_paid');
                                                    var messageDiv = document.getElementById('message');
                                                    var setCompletedButton = document.getElementById('setCompletedButton');

                                                    if (balancePaidInput && balancePaidInput.offsetParent !== null) {
                                                        var balancePaid = balancePaidInput.value;
                                                        var balanceDue = <?php echo $order['balance']; ?>;

                                                        if (parseFloat(balancePaid) < parseFloat(balanceDue) || balancePaid === "0" || balancePaid.trim() === "") {
                                                            messageDiv.innerHTML = "Please enter a payment amount equal to or greater than the balance due.";
                                                            messageDiv.style.display = "block";
                                                            setCompletedButton.disabled = true;
                                                            setCompletedButton.style.opacity = 0.5; // Change button opacity
                                                            setCompletedButton.style.cursor = "not-allowed"; // Change cursor to not allowed
                                                        } else {
                                                            messageDiv.innerHTML = "";
                                                            messageDiv.style.display = "none";
                                                            setCompletedButton.disabled = false;
                                                            setCompletedButton.style.opacity = 1; // Reset button opacity
                                                            setCompletedButton.style.cursor = "pointer"; // Return cursor to normal
                                                        }
                                                    } else {
                                                        console.error("balance_paid input element is hidden.");
                                                    }
                                                }



                                            </script>
                                            <hr>
                                            <?php if ($order['status'] == "Request for cancel"): ?>
                                                <div class="alert alert-info" role="alert"><b>Reason of cancellation:
                                                    </b><?php echo $order['remarks']; ?>
                                                </div>
                                                <hr>
                                            <?php endif; ?>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div>
                                                    <?php foreach ($orders as $order) { ?>
                                                        <?php if ($order['status'] == "Pending") { ?>
                                                            <b>Status: </b><span
                                                                class="badge bg-warning text-dark"><?php echo $order['status']; ?></span>
                                                        <?php } else if ($order['status'] == "Booked") { ?>
                                                                <b>Status: </b><span
                                                                    class="badge bg-primary"><?php echo $order['status']; ?></span>
                                                        <?php } else if ($order['status'] == "Completed") { ?>
                                                                    <b>Status: </b><span
                                                                        class="badge bg-success"><?php echo $order['status']; ?></span>
                                                        <?php } else if ($order['status'] == "Rejected") { ?>
                                                                        <b>Status: </b><span
                                                                            class="badge bg-danger"><?php echo $order['status']; ?></span>
                                                        <?php } else if ($order['status'] == "Request for cancel") { ?>
                                                                            <b>Status: </b><span
                                                                                class="badge bg-danger"><?php echo $order['status']; ?></span>
                                                        <?php } else if ($order['status'] == "Request cancellation approved.") { ?>
                                                                                <b>Status: </b><span class="badge bg-success">Cancelled</span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <div style="display: flex; justify-content: flex-end;">
                                                    <?php foreach ($orders as $order) { ?>
                                                        <?php if ($order['status'] == "Pending") { ?>
                                                            <button type="button" class="btn-get-del" data-toggle="modal"
                                                                data-target="#confirmationDeleteModal"
                                                                data-dismiss="modal">Reject</button>
                                                            &nbsp;
                                                            <button type="button" class="btn-get-main" data-toggle="modal"
                                                                data-target="#confirmationProceedModal">Tag as Booked</button>
                                                        <?php } else if ($order['status'] == "Rejected") { ?>

                                                        <?php } else if ($order['status'] == "Booked") { ?>
                                                                    <button type="button" class="btn-get-main" data-toggle="modal"
                                                                        data-target="#setCompletedModal" id="setCompletedButton">Set as
                                                                        Completed</button>
                                                        <?php } else if ($order['status'] == "Request for cancel") { ?>
                                                                        <button type="button" class="btn-get-del" data-toggle="modal"
                                                                            data-target="#confirmationDeleteModal"
                                                                            data-dismiss="modal">Reject</button>
                                                                        &nbsp;
                                                                        <button type="button" class="btn-get-main" data-toggle="modal"
                                                                            data-target="#approveModal">Approve Cancellation</button>

                                                        <?php } else if ($order['status'] == "Completed") { ?>
                                                                            <button class="btn-generate-receipt btn-get-main"
                                                                                data-transaction-no="<?php echo $order['transactionNo']; ?>"><i
                                                                                    class='bx bxs-receipt' style="font-size:15px;"></i> &nbsp;
                                                                                Print
                                                                                Receipt</button>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>


                                            </div>
                                            <?php if ($order['status'] == "Request for cancel"): ?>
                                                <br>

                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Payment Info Modal -->
            <div class="modal fade" id="paymentinfoModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmationCompleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationCompleteModalLabel">
                                Payment Notice
                            </h5>
                            <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                                aria-label="Close"></i>
                        </div>
                        <div class="modal-body">
                            <p>Please note that a 2% deduction will be applied to your payment, with the revenue directed
                                to the system's/admin's financial resources.</p>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn-get-main" data-dismiss="modal">Back</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Complete Confirmation Modal -->
            <div class="modal fade" id="setCompletedModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmationCompleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationCompleteModalLabel">
                                Complete Transaction Confirmation
                            </h5>
                            <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                                aria-label="Close"></i>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to mark this transaction as complete? <br>Only confirm if you're
                                certain the transaction is finalized.</p>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn-get-del" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn-get-main" id="completeBtn">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approve Confirmation Modal -->
            <div class="modal fade" id="confirmationProceedModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmationProceedModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationProceedModalLabel">
                                Approve Confirmation
                            </h5>
                            <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                                aria-label="Close"></i>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to proceed?
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-get-del" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn-get-main" id="saveChangesBtn">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approve Cancellation Modal -->
            <div class="modal fade" id="approveModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmationCompleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationCompleteModalLabel">
                                Approve Confirmation
                            </h5>
                            <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                                aria-label="Close"></i>
                        </div>
                        <div class="modal-body">
                            <p>Are you certain you wish to approve the cancellation of this request?<br> Please note
                                that once approved, transactions cannot be reversed.</p>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn-get-del" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn-get-main" id="approveBtn">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Reject Confirmation Modal -->
            <div class="modal fade" id="confirmationDeleteModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmationDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationDeleteModalLabel">
                                Reject Confirmation
                            </h5>
                            <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                                aria-label="Close"></i>
                        </div>
                        <div class="modal-body">
                            <div id="message"></div>
                            Are you sure you want to reject this request? <br>If yes, kindly provide a reason.
                            <br>
                            <br>
                            <div class="form-group">
                                <label for="remarks">Remarks:</label>
                                <textarea class="form-control" id="remarks" name="remarks"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-get-del" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn-get-main" id="deleteRequest">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>


            <?php require_once 'includes/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <!-- Modal CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="functions/js/approve-status.js"></script>
    <script src="functions/js/reject-status.js"></script>
    <script src="functions/js/complete-status.js"></script>
    <script>
        $(document).ready(function () {
            $('#saveChangesBtn').click(function () {
                var transactionNo = '<?php echo $transactionNo; ?>';
                approveReservation(transactionNo);
            });


            $('#deleteRequest').click(function () {
                var transactionNo = '<?php echo $transactionNo; ?>';
                var remarks = $('#remarks').val(); // Get the value of the remarks textarea
                rejectReservation(transactionNo, remarks);
            });

            $('#completeBtn').click(function () {
                var transactionNo = '<?php echo $transactionNo; ?>';
                var client_id = '<?php echo $_SESSION['client_id']; ?>';
                var tax = '<?php echo $order['tax']; ?>';
                var user_id = '<?php echo $order['user_id']; ?>';
                var total_price = '<?php echo $order['total_price']; ?>';
                var balance_paid = $('#balance_paid').val(); // Get the value of balance_paid input
                completeReservation(transactionNo, client_id, tax, user_id, total_price, balance_paid); // Pass balance_paid to the function
            });
            $('#approveBtn').click(function () {
                var transactionNo = '<?php echo $transactionNo; ?>';
                approveCancellation(transactionNo);
            });
        });


        // Initialize GLightbox once when the document is ready
        const lightbox = GLightbox({
            selector: ".glightbox",
            touchNavigation: true,
            loop: true,
            closeOnOutsideClick: true,
            closeButton: true,
            slideEffect: "fade",
            openEffect: "fade",
            closeEffect: "fade",
            autoplayVideos: true,
            videoMaxWidth: 800,
            keyboardNavigation: true
        });

        // Initialize lightbox with custom configuration
        var lightbox2 = GLightbox({
            selector: '.glightboxs',
            loop: true, // Enable looping through images
            touchNavigation: true, // Enable touch navigation
            closeOnOutsideClick: true, // Close lightbox when clicking outside the content
            closeButton: true, // Show close button
            closeOnEscape: true, // Close lightbox when pressing the escape key
            autoplayVideos: true, // Autoplay YouTube/Vimeo videos
            plyr: {
                settings: ['quality', 'speed', 'loop'], // Customize Plyr settings
            },
        });




        $('.btn-generate-receipt').click(function () {
            var transactionNo = $(this).data('transaction-no');
            var fullName = encodeURIComponent("<?php echo $order['full_name']; ?>");
            var contactNumber = encodeURIComponent("<?php echo $order['contact_number']; ?>");
            var email = encodeURIComponent("<?php echo $order['email']; ?>");
            var location = encodeURIComponent("<?php echo $order['location']; ?>");
            var paymentMethod = encodeURIComponent("<?php echo $order['payment_method']; ?>");
            var payment_selection = encodeURIComponent("<?php echo $order['payment_selection']; ?>");
            var attendees = encodeURIComponent("<?php echo $order['attendees']; ?>");
            var eventDate = encodeURIComponent("<?php echo $order['event_date']; ?>");
            var eventDuration = encodeURIComponent("<?php echo $order['event_duration']; ?>");
            var subtotal = encodeURIComponent("<?php echo $order['total_price']; ?>");
            var tax = encodeURIComponent("<?php echo $order['tax']; ?>");
            var cater = encodeURIComponent("<?php echo $order['cater']; ?>");
            var cater_location = encodeURIComponent("<?php echo $order['cater_location']; ?>");
            var cater_contactno = encodeURIComponent("<?php echo $order['cater_contactno']; ?>");
            var grandTotal = encodeURIComponent("<?php echo $order['total_price_with_tax']; ?>");
            var initial_payment = encodeURIComponent("<?php echo $order['initial_payment']; ?>");
            var balance = encodeURIComponent("<?php echo $order['balance']; ?>");
            var balance_paid = encodeURIComponent("<?php echo $order['balance_paid']; ?>");
            var selected_items = encodeURIComponent('<?php echo $order['selected_items']; ?>');
            var client_image = encodeURIComponent('<?php echo $client_img; ?>');


            // Construct the URL with all parameters
            var url = 'generate_receipt_pdf.php?transaction_no=' + transactionNo +
                '&full_name=' + fullName +
                '&contact_number=' + contactNumber +
                '&email=' + email +
                '&location=' + location +
                '&payment_method=' + paymentMethod +
                '&payment_selection=' + payment_selection +
                '&attendees=' + attendees +
                '&event_date=' + eventDate +
                '&event_duration=' + eventDuration +
                '&subtotal=' + subtotal +
                '&tax=' + tax +
                '&cater=' + cater +
                '&cater_location=' + cater_location +
                '&cater_contactno=' + cater_contactno +
                '&grand_total=' + grandTotal +
                '&initial_payment=' + initial_payment +
                '&balance=' + balance +
                '&balance_paid=' + balance_paid +
                '&client_image=' + client_image +
                '&selected_items=' + selected_items;

            // Redirect to generate_receipt_pdf.php with all parameters
            window.location.href = url;
        });
    </script>


</body>

</html>