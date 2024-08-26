<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/PHPMailer-master/src/Exception.php';
require '../assets/vendor/PHPMailer-master/src/PHPMailer.php';
require '../assets/vendor/PHPMailer-master/src/SMTP.php';

require_once '../config/conn.php';

if (isset($_POST['forgot_passwordclient'])) {
    $email = $_POST['email'];

    // Check if Email Exists  
    $check_useremail = $DB_con->prepare("SELECT * FROM tbl_clients WHERE email = :email LIMIT 1");
    $check_useremail->execute(['email' => $_POST['email']]);

    // Check if Email Exists 
    if ($check_useremail->rowCount() == 0) {
        $error = "<div class='alert alert-danger' role='alert'>No account found with this email.</div>";
    } else {
        // Check if Request Already Exists
        $check_request = $DB_con->prepare("SELECT * FROM tblforgot_password_reset_tokens WHERE email = :email LIMIT 1");
        $check_request->execute(['email' => $_POST['email']]);

        if ($check_request->rowCount() == 0) {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "<div class='alert alert-danger' role='alert'>Please enter a valid email <br>Example: name@example.com </div>";
            } else if (forgot_password($DB_con, $email)) {
                echo '<script>
                        function startCountdown() {
                            var count = 30;
                            var countdownTimer = setInterval(function () {
                                document.getElementById("remaining-time").innerHTML = "Resend in " + count + " seconds";
                                count--;
                                if (count < 0) {
                                    clearInterval(countdownTimer);
                                    document.getElementById("resend-link-btn").disabled = false;
                                    document.getElementById("remaining-time").style.display = "none";
                                    document.getElementById("resend-link-btn").style.backgroundColor = "";
                                    document.getElementById("green-message").innerHTML = "";
                                    document.getElementById("resend-link-btn").style.opacity = "1";
                                    document.getElementById("resend-link-btn").style.cursor = "pointer"; // set cursor to not allowed
                                } 
                            }, 1000);
                        }
            
                        function hideSendButton() {
                            document.getElementById("send-link-btn").style.display = "none";
                            var resendLinkBtn = document.getElementById("resend-link-btn");
                            resendLinkBtn.style.display = "inline-block";
                            resendLinkBtn.disabled = true;
                            document.getElementById("email-input").readOnly = true;
                            resendLinkBtn.style.backgroundColor = "gray";
                            document.getElementById("remaining-time").style.display = "inline-block";
                            document.getElementById("green-message").innerHTML = "Link has been sent to your email.";
                            document.getElementById("green-message").style.display = "inline-block";
                        }
            
                    </script>';
                echo '<script>startCountdown();</script>';
                echo '<script>hideSendButton();</script>';
            }
        } else {
            $error = "<div class='alert alert-danger' role='alert'>Request already exists.</div>";
        }
    }
}

if (!empty($error)) {
    echo '<script>document.querySelector(".message").innerHTML = "' . $error . '";</script>';
}

if (isset($_POST['resend_link'])) {
    $email = $_POST['email'];

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error = "div class='alert alert-danger' role='alert'>Please enter a valid email <br>Example: name@example.com </div>";
    } else if (resend_link($DB_con, $email)) {
        echo '<script>
                function showMessageResent() {
                    document.getElementById("green-message-resend").innerHTML = "Link has been Resent to your email.";
                    document.getElementById("green-message-resend").style.display = "inline-block";
                    document.getElementById("send-link-btn").style.display = "none";
                    document.getElementById("email-input").readOnly = true;

                    var seconds = 5;
                    var countdown = setInterval(function() {
                        if (seconds <= 0) {
                            clearInterval(countdown);
                            window.location.href = "index.php";
                        } else {
                            document.getElementById("countdown").innerHTML = seconds;
                            seconds -= 1;
                        }
                    }, 1000);
                    document.getElementById("countdown-message").style.display = "inline-block";
                }
                
            </script>';
        echo '<script>
                showMessageResent();
              </script>';
    }
}

// forgot_password function
function forgot_password($DB_con, $email)
{
    // Generate a unique token
    $token = bin2hex(random_bytes(32));

    // Insert token and email into database
    $expiration = time() + (24 * 60 * 60); // Token is valid for 24 hours
    $stmt = $DB_con->prepare("INSERT INTO tblforgot_password_reset_tokens (token, email, expiration) VALUES (:token, :email, :expiration)");
    $stmt->bindValue(':token', $token);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':expiration', $expiration);
    $stmt->execute();

    // Send password reset email
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cainginbarangay@gmail.com';
    $mail->Password = 'lpvgibhpsinkqjsd';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('cainginbarangay@gmail.com', 'CaterSpot');
    $mail->addAddress($email);
    $mail->isHTML(true);

    $mail->Subject = 'Password Reset Request';
    $mail->Body = '
        <html>
            <head>
                <style>
                    /* CSS styles go here */
                    body {
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        line-height: 1.5;
                    }
                    
                    h1 {
                        font-size: 24px;
                        font-weight: bold;
                    }
                    
                    p {
                        margin-bottom: 20px;
                    }
                    
                    a {
                        background: #fff;
                        border-radius: 5px;
                        padding: 15px 25px;
                        font-weight: bold;
                        color: #3B2667;
                        cursor: pointer;
                        box-shadow: 0px 2px 5px rgb(0, 0, 0, 0.5);
                        border: none;
                        transition: 200ms;
                        text-decoration: none;
                    }
                    
                    a:hover {
                        background: #fff !important;
                        color: #000 !important;
                    }
                    
                    .reset-container {
                        color: #fff;
                        border-radius: 0.5em;
                        max-width: 500px;
                        width: 100%;
                        max-height: 200px;
                        height: 100%;
                        padding: 2em;
                        background: rgb(28,85,126);
                        background: linear-gradient(180deg, rgba(28,85,126,1) 0%, rgba(36,135,206,1) 100%);
                    }
                </style>
            </head>
            
            <body>
                <div class="reset-container">
                    <h1>Password Reset</h1>
                    <p>Please click the following link to reset your password:</p>
                    <br>
                    <br>
                    <a href="http://localhost/caterspot/client/reset-password-page.php?token=' . $token . '">Reset Password</a>
                </div>
            </body>
        </html>
    ';

    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}

// RESET LINK

// forgot_password function
function resend_link($DB_con, $email)
{
    // Check if Email Already Exist
    $check = $DB_con->prepare("SELECT * FROM tblforgot_password_reset_tokens WHERE email = :email LIMIT 1");
    $check->execute(['email' => $_POST['email']]);

    if ($check->rowCount() > 0) {
        // Delete used token from the database
        $stmt = $DB_con->prepare("DELETE FROM tblforgot_password_reset_tokens WHERE email = :email");
        $stmt->execute(['email' => $_POST['email']]);
    }

    // Generate a unique token
    $token = bin2hex(random_bytes(32));

    // Insert token and email into database
    $expiration = time() + (24 * 60 * 60); // Token is valid for 24 hours
    $stmt = $DB_con->prepare("INSERT INTO tblforgot_password_reset_tokens (token, email, expiration) VALUES (:token, :email, :expiration)");
    $stmt->bindValue(':token', $token);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':expiration', $expiration);
    $stmt->execute();

    // Send password reset email
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cainginbarangay@gmail.com';
    $mail->Password = 'lpvgibhpsinkqjsd';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('cainginbarangay@gmail.com', 'CaterSpot');
    $mail->addAddress($email);
    $mail->isHTML(true);

    $mail->Subject = 'Password Reset Request';
    $mail->Body = '
        <html>
            <head>
                <style>
                    /* CSS styles go here */
                    body {
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        line-height: 1.5;
                    }
                    
                    h1 {
                        font-size: 24px;
                        font-weight: bold;
                    }
                    
                    p {
                        margin-bottom: 20px;
                    }
                    
                    a {
                        background: #fff;
                        border-radius: 5px;
                        padding: 15px 25px;
                        font-weight: bold;
                        color: #3B2667;
                        cursor: pointer;
                        box-shadow: 0px 2px 5px rgb(0, 0, 0, 0.5);
                        border: none;
                        transition: 200ms;
                        text-decoration: none;
                    }
                    
                    a:hover {
                        background: #fff !important;
                        color: #000 !important;
                    }
                    
                    .reset-container {
                        color: #fff;
                        border-radius: 0.5em;
                        max-width: 500px;
                        width: 100%;
                        max-height: 200px;
                        height: 100%;
                        padding: 2em;
                        background: rgb(28,85,126);
                        background: linear-gradient(180deg, rgba(28,85,126,1) 0%, rgba(36,135,206,1) 100%);
                    }
                </style>
            </head>
            
            <body>
                <div class="reset-container">
                    <p>Please click the following link to reset your password:</p>
                    <br>
                    <br>
                    <a href="http://localhost/caterspot/client/reset-password-page.php?token=' . $token . '">Reset Password</a>
                </div>
            </body>
        </html>
    ';

    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}
?>