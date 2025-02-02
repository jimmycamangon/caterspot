<?php
require_once 'config/conn.php';
require_once 'functions/fetch-user.php';

if (isset($_GET['query'])) {
    $query = "%" . $_GET['query'] . "%"; // Prepare the search term with wildcards

    // Fetch data from the database
    $stmt = $DB_con->prepare("SELECT A.cater_name, A.cater_description, A.client_id, C.status,
    COALESCE(SUM(B.rate), 0) AS total_rating
    FROM tblclient_settings AS A
    LEFT JOIN tbl_feedbacks AS B ON A.client_id = B.client_id
    LEFT JOIN tbl_clients AS C ON A.client_id = C.client_id
    WHERE A.cater_name LIKE ?
    GROUP BY A.cater_name, A.cater_description, A.client_id");

    $stmt->execute([$query]);
    $cateringServices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($cateringServices); // Return results as JSON
} else {
    // Fetch data from the database
    $stmt = $DB_con->prepare("SELECT A.cater_name, A.cater_description, A.client_id, SUM(B.rate) AS total_rating, C.status
FROM tblclient_settings AS A
LEFT JOIN tbl_feedbacks AS B ON A.client_id = B.client_id
LEFT JOIN tbl_clients AS C ON A.client_id = C.client_id
GROUP BY A.cater_name, A.cater_description, A.client_id
ORDER BY total_rating DESC");
    $stmt->execute();
    $cateringServices = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Number of items to display initially
$initialCount = 3;

// Split catering services into initial and additional arrays
$initialCatering = array_slice($cateringServices, 0, $initialCount);
$additionalCatering = array_slice($cateringServices, $initialCount);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


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


            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#vendor">Become our vendor</a></li>
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                    <li>
                        <?php

                        if (isset($_SESSION['PASSWORD_RESET']) && $_SESSION['PASSWORD_RESET'] === true) {
                            echo '<script>
                                    Toastify({
                                        text: "Password reset successfully.",
                                        backgroundColor: "rgba(31, 166, 49, 0.8)",
                                    }).showToast();
                                </script>';
                            unset($_SESSION['PASSWORD_RESET']);
                        }




                        if (isset($_SESSION['user_id'])) {
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
            <?php if (!isset($_SESSION['user_id'])) { ?>
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-9 text-center">
                        <h1>Welcome to CaterSpot</h1>
                        <h2>Your one-stop destination for effortless catering reservations</h2>
                    </div>
                </div>
                <div class="text-center">
                    <a href="#login" class="btn-get-started scrollto">Get Started</a>
                </div>
            <?php } else { ?>
                <div class="text-center">
                    <h1>Explore Our Catering Services</h1>
                    <p>Choose from a variety of catering options tailored to your needs</p>
                </div>
            <?php } ?>

            <input type="text" id="search-cater" placeholder="Search for a catering service..."
                class="form-control mt-3 mb-4" style="max-width: 400px; margin: auto;">
            <div class="row icon-boxes flex justify-content-evenly ">
            </div>

            <!-- See more services button -->
            <?php if (!empty($additionalCatering)): ?>
                <center><button id="see-more-btn" class="btn-get-started" style="border: none;">See more services</button>
                </center>
            <?php endif; ?>


        </div>
    </section>
    <!-- End Hero -->

    <main id="main">

        <?php if (!isset($_SESSION['user_id'])) { ?>
            <!-- ======= Login Section ======= -->
            <section id="login" class="login">
                <div class="container" data-aos="fade-up">
                    <div class="row  icon-boxes flex justify-content-evenly">
                        <!-- Picture on the left side -->
                        <div class="col-md-6 col-lg-6 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in"
                            data-aos-delay="200">
                            <img src="assets/img/Login/Login.jpg" class="img-fluid" alt="Login Image">
                        </div>
                        <!-- Form container on the right side -->
                        <div class="col-md-124 col-lg-6 " data-aos="zoom-in" data-aos-delay="400">

                            <div class="section-title">
                                <h2>Login</h2>
                            </div>
                            <div class="form-container">
                                <div class="icon-box">
                                    <div id="messageLogin"></div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="py-2">Email address</label>
                                        <input type="email" class="form-control input" id="emailLogin" name="email"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="exampleInputPassword1" class="py-2">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control inputs" id="passwordLogin"
                                                name="password" placeholder="Password">
                                            &nbsp;&nbsp;
                                            <div class="input-group-append d-none py-2" style="cursor:pointer;"
                                                id="eyeIconContainer">
                                                <span class="input-group-text" id="togglePasswordVisibility">
                                                    <i class='bx bx-show'></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <center><input type="submit" class="btn-get-login my-2" value="Login" id="LoginButton">
                                    </center>
                                    <center>
                                        <div class="form-group">
                                            <a href="forgot-password.php">Forgot password?</a>
                                        </div>
                                    </center>
                                    <hr>
                                    <div class="form-group">
                                        <center><button type="button" class="btn-get-create" data-toggle="modal"
                                                data-target="#signupModal">
                                                Create new account
                                            </button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Login Section -->

        <?php } ?>
        <!-- Sign up Modal -->
        <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <!-- First Display -->
                <div class="modal-content" id="firstDisplay">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                        <i class='bx bx-x close' style="font-size:30px; cursor:pointer;" data-dismiss="modal"
                            aria-label="Close"></i>
                    </div>

                    <div class="modal-body">
                        <div id="message"></div>

                        <!-- Signup form -->
                        <div class="form-group">
                            <label for="username">Email Address:</label>
                            <input type="text" class="form-control" id="email_signup" name="email">
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="firstname">First Name:</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname">
                                </div>
                                <div class="col">
                                    <label for="lastname">Last Name:</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_signup" name="password">
                                &nbsp;&nbsp;
                                <div class="input-group-append d-none py-2" style="cursor:pointer;"
                                    id="eyeIconContainerSignup">
                                    <span class="input-group-text" id="togglePasswordVisibilitySignup">
                                        <i class='bx bx-show'></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password:</label>
                            <div class="input-group">
                                <input class="form-control" type="password" id="confirmpass" name="confirmpass">
                                &nbsp;&nbsp;
                                <div class="input-group-append d-none py-2" style="cursor:pointer;"
                                    id="eyeIconContainerSignupConfirm">
                                    <span class="input-group-text" id="togglePasswordVisibilitySignup">
                                        <i class='bx bx-show'></i>
                                    </span>
                                </div>
                            </div>
                            <small id="passwordLengthMessage" style="color: red;display:none;padding-top:10px;">&#9679;
                                Password must be
                                at least 8 characters long.</small>
                            <small id="passwordUppercaseMessage" style="color: red;display:none;">&#9679; Password must
                                contain at least one uppercase letter.</small>
                            <small id="passwordSpecialCharMessage" style="color: red;display:none;"> &#9679; Password
                                must contain at least one special character.</small>
                            <small id="confirmPasswordMessage" style="color: red;display:none;">&#9679; Passwords do not
                                match.</small>
                        </div>

                        <button class="btn-get-main my-4" style="width:100% !important;" id="verificationButton">Proceed
                            with verification</button>
                    </div>
                </div>

                <!-- Second Display -->
                <div class="modal-content" id="secondDisplay" style="display:none;">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title" id="signupModalLabel">Email Verification</h5>
                        <i class='bx bx-x close' style="font-size:30px; cursor:pointer;" data-dismiss="modal"
                            aria-label="Close"></i>
                    </div>

                    <div class="modal-body" id="verificationForm">
                        <div id="message_verification"></div>

                        <!-- Verification form -->
                        <h4 class="text-center">Verify your email</h4>
                        <center><small style="color:gray;">Enter the 4 digit code we sent to your email
                                address</small><br>
                            <small style="color:gray;">The code will expire in 5 minutes.</small>
                        </center>
                        <br>
                        <div class="d-flex mb-3">
                            <input type="tel" maxlength="1" pattern="[0-9]" class="form-control verification-code"
                                required>
                            <input type="tel" maxlength="1" pattern="[0-9]" class="form-control verification-code"
                                required>
                            <input type="tel" maxlength="1" pattern="[0-9]" class="form-control verification-code"
                                required>
                            <input type="tel" maxlength="1" pattern="[0-9]" class="form-control verification-code"
                                required>
                        </div>
                        <buton type="submit" class="btn-get-main"
                            style="width:100% !important; font-size:14px; text-align:center;" id="signUp"> Verify
                        </buton>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>About Us</h2>
                </div>

                <div class="row content">
                    <div class="col-lg-12">
                        <p>
                            Welcome to <span style="color: #2487ce; font-weight: bold;">CaterSpot</span>, where we
                            revolutionize
                            the catering experience. We specialize in providing customizable portals for caterers,
                            empowering them to effortlessly manage reservations and bookings online. Our intuitive
                            platform
                            streamlines the process, allowing clients to access catering services with ease. With a
                            focus on
                            efficiency and innovation,
                            we're dedicated to simplifying the catering industry one click at a time. Join us in shaping
                            the future of
                            culinary excellence.
                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- Vendor Section -->
        <section id="vendor" class="vendor">
            <div class="container" data-aos="fade-up">
                <div class="row  icon-boxes flex justify-content-evenly">
                    <!-- Form container on the right side -->
                    <div class="col-md-124 col-lg-6 " data-aos="zoom-in" data-aos-delay="400">

                        <div class="section-title">
                            <h2>Join Our Exclusive Catering Network!</h2>
                        </div>
                        <div class="section-description">
                            <p>Expand your reach and grow your catering business by joining our dynamic platform.
                                Connect with a broader audience, manage bookings effortlessly, and showcase your
                                services to a growing market.
                                Sign up today and become a part of our premier catering network!</p>
                        </div>
                        <br>
                        <center><a href="apply/" style="text-decoration: underline !important;"><button type="button"
                                    class="btn-get-vendor" style="width:30%"> Get Started
                                </button></a>
                        </center>

                    </div>

                    <!-- Picture on the left side -->
                    <div class="col-md-6 col-lg-6 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in"
                        data-aos-delay="200">
                        <img src="assets/img/Login/Merchant.jpg" class="img-fluid" alt="Login Image">
                    </div>
                </div>
            </div>
        </section>

        <!-- End Vendor Section -->
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                </div>

                <div>
                    <iframe style="border:0; width: 100%; height: 270px;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3866.727469426637!2d121.4087505109501!3d14.269109486121215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397e3b71c96a311%3A0xce898b5cab3ba237!2sSta%20cruz%20laguna!5e0!3m2!1sen!2sph!4v1713924773811!5m2!1sen!2sph"
                        frameborder="0" allowfullscreen></iframe>
                </div>

                <div class="row mt-5">

                    <div class="col-lg-4">
                        <div class="info">
                            <div class="address">
                                <i class="bi bi-geo-alt"></i>
                                <h4>Location:</h4>
                                <p>Sta.Cruz Laguna, Philippines</p>
                            </div>

                            <div class="email">
                                <i class="bi bi-envelope"></i>
                                <h4>Email:</h4>
                                <p>lucaterspot@gmail.com</p>
                            </div>

                            <div class="phone">
                                <i class="bi bi-phone"></i>
                                <h4>Call:</h4>
                                <p> +639512780673</p>
                            </div>

                        </div>

                    </div>


                </div>

            </div>
        </section><!-- End Contact Section -->



    </main><!-- End #main -->

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
                            <li><i class="bx bx-chevron-right"></i> <a href="#vendor">Become our vendor</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#contact">Contact</a></li>
                            <!-- <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li> -->
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <?php foreach ($cateringServices as $footerCater): ?>
                                <li><i class="bx bx-chevron-right"></i>
                                    <?php if (empty($footerCater['status']) || $footerCater['status'] === null): ?>
                                        <!-- Service not available, show a non-clickable link or message -->
                                        <span class="text-muted"><?php echo $footerCater['cater_name']; ?> (Service Coming
                                            Soon)</span>
                                    <?php else: ?>
                                        <!-- Service available, show clickable link -->
                                        <a
                                            href="view.php?cater=<?php echo urlencode($footerCater['cater_name']); ?>&id=<?php echo urlencode($footerCater['client_id']); ?>"><?php echo $footerCater['cater_name']; ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                    </div>


                </div>
            </div>
        </div>

        <!-- Pop up Notification -->
        <div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="updateProfileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateProfileModalLabel">
                            Complete Your Profile
                        </h5>
                        <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                            aria-label="Close"></i>
                    </div>
                    <div class="modal-body">
                        <p>You need to complete your profile by providing your contact number and address before you can
                            proceed with booking.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="profile.php" style="color:white;text-decoration:none;"> <button type="button"
                                class="btn-get-main"> Update Now
                            </button></a>
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
    <?php require_once 'functions/feedback.php'; ?>

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
    <script src="assets/js/signup.js"></script>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/showpassword.js"></script>
    <script src="assets/js/verification-code.js"></script>
    <script src="assets/js/fetch-philadd.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php
                // Fetch current user's profile information and notification status
                $user_id = $_SESSION['user_id']; // user_id is available in the session
                $stmt = $DB_con->prepare("SELECT contact, location, region, province, city, isNotified FROM tbl_users WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Check if the user has not been notified and contact or location is missing
                if (
                    $result && ($result['isNotified'] == 0) && (empty($result['contact']) || empty($result['location'])
                        || empty($result['region']) || empty($result['province']) || empty($result['city']))
                ): ?>
                    // Show the modal automatically if the user hasn't been notified and profile is incomplete
                    var notifyModal = new bootstrap.Modal(document.getElementById('notifyModal'));
                    notifyModal.show();

                    // Update the isNotified status using AJAX after showing the modal
                    fetch('functions/update-notification-status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ user_id: <?php echo $user_id; ?> })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Notification status updated successfully.');
                            } else {
                                console.log('Failed to update notification status.');
                            }
                        }).catch(error => console.error('Error:', error));
                <?php endif; ?>
            <?php endif; ?>
        });



        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-cater');
            const cardsContainer = document.querySelector('.icon-boxes');
            const seeMoreButton = document.getElementById('see-more-btn');
            const initialCount = 3; // Define the number of initial cards to display
            let allCateringData = []; // To hold all catering data

            // Fetch all catering services on initial load
            fetch('search-cater.php')
                .then(response => response.json())
                .then(data => {
                    allCateringData = data; // Store all catering data
                    displayInitialCatering(); // Show initial catering items
                });

            searchInput.addEventListener('input', function () {
                const query = searchInput.value;

                if (query.length > 0) {
                    // AJAX request to fetch catering services based on search
                    fetch(`search-cater.php?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            cardsContainer.innerHTML = ''; // Clear current cards

                            if (data.length === 0) {
                                cardsContainer.innerHTML = '<center><p>No catering services found.</p></center>';
                                seeMoreButton.style.display = 'none'; // Hide button if no results
                                return;
                            }

                            // Show only the initial count of catering services
                            const initialCatering = data.slice(0, initialCount);
                            initialCatering.forEach(catering => {
                                const card = createCard(catering);
                                cardsContainer.appendChild(card);
                            });

                            // Show the "See More" button if there are additional items
                            seeMoreButton.style.display = data.length > initialCount ? 'block' : 'none';
                        });
                } else {
                    // If the input is cleared, display the initial count of catering services
                    displayInitialCatering();
                }
            });

            seeMoreButton.addEventListener('click', function () {
                // Show all additional catering items
                const additionalItems = allCateringData.slice(initialCount); // Get all additional items
                additionalItems.forEach(catering => {
                    const card = createCard(catering);
                    cardsContainer.appendChild(card);
                });

                // Hide the button after it's clicked
                this.style.display = 'none';
            });

            function displayInitialCatering() {
                cardsContainer.innerHTML = ''; // Clear current cards
                const initialCatering = allCateringData.slice(0, initialCount); // Get the initial count of catering services
                initialCatering.forEach(catering => {
                    const card = createCard(catering);
                    cardsContainer.appendChild(card);
                });

                // Show the "See More" button if there are additional items
                seeMoreButton.style.display = allCateringData.length > initialCount ? 'block' : 'none';
            }

            function createCard(catering) {
                const card = document.createElement('div');
                card.className = 'col-md-6 col-lg-3 d-flex align-items-stretch mb-4 mb-lg-0';
                card.setAttribute('data-aos', 'zoom-in');
                card.setAttribute('data-aos-delay', '200');

                // Round the average rating to one decimal place
                const roundedRating = catering.average_rating > 0
                    ? parseFloat(catering.average_rating).toFixed(1)
                    : "No Ratings"; // Round to one decimal place

                const ratingDisplay = catering.average_rating > 0
                    ? `<span class="rating"><i class="fa-solid fa-star" style="color: gold;"></i> ${parseFloat(catering.average_rating).toFixed(1)}</span>`
                    : `<span class="no-rating" style='font-size:0.8rem;'><i class="fa-solid fa-star" style="color: gray;"></i> No Ratings Yet</span>`;


                // Highlight top-rated cards (if desired threshold is reached)
                const isTopRated = roundedRating !== "No Ratings" && parseFloat(roundedRating) >= 4; // Define threshold for "top-rated" display
                const topRatedClass = isTopRated ? 'top-rated' : ''; // Add class for styling top-rated services

                card.innerHTML = `
                    <div class="icon-box ${topRatedClass}">
                        <p class="description py-2">${ratingDisplay}</p>
                        <h4 class="title"><a href="#">${catering.cater_name}</a></h4>
                        <p class="description py-2">${catering.cater_description || "No Description Provided"}</p>

                        <!-- Conditional logic to check catering status -->
                        ${catering.status === "" || catering.status === null ?
                        `<span class="badge bg-secondary">Service Coming Soon</span>` :
                        `<a href="view.php?cater=${encodeURIComponent(catering.cater_name)}&id=${encodeURIComponent(catering.client_id)}" class="btn-learn-more">View Services</a>`
                    }
                    </div>
                    `;

                return card;
            }



        });


    </script>





</body>

</html>