<?php
require_once 'config/conn.php';
require_once 'functions/fetch-user.php';
include_once 'functions/fetch-orders.php';

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
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/table.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">


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
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="./">CaterSpot</a></h1>

            <nav id="navbar" class="navbar">
                <ul>
                    <li>
                        <a class="getstarted scrollto" href="index.php"><i class='bx bx-arrow-back'></i> Back</a>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <div class="pt-2">
                    <h2>My Reservations</h2>
                </div>
                <ol>
                    <li><a href="./">Home</a></li>
                    <li>Reservations</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->
    <!-- ======= Hero Section ======= -->
    <section id="reservation" class="d-flex ">
        <div class="container" data-aos="fade-up">
            <div class="alert alert-primary" role="alert" style="font-size:0.9rem;">
                <b>Notice:</b> <i>Please be advised that after a period of 2 days from the initial request, we are
                    unable to process
                    cancellations.</i>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="datatablesSimple" class="table">
                        <thead>
                            <tr>
                                <th>Transaction No.</th>
                                <th>Cater name</th>
                                <th>Package Selected</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Reservation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (isset($_SESSION['successful_reservation'])) {
                                // Output JavaScript code to display a notification using Toastify
                                echo '<script>
                                    Toastify({
                                        text: "Reservation completed successfully",
                                        backgroundColor: "rgba(31, 166, 49, 0.8)"
                                    }).showToast();
                                </script>';
                                // Unset the session variable to remove it after displaying the notification
                                unset($_SESSION['successful_reservation']);
                            }
                            foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <?php echo $order['transactionNo']; ?>
                                    </td>
                                    <td>
                                        <?php echo $order['cater']; ?>
                                    </td>
                                    <td>
                                        <?php echo $order['package_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $order['total_price_with_tax']; ?> Php
                                    </td>
                                    <td>
                                        <?php if ($order['status'] == "Pending") { ?>
                                            <span class="badge bg-warning text-dark"><?php echo $order['status']; ?></span>
                                        <?php } else if ($order['status'] == "Booked") { ?>
                                                <span class="badge bg-primary"><?php echo $order['status']; ?></span>
                                        <?php } else if ($order['status'] == "Completed" || $order['status'] == "Request cancellation approved.") { ?>
                                                    <span class="badge bg-success"><?php echo $order['status']; ?></span>
                                        <?php } else { ?>
                                                    <span class="badge bg-danger"><?php echo $order['status']; ?></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php echo $order['remarks']; ?>
                                    </td>
                                    <td>
                                        <?php echo $order['order_date']; ?>
                                    </td>
                                    <td>
                                        <a href="view-reservation-detail.php?transactionNo=<?php echo $order['transactionNo']; ?>&id=<?php echo $order['client_id']; ?>"
                                            class="btn-get-main">View</a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
    <!-- End Hero -->


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
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>





    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/signup.js"></script>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/datatables-simple-demo.js"></script>
    <script src="assets/js/datatables-simple-demo.js"></script>





</body>

</html>