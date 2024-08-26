<?php
require_once 'config/conn.php';
require_once 'functions/fetch-user.php';


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
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
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
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
                    <li>
                        <?php if (isset($_SESSION['user_id'])) {
                            ?>
                        <li><a class="nav-link scrollto" href="my-reservations.php">My Reservations</a></li>
                        <li class="dropdown"><a href="#">
                                <?php echo $Userfullname; ?>
                            </a>
                            <ul>
                                <li><a href="#">Edit Profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                        <?php
                        } else { ?>
                        <a class="getstarted scrollto" href="#login">Login</a>
                    <?php } ?>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center position-relative"
        style="background-image: url('assets/img/hero-bg4.jpg'); background-position: top center; background-size: cover;">
        <div class="overlay"></div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row icon-boxes flex justify-content-evenly">
                <div class="col">
                    <div class="row">
                        <div class="col mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="e-profile">
                                        <div id="message"></div>
                                        <div class="row">
                                            <div
                                                class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">
                                                        <?php echo $Userfullname; ?>
                                                    </h4>
                                                    <p class="mb-0"><?php echo $Useremail; ?></p>
                                                </div>

                                                <div class="text-center text-sm-right order-first order-sm-last">
                                                    <span class="badge badge-secondary">administrator</span>
                                                    <div class="text-muted"><small>Joined
                                                            <?php echo $Userjoined; ?></small></div>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="#" class="active nav-link">Settings</a></li>
                                        </ul>
                                        <div class="tab-content pt-3">
                                            <div class="tab-pane active">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>First Name</label>
                                                                    <input type="hidden" id="edit_user_id"
                                                                        value="<?php echo $_SESSION['user_id']; ?>"
                                                                        name="edit_user_id">

                                                                    <input class="form-control" type="text"
                                                                        name="edit_first_name" id="edit_first_name"
                                                                        value="<?php echo $Userfirstname ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Last Name</label>
                                                                    <input class="form-control" type="text"
                                                                        name="edit_last_name" id="edit_last_name"
                                                                        value="<?php echo $Userlastname ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Username</label>
                                                                    <input class="form-control" type="text"
                                                                        name="edit_username" id="edit_username"
                                                                        value="<?php echo $Username ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input class="form-control" type="text"
                                                                        name="edit_email" id="edit_email"
                                                                        value="<?php echo $Useremail ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Contact</label>
                                                                    <input class="form-control" type="number"
                                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                        maxlength="11" name="edit_contact"
                                                                        id="edit_contact"
                                                                        value="<?php echo $Usercontact ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Region</label>
                                                                    <select class="form-control" id="edit_region"
                                                                        name="edit_region">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Province</label>
                                                                    <select class="form-control" id="edit_province"
                                                                        name="edit_province">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>City/Municipality</label>
                                                                    <select class="form-control" id="edit_city"
                                                                        name="edit_city">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Street Address</label>
                                                                    <input class="form-control" type="text"
                                                                        name="edit_location" id="edit_location"
                                                                        value="<?php echo $Userlocation ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <div class="mb-2"><b>Change Password</b></div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>New Password</label>
                                                                    <input class="form-control" type="password"
                                                                        name="newpass" id="newpass">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Confirm <span
                                                                            class="d-none d-xl-inline">Password</span></label>
                                                                    <input class="form-control" type="password"
                                                                        name="confirmpass" id="confirmpass">
                                                                </div>
                                                            </div>

                                                            <small id="passwordLengthMessage"
                                                                style="color: red;display:none;">&#9679; Password must
                                                                be at least 8
                                                                characters long.</small><br>
                                                            <small id="passwordUppercaseMessage"
                                                                style="color: red;display:none;">&#9679; Password must
                                                                contain at
                                                                least one
                                                                uppercase letter.</small><br>
                                                            <small id="passwordSpecialCharMessage"
                                                                style="color: red;display:none;">
                                                                &#9679; Password must contain at
                                                                least one
                                                                special character.</small><br>
                                                            <small id="confirmPasswordMessage"
                                                                style="color: red;display:none;">&#9679; Passwords do
                                                                not
                                                                match.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col d-flex justify-content-end">
                                                        <button class="btn-get-main" type="submit"
                                                            id="saveChangesBtn">Save Changes</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
    <!-- End Hero -->


    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>CaterSpot</h3>
                        <p>
                            Sta.Cruz Laguna, <br>
                            Philippines <br><br>
                            <strong>Phone:</strong> +639512780673<br>
                            <strong>Email:</strong> lucaterspot@gmail.com<br>
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#hero">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#contact">Contact</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Catering Services (ANJ Catering
                                    Services)</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Catering Services (Elisam Catering
                                    Services)</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Catering Services (Kagahin Catering
                                    Services)</a></li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>

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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/validate-profile.js"></script>

    <script>
        $(document).ready(function () {
            // Load regions
            $.ajax({
                url: 'functions/fetch-philaddress.php',
                type: 'POST',
                data: { type: 'region' },
                success: function (data) {
                    $('#edit_region').html(data);
                }
            });

            // Load provinces based on selected region
            $('#edit_region').change(function () {
                var region_id = $(this).val();
                $.ajax({
                    url: 'functions/fetch-philaddress.php',
                    type: 'POST',
                    data: { type: 'province', region_id: region_id },
                    success: function (data) {
                        $('#edit_province').html(data);
                        $('#edit_city').html('<option value="">Select City/Municipality</option>'); // Clear city dropdown
                    }
                });
            });

            // Load cities based on selected province
            $('#edit_province').change(function () {
                var province_id = $(this).val();
                $.ajax({
                    url: 'functions/fetch-philaddress.php',
                    type: 'POST',
                    data: { type: 'city', province_id: province_id },
                    success: function (data) {
                        $('#edit_city').html(data);
                    }
                });
            });
        });
    </script>

</body>

</html>