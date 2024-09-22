<?php
require_once 'config/conn.php';
require_once 'functions/fetch-user.php';

$error = '';

if (isset($_POST['reset_password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check for empty fields
    if (empty($_POST['password'])) {
        $error = "<div class='alert alert-danger' role='alert'>Please enter Password</div>";
    } else if (empty($_POST['confirm_password'])) {
        $error = "<div class='alert alert-danger' role='alert'>Please enter Confirm Password</div>";
    } else if (strlen(trim($_POST['password'])) < 8) {
        $error = "<div class='alert alert-danger' role='alert'>Password must be at least 8 characters long</div>";
    } else if ($password != $confirm_password) {
        $error = "<div class='alert alert-danger' role='alert'>Passwords do not match</div>";
    } else {
        // Reset password if it meets all criteria
        $result = reset_password($DB_con, $token, $password);

        if ($result === 'same_password') {
            $error = "<div class='alert alert-danger' role='alert'>You cannot reuse your old password. Please choose a different one.</div>";
        } else if ($result) {
            // Password reset successfully, redirect with success message
            $_SESSION['PASSWORD_RESET'] = true;
            header("Location: index.php?reset=success");
            exit();
        } else {
            $error = "<div class='alert alert-danger' role='alert'>Failed to Reset Password</div>";
        }
    }
}


// Function to check if a password meets the strength criteria
function reset_password($DB_con, $token, $password)
{
    // Check if token is valid
    $stmt = $DB_con->prepare("SELECT * FROM tblforgot_password_reset_tokens WHERE token = :token AND expiration >= :now");
    $stmt->bindValue(':token', $token);
    $stmt->bindValue(':now', time());
    $stmt->execute();
    $row = $stmt->fetch();

    if ($row) {
        // Token is valid
        $email = $row['email'];
        $hashed_password = password_hash($password, PASSWORD_ARGON2I);

        // Check if the email exists in the users table
        $stmt = $DB_con->prepare("SELECT * FROM tbl_users WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            // Compare the new password with the existing password
            if (password_verify($password, $user['password'])) {
                // Password is the same as the old one, return false with an error message
                return 'same_password';
            }

            // Update user's password
            $stmt = $DB_con->prepare("UPDATE tbl_users SET password = :password WHERE email = :email");
            $stmt->bindValue(':password', $hashed_password);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            // Delete used token from the database
            $stmt = $DB_con->prepare("DELETE FROM tblforgot_password_reset_tokens WHERE token = :token");
            $stmt->bindValue(':token', $token);
            $stmt->execute();

            return true;
        }
    } else {
        // Token is invalid
        return false;
    }
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
                    <img src="assets/img/Login/reset-password.png" class="img-fluid img-static" alt="Login Image">
                </div>

                <!-- Form container on the right side -->
                <div class="col-md-124 col-lg-6 " data-aos="zoom-in" data-aos-delay="400">
                    <div class="form-container">
                        <div class="icon-box">
                            <div id="messageLogin"></div>
                            <form method="post" class="forgot-form" id="forgot-form">
                                <h1>Reset your Password</h1>
                                <br>
                                <div class="message">
                                    <?php echo $error ?>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="py-2">New Password:</label>
                                    <div class="input-group">
                                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                        <input type="password" class="form-control" id="password" placeholder="&nbsp;"
                                            name="password">
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
                                    <label for="confirm_password" class="py-2">Confirm Password:</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password"
                                            placeholder="&nbsp;" name="confirm_password">
                                        &nbsp;&nbsp;
                                        <div class="input-group-append d-none py-2" style="cursor:pointer;"
                                            id="eyeIconContainerSignupConfirm">
                                            <span class="input-group-text" id="togglePasswordVisibilitySignup">
                                                <i class='bx bx-show'></i>
                                            </span>
                                        </div>
                                    </div>
                                    <small id="passwordLengthMessage"
                                        style="color: red;display:none;padding-top:10px;">&#9679;
                                        Password must be
                                        at least 8 characters long.</small>
                                    <small id="passwordUppercaseMessage" style="color: red;display:none;">&#9679;
                                        Password must
                                        contain at least one uppercase letter.</small>
                                    <small id="passwordSpecialCharMessage" style="color: red;display:none;"> &#9679;
                                        Password
                                        must contain at least one special character.</small>
                                    <small id="confirmPasswordMessage" style="color: red;display:none;">&#9679;
                                        Passwords do not
                                        match.</small>
                                </div>
                                <br>
                                <button type="submit" name="reset_password" id="reset_button" class="btn-get-main">Reset
                                    Password</button><br><br><br>
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
    <script src="assets/js/forgot-password.js"></script>



</body>

</html>