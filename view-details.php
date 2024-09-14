<?php
require_once 'config/conn.php';
require_once 'functions/fetch-user.php';
require_once 'functions/fetch-client.php';
require_once 'functions/fetch-booked.php';

// Fetch package data based on the provided package name
$package_id = isset($_GET['package_id']) ? $_GET['package_id'] : '';


if (empty($package_id)) {
    //redirect user if no package id | user id is active
    header("Location:index.php");
} else if (!isset($_SESSION['user_id'])) {
    header("Location:index.php");
}


// Fetch packages from tbl_packages
$sql = "SELECT A.package_id, A.package_name, B.menu_id FROM tbl_packages AS A
 LEFT JOIN tbl_menus AS B ON A.package_id = B.package_id
 WHERE A.package_id  = :package_id ";
$stmt = $DB_con->prepare($sql);
$stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
$stmt->execute();
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch packages from tbl_packages
$sql = "SELECT DISTINCT A.package_name FROM tbl_packages AS A
 LEFT JOIN tbl_menus AS B ON A.package_id = B.package_id
 WHERE A.package_id  = :package_id ";
$stmt = $DB_con->prepare($sql);
$stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
$stmt->execute();
$package_names = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    <!-- DATA TABLE -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />


    <!-- Template Main CSS File -->
    <link href="assets/css/table.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/cart.css" rel="stylesheet">

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
                        <a class="getstarted scrollto"
                            href="view.php?cater=<?php echo $cater_name; ?>&id=<?php echo $client_cater_id; ?>"><i
                                class='bx bx-arrow-back'></i> Back</a>
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
                        <?php
                        if ($package_names) {
                            foreach ($package_names as $package_name) {
                                echo $package_name['package_name'];
                            }
                        }
                        ?>
                    </h2>
                    <ol>
                        <li><a href="./">Home</a></li>
                        <li>Package Menus</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->

        <section id="hero" class="d-flex align-items-center">
            <!-- style="height:auto !important;" -->

            <div class="container" style="padding: auto !important; height:auto !important;">

                <div class="row gy-4">

                    <div class="col-lg-8 package-menu-parent">
                        <?php
                        // Fetch packages from tbl_packages
                        $sql = "SELECT A.client_id, B.package_id, C.* FROM tbl_clients AS A 
                        LEFT JOIN tbl_packages AS B ON A.client_id = B.client_id
                        LEFT JOIN tbl_menus AS C ON B.package_id = C.package_id
                        WHERE C.package_id = :package_id";
                        $stmt = $DB_con->prepare($sql);
                        $stmt->bindParam(':package_id', $package_id, PDO::PARAM_STR);
                        $stmt->execute();
                        $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($packages)):
                            foreach ($packages as $package): ?>

                                <div class="row border rounded mt-2 mb-2">
                                    <div class="row main align-items-center p-3">
                                        <div class="col-sm-6 col-md-6 col-lg-3 text-lg-center text-md-center">
                                            <div class="image-container-view">
                                                <a href="assets/img/menu-uploads/<?php echo $package['menu_image']; ?>"
                                                    class="glightbox" data-glightbox="gallery">
                                                    <img src="assets/img/menu-uploads/<?php echo $package['menu_image']; ?>"
                                                        class="menu-img">

                                                </a>

                                            </div>
                                            <?php
                                            $menu_id_other = $package['menu_id'];

                                            // Prepare a SQL query to count the number of images for the menu_id
                                            $query_count = "SELECT COUNT(*) AS image_existing FROM tblclient_othermenus WHERE menu_id = :menu_id";
                                            $stmt_count = $DB_con->prepare($query_count);
                                            $stmt_count->bindParam(':menu_id', $menu_id_other);
                                            $stmt_count->execute();

                                            // Fetch the result as an associative array
                                            $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);

                                            // Extract the count of images
                                            $image_existing = $row_count['image_existing'];

                                            // Check if there are images
                                            if ($image_existing > 0) {
                                                // If images exist, prepare a SQL query to fetch the images
                                                $query_images = "SELECT file_name, menu_id, client_id FROM tblclient_othermenus WHERE menu_id = :menu_id";
                                                $stmt_images = $DB_con->prepare($query_images);
                                                $stmt_images->bindParam(':menu_id', $menu_id_other);
                                                $stmt_images->execute();

                                                // Fetch the images as an associative array
                                                $rows_images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);


                                                // Output the "View additional images" link only once
                                                echo "<button class='view-image-btn' style='color:#2487ce; font-size:0.8rem; border: none; background-color: transparent; text-decoration: underline; cursor: pointer;' data-toggle='modal' data-target='#ImagesLabelModal' data-menu-id='" . $menu_id_other . "'>See more</button>";
                                            } else {

                                            }
                                            ?>

                                            <br>
                                        </div>

                                        <div class="col-sm-6 col-md-6 col-lg-4" style="font-size:0.8rem;">
                                            <div><b>
                                                    <?php
                                                    // Check if the menu item is available
                                                    if ($package['availability'] == "Not available"):
                                                        echo $package['menu_name']; ?>
                                                        <!-- If not available, disable and uncheck the checkbox -->
                                                        | <span class="badge bg-danger">Not available</span>
                                                    <?php else:
                                                        echo $package['menu_name'];
                                                    endif; ?></b>
                                            </div>
                                            <div class="row text-muted">
                                                <p><?php echo $package['menu_description']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 d-flex justify-content-end align-items-center gap-2 mb-2 mb-md-0 "
                                            id="quantity">
                                            <br><br>
                                            <?php if ($package['availability'] == "Not available"): ?>
                                                <!-- Disable all of this stepDown, stepUp, and input -->
                                                <i class='bx bxs-minus-square' data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-link"
                                                    style="font-size:1.5rem;color:#2487ce;cursor:pointer;opacity:0.5;"></i>

                                                <input id="form1" min="0" name="quantity" value="0" type="number"
                                                    class="form-control form-control-sm" max="100" style="width:60px;opacity:0.5;"
                                                    disabled>

                                                <i class='bx bxs-plus-square' data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-link"
                                                    style="font-size:1.5rem;color:#2487ce;cursor:pointer;opacity:0.5;"></i>
                                            <?php else: ?>
                                                <!-- Enable stepDown, stepUp, and input -->
                                                <i class='bx bxs-minus-square' data-value="<?php echo $package['menu_price']; ?>"
                                                    class="btn btn-link" style="font-size:1.5rem;color:#2487ce;cursor:pointer;"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown(); updateSelectedItemsDisplay();"></i>


                                                <input id="form1" min="0" name="quantity" value="0" type="number"
                                                    class="form-control form-control-sm" max="600" style="width:60px;"
                                                    data-menu-name="<?php echo $package['menu_name']; ?>"
                                                    data-menu-image="<?php echo $package['menu_image']; ?>"
                                                    data-menu-id="<?php echo $package['menu_id']; ?>"
                                                    onchange="validateQuantity(this); updateSelectedItemsDisplay()">




                                                <i class='bx bxs-plus-square' data-value="<?php echo $package['menu_price']; ?>"
                                                    class="btn btn-link" style="font-size:1.5rem;color:#2487ce;cursor:pointer;"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp(); updateSelectedItemsDisplay();"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-2 d-flex justify-content-end align-items-center c-group"
                                            style="font-size:0.9rem;" id="price">

                                            <?php
                                            // Check if the menu item is available
                                            if ($package['availability'] == "Not available"): ?>
                                                <b style="opacity:0.5;">&#8369; <?php echo $package['menu_price']; ?></b> &nbsp;
                                                <input type="checkbox" name="selected_menus" class="selected-menu"
                                                    id="menu_<?php echo $package['menu_id']; ?>"
                                                    value="<?php echo $package['menu_price']; ?>" disabled>

                                            <?php else: ?>
                                                <!-- If available, display checkbox as usual -->
                                                <b>&#8369; <?php echo $package['menu_price']; ?></b> &nbsp;
                                                <input type="checkbox" name="selected_menus" class="selected-menu"
                                                    id="menu_<?php echo $package['menu_id']; ?>"
                                                    value="<?php echo $package['menu_price']; ?>" checked
                                                    onchange="toggleElements(this)">
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <center>
                                <h2>No Items available</h2>
                            </center>
                        <?php endif; ?>
                    </div>





                    <div class="col-lg-4">
                        <div class="package-info">
                            <h3>Reservation Details:</h3>
                            <div class="alert alert-danger" id="dateWarning"
                                style="font-size:12px;display:none;">Please select a date at least one month in advance. 
                                Dates in the past and within one month from today are not allowed.</div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="event_date">Event Date:</label>
                                        <input type="date" class="form-control" name="event_date" id="event_date"
                                            required>
                                    </div>
                                    <div class="col">
                                        <label for="booked">Scheduled Events:</label>
                                        <button type="button" class="btn-get-main" data-toggle="modal"
                                            data-target="#ViewSchedModal"><i
                                                class='bx bx-search-alt-2'></i>View</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="event_duration">Event Duration:</label>
                                <select class="form-control" name="event_duration" id="event_duration" required>
                                    <option value="2">2 hours</option>
                                    <option value="4">4 hours</option>
                                    <option value="6">6 hours</option>
                                    <option value="8">8 hours</option>
                                    <option value="10">10 hours</option>
                                    <option value="12">12 hours</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="time">From:</label>
                                            <input type="time" class="form-control" name="From" id="fromTime"
                                                step="3600" required />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="time">To:</label>
                                            <input type="text" class="form-control" name="End" id="toTimes" required
                                                disabled />

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="attendees">Attendees:</label>
                                <input type="number" class="form-control" name="attendees" id="attendees" value="1"
                                    min="1" max="600" required onchange="validateAttendees();">
                            </div>

                            <div class="form-group">
                                <label for="payment_selection">Payment Selection:<i class='bx bxs-info-circle'
                                        data-toggle='modal' data-target='#paymentinfoModal' data-dismiss='modal'
                                        style="color:#2487ce;font-size:1.2rem;cursor:pointer;"></i></label>
                                <select class="form-control" id="payment_selection" name="payment_selection">
                                    <option value="Down Payment">Down Payment</option>
                                    <option value="Full Payment">Full Payment</option>
                                </select>
                            </div>
                            <div class="form-group" id="down_payment_input_wrapper">
                                <div class="row">
                                    <div class="col">
                                        <label for="down_payment_input">Initial Payment:</label>
                                        <input type="number" class="form-control" id="down_payment_input" value="0"
                                            name="down_payment_input" onchange="validateInitial();" min="0">
                                    </div>
                                    <div class="col"></div>
                                </div>
                            </div>


                            <br>
                            <h3>Payment Summary:</h3>
                            <ul id="calculationList">
                                <!-- Display selected items here -->
                                <div id="selected-items-display"></div>
                                <div id="subtotal-display"></div>
                                <div id="tax-display"></div>
                                <div id="total-display"></div>
                                <div id="downpayment-display"></div>
                                <div id="balance-display"></div>
                                <div id="invalidpax-display">
                                    <li style="color:red; font-size:0.8rem;">
                                        Be advised that our catering services require a minimum order of 10
                                        items/menus, with a maximum capacity of 600.
                                    </li>
                                </div>


                            </ul>
                            <div style="display: flex; justify-content: flex-end;">
                                <a href="#" class="btn-get-main" data-toggle="modal" data-target="#ConfirmationModal"
                                    title="More Details" id="submitBtn">Check Out</a>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </section>



    </main><!-- End #main -->



    <!-- Redirect Modal -->
    <div class="modal fade" id="ConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmationModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ConfirmationModal">Customer Information</h4>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row gy-4">

                        <div class="col-lg-12 package-menu-parent">
                            <!-- Inserts -->
                            <form id="orderForm" method="post" action="functions/insert-order.php"
                                enctype="multipart/form-data">

                                <div class="form-group">
                                    <div class="alert alert-info" role="alert" id="noticeinfo"
                                        style="font-size:0.8rem;">
                                        Would you like to update your information?
                                        &nbsp;<span onclick="toggleInputs()" style="cursor:pointer;color:blue;"><u>Click
                                                here</u></span>
                                    </div>
                                </div>
                                <div id="packageDropdownContainer" class="form-group">
                                    <label for="package_id">Package Selected:</label>
                                    <select class="form-control" id="package_id" name="package_id">
                                        <?php

                                        // Fetch packages from tbl_packages
                                        $sql = "SELECT package_id, package_name FROM tbl_packages WHERE package_id  = :package_id ";
                                        $stmt = $DB_con->prepare($sql);
                                        $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
                                        $stmt->execute();
                                        $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        // Display options if available, otherwise show message
                                        if ($packages) {
                                            foreach ($packages as $package) {
                                                echo '<option value="' . $package['package_id'] . '">' . $package['package_name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled selected>No packages available. Please create a package first.</option>';
                                            echo '</select>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="full_name">Full Name:</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name"
                                        value="<?php echo $Userfullname; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="contact_number">Contact Number:</label>
                                    <input type="text" class="form-control" name="contact_number" id="contact_number"
                                        oninput="limitContactNumber(this)" value="<?php echo $Usercontact; ?>" disabled>

                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?php echo $Useremail; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="location">Location:</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        value="<?php echo $UserProvince . ' ' . $UserCity . ' ' . $Userlocation; ?>"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label for="payment_method">Payment Method:<i class='bx bxs-info-circle'
                                            style="color:#2487ce;"
                                            title="Gcash (Image Receipt) | Walkin (Generated Receipt)"></i></label>
                                    <select class="form-control" id="payment_method" name="payment_method">
                                        <option value="Walk-In">Walk-In (Receipt)</option>
                                        <option value="Gcash">GCash</option>
                                    </select>
                                </div>
                                <div class="form-group" id="uploadImageField" style="display: none;">
                                    <label for="upload_image">Upload Image (Gcash Receipt):</label>
                                    <input type="file" accept="image/*" class="form-control" id="upload_image"
                                        name="upload_image">
                                </div>

                                <div class="form-group" id="GcashUser" style="display: none;">
                                    <hr>
                                    <label for="gcashname">Name of Gcash Account:</label>
                                    <input type="text" class="form-control" id="gcashname" name="gcashname"
                                        value="<?php echo $clientUsername; ?>" disabled>
                                    <label for="gcashnumber">Number of Gcash Account:</label>
                                    <input type="text" class="form-control" id="gcashnumber" name="gcashnumber"
                                        value="<?php echo $client_contact; ?>" disabled>
                                </div>
                                <br>
                                <div id="noselected-display" style="font-size:0.8rem;">

                                </div>

                                <!-- Select dropdown options are GCASH and Walk-In (Receipt) -->

                                <!-- Hidden -->
                                <input type="hidden" name="total_price" id="totalPrice">
                                <input type="hidden" name="tax" id="tax">
                                <input type="hidden" name="total_price_with_tax" id="totalPriceWithTax">
                                <input type="hidden" name="initial_payment" id="initial_payment">
                                <input type="hidden" name="balance" id="balance">
                                <input type="hidden" name="attendeees" id="attendeesValue">
                                <input type="hidden" name="cater" value="<?php echo $cater_name; ?>">
                                <input type="hidden" name="client_cater_id" value="<?php echo $client_cater_id; ?>">
                                <input type="hidden" name="cater_email" value="<?php echo $client_email; ?>">
                                <input type="hidden" name="package_id" value="<?php echo $package_id ?>">
                                <input type="hidden" name="event_date" id="eventDate">
                                <input type="hidden" name="event_duration" id="eventDuration">
                                <input type="hidden" name="From" id="fromTimes">
                                <input type="hidden" name="End" id="toTime">
                                <input type="hidden" name="payment_selections" id="payment_selections">

                                <input type="hidden" name="selected_products" id="selected-products">




                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Back</button>
                    <button type="submit" class="btn-get-main" id="book-submit">Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Scheduels Modal -->
    <div class="modal fade" id="ViewSchedModal" tabindex="-1" role="dialog" aria-labelledby="ViewSchedModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ViewSchedModal">Scheduled Events:</h4>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" role="alert" style='font-size:0.8rem;'>
                        <b>Please note:</b> <span style="font-weight:400">We can only provide two services per day. When
                            booking, ensure there's at
                            least a two-hour gap between your scheduled time and the previous booked to prevent your
                            reservation from being declined.</span>
                    </div>
                    <style>
                        #datatablesSimple td {
                            font-weight: 400;
                        }

                        .datatable-bottom {
                            font-weight: 400;
                        }
                    </style>
                    <table id="datatablesSimple" class="table">
                        <thead>
                            <tr>
                                <th>Reservation Date</th>
                                <th>Event Date</th>
                                <th>Event Duration</th>
                                <th>Event Start-End</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($books as $booked): ?>
                                <tr>
                                    <td><?php echo date('F j, Y g:i a', strtotime($booked['order_date'])); ?></td>
                                    <td><?php echo date('F j, Y', strtotime($booked['event_date'])); ?></td>
                                    <td><?php echo $booked['event_duration']; ?> Hours</td>
                                    <td><?php echo date('h:i A', strtotime($booked['From'])) . ' - ' . $booked['To']; ?>
                                    </td>
                                    <td>
                                        <?php if ($booked['status'] == "Pending") { ?>
                                            <span class="badge bg-warning text-dark"><?php echo $booked['status']; ?></span>
                                        <?php } else if ($booked['status'] == "Booked") { ?>
                                                <span class="badge bg-primary"><?php echo $booked['status']; ?></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <!-- Payment Inform -->
    <div class="modal fade" id="paymentinfoModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationCompleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmationCompleteModalLabel">
                        Payment Notice
                    </h4>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <p style="font-weight:400;">Our standard down payment is 50% of the total payment. However, we're
                        open to accommodating your preferences. If you wish to provide a larger down payment, kindly
                        indicate your desired amount.</p>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn-get-main" data-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Pax Inform -->
    <div class="modal fade" id="paxinfoModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationCompleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmationCompleteModalLabel">
                        Pax Requirement Notice
                    </h4>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <p style="font-weight:400;">Be advised that our catering services require a minimum order of 10
                        items/menus, with a maximum capacity of 600.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendees Inform -->
    <div class="modal fade" id="attendeesinfoModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationCompleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmationCompleteModalLabel">
                        Attendees Requirement Notice
                    </h4>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <p style="font-weight:400;">Please note that our catering service can accommodate a maximum of 600
                        guests.</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Invalid -->
    <div class="modal fade" id="InvalidModalLabelModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationCompleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmationCompleteModalLabel">
                        Reminder
                    </h4>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <p style="font-weight:400;">Before proceeding, kindly select an item. Additionally, please ensure
                        that the initial payment does not exceed the total amount.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- More Images Modal -->
    <div class="modal fade" id="ImagesLabelModal" tabindex="-1" role="dialog" aria-labelledby="ImagesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ImagesModalLabel">
                        Additional Menu Images
                    </h4>
                    <span data-dismiss="modal" aria-label="Close" style="font-size:2rem;cursor:pointer;"><i
                            class='bx bx-x'></i></span>
                </div>
                <div class="modal-body">
                    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <!-- Images fetched via AJAX will be dynamically added here -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container d-md-flex py-2">
            <div class="container py-2">

                <div class="me-md-auto text-center">
                    <div class="copyright">
                        &copy; Copyright <strong><span style="color:#2487ce;">CaterSpot</span></strong>. All Rights
                        Reserved
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- First, include jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <!-- Then, include Bootstrap's JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/view-details.js"></script>
    <script src="assets/js/datatables-simple-demo.js"></script>
    <script src="assets/js/image-slider.js"></script>
</body>

</html>