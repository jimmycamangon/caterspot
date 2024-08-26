<?php
include_once 'functions/fetch-pendings.php';
require_once 'functions/sessions.php';


redirectToLogin();
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
                        <li class="breadcrumb-item active">Pending Reservations</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                            <i class="fa-solid fa-spinner"></i>&nbsp;
                                <b>List of Pending Reservations</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th>Transaction No.</th>
                                        <th>Customer</th>
                                        <th>Package Selected</th>
                                        <th>Grand Total</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Reservation Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservations as $reservation): ?>
                                        <tr>
                                            <td>
                                                <?php

                                                if ($reservation['is_read'] == 0) {
                                                    echo '<span
                                                    style="background-color:green; color:white; padding: 0.2em 1em 0.2em 1em; border-radius:0.5em; font-size:0.8rem;">New</span>&nbsp;&nbsp;';
                                                }

                                                echo $reservation['transactionNo'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $reservation['full_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $reservation['package_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $reservation['total_price_with_tax']; ?>
                                            </td>
                                            <td>
                                                <?php if ($reservation['status'] == "Pending") { ?>
                                                    <span
                                                        class="badge bg-warning text-dark"><?php echo $reservation['status']; ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php echo $reservation['remarks']; ?>
                                            </td>
                                            <td>
                                                <?php echo $reservation['order_date']; ?>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                    onclick="markAsRead('<?php echo $reservation['transactionNo']; ?>')"
                                                    style="text-decoration:none;" class="btn-get-main view-btn">
                                                    <i class="fa-solid fa-eye"></i> View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>




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
    <script src="functions/js/mark-as-read.js"></script>


</body>

</html>