<?php
require_once '../config/conn.php';
require_once 'redirect.php';

redirectToClientPage();

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
        $error = "<div class='alert alert-danger' role='alert'>Passwords do not match.</div>";
    } else {
        // Prevent reuse of the old password
        if (check_old_password($DB_con, $token, $password)) {
            $error = "<div class='alert alert-danger' role='alert'>New password cannot be the same as the old password.</div>";
        } else {
            // Reset password if it meets all criteria
            if (reset_password($DB_con, $token, $password)) {
                // Password reset successfully, redirect with success message
                $_SESSION['PASSWORD_RESET'] = true;
                header("Location: index.php?reset=success");
                exit();
            } else {
                $error = "<div class='alert alert-danger' role='alert'>Failed to Reset Password</div>";
            }
        }
    }
}

// Function to check if the new password matches the old password
function check_old_password($DB_con, $token, $password)
{
    // Get the user's email using the token
    $stmt = $DB_con->prepare("SELECT email FROM tblforgot_password_reset_tokens WHERE token = :token AND expiration >= :now");
    $stmt->bindValue(':token', $token);
    $stmt->bindValue(':now', time());
    $stmt->execute();
    $row = $stmt->fetch();

    if ($row) {
        $email = $row['email'];

        // Get the old password hash from the users table
        $stmt = $DB_con->prepare("SELECT password FROM tbl_clients WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Compare the new password with the old password hash
            if (password_verify($password, $user['password'])) {
                return true; // Password matches the old one
            }
        }
    }

    return false; // Password doesn't match the old one
}

// Function to reset password
function reset_password($DB_con, $token, $password)
{
    // Check if token is valid
    $stmt = $DB_con->prepare("SELECT * FROM tblforgot_password_reset_tokens WHERE token = :token AND expiration >= :now");
    $stmt->bindValue(':token', $token);
    $stmt->bindValue(':now', time());
    $stmt->execute();
    $row = $stmt->fetch();

    if ($row) {
        $email = $row['email'];
        $hashed_password = password_hash($password, PASSWORD_ARGON2I);

        // Check if the email exists in the users table
        $stmt = $DB_con->prepare("SELECT * FROM tbl_clients WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            // Update the user's password
            $stmt = $DB_con->prepare("UPDATE tbl_clients SET password = :password WHERE email = :email");
            $stmt->bindValue(':password', $hashed_password);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            // Delete used token from the database
            $stmt = $DB_con->prepare("DELETE FROM tblforgot_password_reset_tokens WHERE token = :token");
            $stmt->bindValue(':token', $token);
            $stmt->execute();

            return true;
        }
    }

    return false;
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
                        <a class="getstarted scrollto" href="../"><i class='bx bx-arrow-back'></i> Back to HomePage</a>
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
                                    <div id="messageLogin"></div>
                                    <form method="post" class="forgot-form" id="forgot-form">
                                        <div class="section-title">
                                            <h2>Reset your Password</h2>
                                        </div>
                                        <br>
                                        <div class="message">
                                            <?php echo $error ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="py-2">New Password:</label>
                                            <div class="input-group">
                                                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="&nbsp;" name="password">
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
                                        </div>
                                        <br>
                                        <button type="submit" name="reset_password" class="btn-get-login">Reset
                                            Password</button><br><br><br>
                                    </form>

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
        <script src="../assets/js/client-forgot-password.js"></script>


</body>

</html>