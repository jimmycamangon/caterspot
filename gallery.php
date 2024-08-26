<?php
require_once 'config/conn.php';
require_once 'functions/fetch-gallery.php';
require_once 'functions/fetch-user.php';
require_once 'functions/fetch-client.php';

// Fetch package data based on the provided package name
$uniq_id = isset($_GET['uniq_id']) ? $_GET['uniq_id'] : '';


if (empty($uniq_id)) {
    //redirect user if no package id | user id is active
    header("Location:index.php");
}



// Fetch packages from tbl_packages
$sql = "SELECT package_id, package_name FROM tbl_packages WHERE package_id  = :package_id ";
$stmt = $DB_con->prepare($sql);
$stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
$stmt->execute();
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                            <a class="getstarted scrollto" href="index.php"><i class='bx bx-arrow-back'></i> Back</a>
                        <?php } else { ?>
                            <a class="getstarted scrollto"
                                href="view.php?cater=<?php echo $cater; ?>&id=<?php echo $client_cater_id; ?>"><i
                                    class='bx bx-arrow-back'></i> Back</a>

                        <?php } ?>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <main id="main">

        <!-- ======= Services Section ======= -->
        <section id="gallery" class="portfolio">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2 style="color:#2487ce !important;">
                        <?php
                        if (!empty($cater_name)):
                            echo $cater_name;
                        else:
                            echo "Catering Name not found.";
                        endif; ?><br>
                        Photo Gallery
                    </h2>
                </div>

                <?php
                // Fetch gallery data based on the provided gallery name
                $client_id = isset($_GET['id']) ? $_GET['id'] : ''; // Assuming 'cater' is the parameter name
                $cater = isset($_GET['cater']) ? $_GET['cater'] : ''; // Assuming 'cater' is the parameter name
                if (!empty($cater)) {
                    // Prepare SQL statement
                    $sql = "SELECT DISTINCT(A.service) FROM tblclient_gallery AS A
                    INNER JOIN tbl_clients AS B ON A.client_id = B.client_id
                    WHERE  B.client_id = :client_id";
                    $stmt = $DB_con->prepare($sql);
                    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);

                }
                ?>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <?php if (!empty($galleries)): ?>
                                <li data-filter="*" class="filter-active">All</li>
                                <?php foreach ($galleries as $gallery):
                                    ?>

                                    <li data-filter=".filter-<?php echo $gallery['service']; ?>">
                                        <?php echo $gallery['service']; ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="300">

                    <?php
                    // Prepare SQL statement
                    $sql = "SELECT A.* FROM tblclient_gallery AS A
                    LEFT JOIN tbl_clients AS B ON A.client_id = B.client_id
                    WHERE A.client_id = :client_id";
                    $stmt = $DB_con->prepare($sql);
                    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    ?>
                    <?php if (!empty($galleries)): ?>
                        <?php foreach ($galleries as $gallery):
                            ?>
                            <div class="col-lg-4 col-md-6 portfolio-item filter-<?php echo $gallery['service']; ?>">
                                <div class="portfolio-wrap">
                                    <img src="assets/img/client-gallery/<?php echo $gallery['file_name']; ?>" class="img-fluid"
                                        alt="">
                                    <div class="portfolio-info">
                                        <h4>
                                            <?php echo $gallery['service']; ?>
                                        </h4>
                                        <div class="portfolio-links">
                                            <a href="assets/img/client-gallery/<?php echo $gallery['file_name']; ?>"
                                                data-gallery="portfolioGallery" class="portfolio-lightbox"
                                                title="<?php echo $gallery['service']; ?>"><span
                                                    style="font-size:18px;border:1px solid white;padding:0.5em;color:white;">View
                                                    image</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <center>
                            <div class="No_package" style="background: #fff;padding:0.5em; width:100%;">
                                <p>Unfortunately, there are no packages available at the moment. Please check back later or
                                    contact us for further assistance. Thank you for your understanding</p>
                            </div>
                        </center>
                    <?php endif; ?>



                </div>

            </div>
        </section><!-- End Services Section -->



    </main><!-- End #main -->



    <!-- Redirect Modal -->
    <div class="modal fade" id="ConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmationModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ConfirmationModal">Customer Information</h5>
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
                                    <input type="text" class="form-control" id="full_name" name="full_name">
                                </div>
                                <div class="form-group">
                                    <label for="contact_number">Contact Number:</label>
                                    <input type="number" class="form-control" name="contact_number" id="contact_number"
                                        min="0">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="location">Location:</label>
                                    <input type="text" class="form-control" id="location" name="location">
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
                                <div class="form-group" id="GcashUser" style="display: none;">
                                    <hr>
                                    <label for="gcashname">Name of Gcash Account:</label>
                                    <input type="text" class="form-control" id="gcashname" name="gcashname"
                                        value="<?php echo $clientUsername; ?>" disabled>
                                    <label for="gcashnumber">Number of Gcash Account:</label>
                                    <input type="number" class="form-control" id="gcashnumber" name="gcashnumber"
                                        value="<?php echo $clientNumber; ?>" disabled>
                                </div>
                                <div class="form-group" id="uploadImageField" style="display: none;">
                                    <label for="upload_image">Upload Image (Gcash Receipt):</label>
                                    <input type="file" accept="image/*" class="form-control" id="upload_image"
                                        name="upload_image">
                                </div>

                                <!-- Select dropdown options are GCASH and Walk-In (Receipt) -->

                                <!-- Hidden -->
                                <input type="hidden" name="selected_items" id="selectedItems">
                                <input type="hidden" name="total_price" id="totalPrice">
                                <input type="hidden" name="tax" id="tax">
                                <input type="hidden" name="total_price_with_tax" id="totalPriceWithTax">
                                <input type="hidden" name="attendees" id="attendeesValue">
                                <input type="hidden" name="cater" value="<?php echo $cater ?>">
                                <input type="hidden" name="package_id" value="<?php echo $package_id ?>">
                                <input type="hidden" name="event_date" id="eventDate">
                                <input type="hidden" name="event_duration" id="eventDuration">


                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Back</button>
                    <button type="submit" class="btn-get-main">Submit Order</button>
                    </form>
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
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

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


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>