<?php
require_once '../config/conn.php';
require_once 'redirect.php';

redirectToClientPage();



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
    <link href="../assets/img/favicon.png" rel="icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/client_style.css" rel="stylesheet">

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

            <nav id="navbar" class="navbar">
                <ul>
                    <li>
                        <a class="getstarted scrollto" href="index.php"><i class='bx bx-arrow-back'></i> Back to Login page</a>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->


    <main id="main">

        <?php if (!isset($_SESSION['user_id'])) { ?>
            <!-- ======= Login Section ======= -->
            <section id="login" class="login">
                <div class="container" data-aos="fade-up">
                    <div class="row icon-boxes flex justify-content-evenly my-4">
                        <!-- Form container on the right side -->
                        <div class="col-md-124 col-lg-6 " data-aos="zoom-in" data-aos-delay="400">
                            <div class="form-container">
                                <div class="icon-box">

                                    <div class="section-title">
                                        <h2>Forgot Password</h2>
                                    </div>
                                    <div id="messageLogin"></div>
                                    <form method="post" class="forgot-form" id="forgot-form">
                                        <p style="color:gray">Enter your email address to retrieve your password.</p>
                                        <div class="message">
                                            <?php $error = ''; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="py-2">Email address</label>
                                            <input type="email" class="form-control" name="email"
                                                value="<?php echo isset($email) ? $email : ''; ?>" id="email-input">
                                        </div>
                                        <br>
                                        <button type="submit" name="forgot_passwordclient" id="send-link-btn"
                                            class="btn-get-login">Send
                                            Link</button>
                                        <button type="submit" id="resend-link-btn" class="btn-get-login"
                                            style="display:none;cursor:not-allowed;opacity:0.5;" name="resend_link">Resend
                                            Link</button>
                                        <span id="remaining-time" style="display:none;"></span>
                                        <span id="green-message" style="display:none;color:green;"></span>
                                        <div class='alert alert-success' role='alert' id="green-message-resend"
                                            style="display:none;color:green"></div><br>
                                        <span id="countdown"></span><br>
                                        <span id="countdown-message" style="display:none">Redirecting to Login Page.</span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Login Section -->

        <?php } else {
            ?>
            <!-- ======= Login Section ======= -->
            <section id="login" class="login">
                <div class="container" data-aos="fade-up">
                    <div class="row icon-boxes flex justify-content-evenly my-4">
                        <!-- Form container on the right side -->
                        <div class="col-md-124 col-lg-6 " data-aos="zoom-in" data-aos-delay="400">
                            <div class="form-container">
                                <div class="icon-box">
                                    <h1>Kindly logout first.</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Login Section -->
        <?php } ?>
        <!-- ======= Footer ======= -->
        <footer id="footer">
            <div class="container py-2">

                <div class="me-md-auto text-center">
                    <div class="copyright">
                        &copy; Copyright <strong><span style="color:#2487ce;">CaterSpot</span></strong>. All Rights
                        Reserved
                    </div>
                </div>
            </div>
        </footer><!-- End Footer -->

        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>


        <?php require_once 'forgot-password-function.php'; ?>

        <!-- Vendor JS Files -->
        <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
        <script src="../assets/vendor/aos/aos.js"></script>
        <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="../assets/vendor/php-email-form/validate.js"></script>

        <!-- CDN -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Include jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


        <!-- Template Main JS File -->
        <script src="../assets/js/main.js"></script>
        <script src="login.js"></script>


</body>

</html>