<?php
require_once '../config/conn.php';
require_once 'redirect.php';

redirectToClientPage();
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
            <h1 class="logo"><a href="../">CaterSpot</a></h1>

            <nav id="navbar" class="navbar">
                <ul>
                    <li>
                        <a class="getstarted scrollto" href="../"><i class='bx bx-arrow-back'></i> Back to HomePage</a>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->


    <main id="main">

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



        if (!isset($_SESSION['user_id'])) { ?>
            <!-- ======= Login Section ======= -->
            <section id="login" class="login">
                <div class="container" data-aos="fade-up">
                    <div class="row icon-boxes flex justify-content-evenly my-4">
                        <!-- Form container on the right side -->
                        <div class="col-md-124 col-lg-6 " data-aos="zoom-in" data-aos-delay="400">

                            <div class="section-title">
                                <h2>Admin</h2>
                            </div>
                            <div class="form-container">
                                <div class="icon-box">
                                    <div id="messageLogin"></div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input" id="username" name="username"
                                            aria-describedby="usernameHelp" placeholder="Username">
                                    </div>
                                    <div class="form-group py-2">
                                        <input type="password" class="form-control input" id="passwordLogin" name="password"
                                            placeholder="Password">
                                    </div>
                                    <center><input type="submit" class="btn-get-login my-2" value="Login" id="LoginButton">
                                    </center>
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
                    <div class="row icon-boxes justify-content-center my-4">
                        <!-- Form container on the right side -->
                        <div class="col-md-6 col-lg-6 d-flex justify-content-center" data-aos="zoom-in"
                            data-aos-delay="400">
                            <div class="form-container"
                                style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                <div class="icon-box">
                                    <img src="../assets/img/LOCK.png" alt=""
                                        style="max-width: 50%; height: auto; display: block; margin: 0 auto;">
                                    <h4 style="margin-top: 1rem;">Kindly log out of your account to proceed.</h4>
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