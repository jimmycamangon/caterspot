<?php
require_once 'config/conn.php';
require_once 'functions/fetch-user.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
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

            <h1 class="logo"><a href="index.php">CaterSpot</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li>
                        <?php if (isset($_SESSION['user_id'])) {
                            ?>
                        <li><a class="nav-link scrollto" href="my-reservations.php">My Reservations</a></li>
                        <li class="dropdown"><a href="#">
                                <?php echo $Userfullname; ?>
                            </a>
                            <ul>
                                <li><a href="profile.php">Edit Profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                        <?php
                        } else { ?>
                        <a class="getstarted scrollto" href="./#login">Login</a>
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
            <div class="row  icon-boxes flex justify-content-evenly">
                <!-- Picture on the left side -->
                <div class="col-md-6 col-lg-6 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in"
                    data-aos-delay="200">
                    <img src="assets/img/Login/forgot-password.png" class="img-fluid" alt="Login Image">
                </div>
                <!-- Form container on the right side -->
                <div class="col-md-124 col-lg-6 " data-aos="zoom-in" data-aos-delay="400">
                    <div class="form-container">
                        <div class="icon-box">
                            <div id="messageLogin"></div>
                            <form method="post" class="forgot-form" id="forgot-form">
                                <h1>Forgot your password?</h1>
                                <p style="color:gray">Enter your email address to retrieve your password.</p>
                                <div class="message">
                                    <?php $error = ''; ?>
                                </div>
                                </p>
                                <div class="form-group">
                                    <label for="email" class="py-2">Email address</label>
                                    <input type="email" class="form-control" name="email"
                                        value="<?php echo isset($email) ? $email : ''; ?>" id="email-input">
                                </div>
                                <br>
                                <button type="submit" name="forgot_password" id="send-link-btn"
                                    class="btn-get-main">Send
                                    Link</button>
                                <button type="submit" id="resend-link-btn" class="btn-get-main"
                                    style="display:none;cursor:not-allowed;opacity:0.5;" name="resend_link">Resend
                                    Link</button>
                                <span id="remaining-time" style="display:none;"></span>
                                <span id="green-message" style="display:none;color:green;"></span>
                                <div class='alert alert-success' role='alert' id="green-message-resend" style="display:none;color:green"></div> <br><br>
                                <span id="countdown"></span>
                                <span id="countdown-message" style="display:none">Redirecting to Login Page.</span>
                            </form>
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
                            <li><i class="bx bx-chevron-right"></i> <a href="#vendor">Become our vendor</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#contact">Contact</a></li>
                            <!-- <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li> -->
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


    <?php require_once 'functions/forgot-password-function.php'; ?>
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



</body>

</html>