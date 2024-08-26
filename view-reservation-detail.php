<?php
require_once 'config/conn.php';
require_once 'functions/fetch-user.php';
require_once 'functions/fetch-client.php';

$transactionNo = isset($_GET['transactionNo']) ? $_GET['transactionNo'] : '';
// Fetch data from the database
$checkUser = $DB_con->prepare("SELECT transactionNo, user_id FROM tbl_orders 
WHERE transactionNo  = :transactionNo");

$checkUser->bindParam(':transactionNo', $transactionNo);
$checkUser->execute();
$checkedUser = $checkUser->fetchAll(PDO::FETCH_ASSOC);

foreach ($checkedUser as $chchk) {



    if ($chchk['user_id'] != $_SESSION['user_id']) {
        header("Location: logout.php");
        exit();
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location:index.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>CaterSpot</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
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


    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="./">CaterSpot</a></h1>
            <nav id="navbar" class="navbar">
                <ul>
                    <li>
                        <?php if (isset($_SESSION['user_id'])) {
                            ?>
                        <li class="dropdown"><a href="#">
                                <?php echo $Userfullname; ?>
                            </a>
                            <ul>
                                <li><a class="nav-link scrollto" href="my-reservations.php">My Reservations</a></li>
                                <li><a href="profile.php">Edit Profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                        <?php
                        } ?>
                    </li>
                    <li>
                        <?php
                        $cater = isset($_GET['cater']) ? $_GET['cater'] : '';
                        if (empty($cater)) { ?>
                            <a class="getstarted scrollto" href="my-reservations.php"><i class='bx bx-arrow-back'></i>
                                Back</a>
                        <?php } else { ?>
                            <a class="getstarted scrollto" href="view.php?cater=<?php echo $cater; ?>"><i
                                    class='bx bx-arrow-back'></i> Back</a>
                        <?php } ?>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>
                        Reservation Details
                    </h2>
                    <ol>
                        <li><a href="./">Home</a></li>
                        <li>Reservation Details</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->

        <section id="hero" class="d-flex align-items-center" style="height:auto !important;">
            <div class="container"
                style="padding: auto !important; height:auto !important; padding-top:0px !important;">
                <div class="row gy-4">

                    <div class="col-lg-8 package-menu-parent p-4">
                        <?php
                        // Fetch package data based on the provided package name
                        $transactionNo = isset($_GET['transactionNo']) ? $_GET['transactionNo'] : '';

                        $user_id = $_SESSION['user_id'];

                        // Fetch data from the database
                        $stmt = $DB_con->prepare("SELECT B.*, C.*, D.package_name, E.cater_name, E.cater_location, E.cater_contactno FROM tbl_orders AS B 
                        LEFT JOIN tbl_userinformationorder AS C ON B.transactionNo = C.transactionNo 
                        LEFT JOIN tbl_packages AS D ON C.package_id = D.package_id 
                        LEFT JOIN tblclient_settings AS E ON B.cater = E.cater_name WHERE B.user_id = :user_id AND C.transactionNo = :transactionNo");

                        $stmt->bindParam(':user_id', $user_id);
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
                            echo "<h4 style='color: #2487ce;'><b>Menu Details:</b></h4>";
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
                                    echo '<a href="assets/img/menu-uploads/' . $menu['menu_image'] . '" class="glightbox" data-glightbox="gallery">';
                                    echo "<img src='assets/img/menu-uploads/" . $menu['menu_image'] . "'  class='img-details'>";
                                    echo '</a>';
                                    echo "<div class='menu-info'><br>";
                                    echo "<h4 class='menu-name'>" . $order['package_name'] . " - " . $menu['menu_name'] . "</h4>";
                                    echo "<p class='menu-desc'>" . $menu['menu_description'] . "</p>";
                                    echo "<p class='menu-price'><b>Price:</b> " . $menu['menu_price'] . "PHP | <b>Quantity:</b> " . $quantity . "</p>";
                                    // Add other menu details here as needed
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
                            <h3 style="color: #2487ce;">Customer Information:</h3>
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
                                    echo "<span class='reservation-name'><b>Payment Method: </b>&nbsp;" . $order['payment_method'] . " | " . $order['payment_selection'] . "</span><br>";
                                    if ($order['payment_method'] == "Gcash") {
                                        echo "<span class='reservation-name'><b>Gcash Receipt: </b>&nbsp;<img src=assets/img/gcash-receipt-uploads/" . $order['upload_image'] . " class='glightboxs' data-glightboxs='gallery' style='width:50px;cursor:pointer;border-radius:0.5em;'><br><hr>";
                                    }


                                    echo "<span class='reservation-name'><b>No. of attendees: </b>&nbsp;" . $order['attendees'] . "</span><br>";
                                    echo "<span class='reservation-name'><b>Event Date: </b>&nbsp;" . $order['event_date'] . "</span><br>";
                                    echo "<span class='reservation-name'><b>Event Duration: </b>&nbsp;" . $order['event_duration'] . " Hours</span><br>";
                                    echo "<span class='reservation-name'><b>Time Schedule: </b>&nbsp;" . date('h:i A', strtotime($order['From'])) . " - " . $order['To'] . "</span><br>";
                                    echo "</div>";
                                    echo "</div><br>";
                                } else {
                                    echo "<p class='menu-not-found'>Customer with ID " . $menu_id . " not found.</p>";
                                }
                            }

                            ?>

                            <h3 style="color: #2487ce;">Payment Summary:</h3>
                            <?php

                            foreach ($orders as $order) {




                                // Output menu details
                                if ($order) {
                                    echo "<div class='reservation-item'>";
                                    echo "<div class='reservation-info-payment'>";

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


                                    echo "<br><span class='payment-name'><span>Subtotal: </span>&nbsp;₱ " . $order['total_price'] . "</span>";
                                    echo "<span class='payment-name'><span>Tax: </span>&nbsp;+ ₱ " . $order['tax'] . "</span>";
                                    echo "<span class='payment-name'><b>Grand Total: </b>&nbsp;<b>₱ " . $order['total_price_with_tax'] . "</b></span>";
                                    if ($order['initial_payment'] > 0 || $order['balance']) {
                                        echo "<hr><span class='payment-name'><span>Initial Payment: </span>&nbsp;<span>- ₱ " . $order['initial_payment'] . "</span></span>";
                                        if ($order['status'] == "Booked") {
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
                            <hr>
                            <div style="display: flex; justify-content: space-between;">
                                <?php
                                // Calculate the difference in days between the reservation date and the current date
                                $reservationDate = strtotime($order['order_date']);
                                $currentDate = time();
                                $differenceInDays = floor(($currentDate - $reservationDate) / (60 * 60 * 24));
                                foreach ($orders as $order) {

                                    ?>
                                    <?php if ($order['status'] == 'Pending' && $differenceInDays > 2) { ?>
                                        <button type="button" class="btn-get-del" data-toggle="modal" data-target="#reqCancel"
                                            data-dismiss="modal">Request for
                                            cancel</button>
                                        &nbsp;
                                        <button class="btn-generate-invoice btn-get-main"
                                            data-transaction-no="<?php echo $order['transactionNo']; ?>"><i
                                                class='bx bxs-receipt' style="font-size:15px;"></i> &nbsp; Print
                                            Invoice</button>

                                    <?php } else if ($order['status'] == "Rejected") { ?>
                                            <span> <b>Status: </b><span
                                                    class="badge bg-danger text-white"><?php echo $order['status']; ?></span>
                                                <span></span>
                                        <?php } else if ($order['status'] == "Request for cancel") { ?>
                                                    <span> <b>Status: </b><span
                                                            class="badge bg-danger text-white"><?php echo $order['status']; ?></span>
                                                        <span></span>
                                            <?php } else if ($order['status'] == "Request cancellation approved.") { ?>
                                                            <span> <b>Status: </b><span class="badge bg-success text-white">Cancelled</span>
                                                                <span></span>
                                                <?php } else if ($order['status'] == "Booked") { ?>
                                                                    <span><b>Status: </b>
                                                                        <span class="badge bg-primary"><?php echo $order['status']; ?></span>
                                                                    </span>
                                                                    <button class="btn-generate-invoice btn-get-main"
                                                                        data-transaction-no="<?php echo $order['transactionNo']; ?>"><i
                                                                            class='bx bxs-receipt' style="font-size:15px;"></i> &nbsp; Print
                                                                        Invoice</button>
                                                <?php } else if ($order['status'] == "Completed" && $order['isRated'] == 0) { ?>
                                                                        <span><b>Status: </b>
                                                                            <span class="badge bg-success"><?php echo $order['status']; ?>
                                                                            </span>
                                                                        </span>
                                                                        <div class=""><button class='btn-get-main' data-toggle="modal"
                                                                                data-target="#feedbackModal" data-dismiss="modal">Review</button>
                                                                        </div>
                                                <?php } else if ($order['status'] == "Completed"){ ?>
                                                                            <span><b>Status: </b>
                                                                                <span class="badge bg-success">Completed
                                                                                </span>
                                                                            </span>
                                                                            <!-- <button class="btn-generate-invoice btn-get-main"
                                                        data-transaction-no="><i
                                                            class='bx bxs-receipt' style="font-size:15px;"></i> &nbsp; Print
                                                        Invoice</button> -->
                                                <?php } ?>
                                            <?php } ?>
                            </div>
                        </div>




                    </div>
                </div>


            </div>

            </div>
        </section>



    </main><!-- End #main -->

    <!-- Cancel Confirmation Modal -->
    <div class="modal fade" id="reqCancel" tabindex="-1" role="dialog" aria-labelledby="reqCancelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reqCancelModalLabel">
                        Cancel Request Confirmation
                    </h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    In the event of a cancellation, kindly provide a brief statement or reason for the cancellation, as
                    processing may require 1-2 days.Thank you for your cooperation.
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="remarks">Reason:</label>
                        <textarea class="form-control" id="remarks" name="remarks"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-get-main" id="cancelRequest">Proceed</button>
                </div>
            </div>
        </div>
    </div>



    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel"><b>Rate us!</b></h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div id="review-message"></div>
                    </div>
                    <div class="form-group">
                        <h2><b>How was your experience?</b></h2>
                    </div>
                    <div class="form-group">
                        <small>Rate the quality of service provided</small>
                        <br>
                        <div class="feedback-container">
                            <div class="container__items">
                                <input type="radio" name="stars" id="st5" value="5">
                                <label for="st5">
                                    <div class="star-stroke">
                                        <div class="star-fill"></div>
                                    </div>
                                    <div class="label-description" data-content="Excellent"></div>
                                </label>
                                <input type="radio" name="stars" id="st4" value="4">
                                <label for="st4">
                                    <div class="star-stroke">
                                        <div class="star-fill"></div>
                                    </div>
                                    <div class="label-description" data-content="Good"></div>
                                </label>
                                <input type="radio" name="stars" id="st3" value="3">
                                <label for="st3">
                                    <div class="star-stroke">
                                        <div class="star-fill"></div>
                                    </div>
                                    <div class="label-description" data-content="OK"></div>
                                </label>
                                <input type="radio" name="stars" id="st2" value="2">
                                <label for="st2">
                                    <div class="star-stroke">
                                        <div class="star-fill"></div>
                                    </div>
                                    <div class="label-description" data-content="Bad"></div>
                                </label>
                                <input type="radio" name="stars" id="st1" value="1">
                                <label for="st1">
                                    <div class="star-stroke">
                                        <div class="star-fill"></div>
                                    </div>
                                    <div class="label-description" data-content="Terrible"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="comments">Comments:</label>
                        <textarea class="form-control" id="comments" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn-get-del" data-dismiss="modal">Close</button> -->
                    <button type="button" class="btn-get-main" id="submitFeedback">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- First, include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Then, include Bootstrap's JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Modal CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include AJAX library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>



    <?php

    // Fetch data from the database
    $checkRate = $DB_con->prepare("SELECT transactionNo, user_id,status, isRateDisplayed FROM tbl_orders WHERE transactionNo  = :transactionNo");
    $checkRate->bindParam(':transactionNo', $transactionNo);
    $checkRate->execute();
    $checkedRate = $checkRate->fetchAll(PDO::FETCH_ASSOC);

    foreach ($checkedRate as $Rate) {
        if ($Rate['isRateDisplayed'] == 0 && $Rate['status'] == 'Completed') {
            ?>

            <!-- Feedback Modal -->
            <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="feedbackModalLabel"><b>Rate us!</b></h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div id="review-message"></div>
                            </div>
                            <div class="form-group">
                                <h2><b>How was your experience?</b></h2>
                            </div>
                            <div class="form-group">
                                <small>Rate the quality of service provided</small>
                                <br>
                                <div class="feedback-container">
                                    <div class="container__items">
                                        <input type="radio" name="stars" id="st5" value="5">
                                        <label for="st5">
                                            <div class="star-stroke">
                                                <div class="star-fill"></div>
                                            </div>
                                            <div class="label-description" data-content="Excellent"></div>
                                        </label>
                                        <input type="radio" name="stars" id="st4" value="4">
                                        <label for="st4">
                                            <div class="star-stroke">
                                                <div class="star-fill"></div>
                                            </div>
                                            <div class="label-description" data-content="Good"></div>
                                        </label>
                                        <input type="radio" name="stars" id="st3" value="3">
                                        <label for="st3">
                                            <div class="star-stroke">
                                                <div class="star-fill"></div>
                                            </div>
                                            <div class="label-description" data-content="OK"></div>
                                        </label>
                                        <input type="radio" name="stars" id="st2" value="2">
                                        <label for="st2">
                                            <div class="star-stroke">
                                                <div class="star-fill"></div>
                                            </div>
                                            <div class="label-description" data-content="Bad"></div>
                                        </label>
                                        <input type="radio" name="stars" id="st1" value="1">
                                        <label for="st1">
                                            <div class="star-stroke">
                                                <div class="star-fill"></div>
                                            </div>
                                            <div class="label-description" data-content="Terrible"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="comments">Comments:</label>
                                <textarea class="form-control" id="comments" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn-get-del" data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn-get-main" id="submitFeedback">Submit Feedback</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Automatically show the modal
                $(document).ready(function () {
                    $('#feedbackModal').modal('show');

                    // Update isRateDisplayed to 1 when the modal is closed
                    $('#feedbackModal').on('hidden.bs.modal', function () {
                        $.ajax({
                            type: 'POST',
                            url: 'functions/update_rate_display.php',
                            data: { transactionNo: '<?php echo $transactionNo; ?>'},
                            success: function (response) {
                                console.log('Rate display status updated successfully.');
                            },
                            error: function (xhr, status, error) {
                                console.error('Error updating rate display status: ', error);
                            }
                        });
                    });
                });
            </script>

            <?php
        }
    }
    ?>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/cancel-request.js"></script>

    <script>
        $(document).ready(function () {

            $('#cancelRequest').click(function () {
                var transactionNo = '<?php echo $transactionNo; ?>';
                var remarks = $('#remarks').val(); // Get the value of the remarks textarea

                rejectReservation(transactionNo, remarks);
            });

            // Initialize lightbox with custom configuration
            var lightbox = GLightbox({
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


            $('.btn-generate-invoice').click(function () {
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
                var selected_items = encodeURIComponent('<?php echo $order['selected_items']; ?>');
                var client_image = encodeURIComponent('<?php echo $client_image; ?>');

                // Construct the URL with all parameters
                var url = 'generate_invoice_pdf.php?transaction_no=' + transactionNo +
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
                    '&client_image=' + client_image +
                    '&selected_items=' + selected_items;

                // Redirect to generate_invoice_pdf.php with all parameters
                window.location.href = url;
            });
        });


    </script>
    <script src="assets/js/cancel-request.js"></script>
    <script src="assets/js/submit-feedbacks-order.js"></script>
    <script>

        var transacNo = <?php echo json_encode($transactionNo); ?>;
        var clientId = <?php echo json_encode($_GET['id']); ?>;
    </script>
</body>

</html>