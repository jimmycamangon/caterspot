<?php
require_once 'config/conn.php';
require_once 'functions/fetch-user.php';
require_once 'functions/fetch-client.php';
require_once 'functions/fetch-gallery.php';


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

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="./">CaterSpot</a></h1>


            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#services">Services</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#feedbacks">Feedback</a></li>
                    <li><a class="nav-link scrollto" href="#faq">FAQ</a></li>
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
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
                        } else { ?>
                        <a class="getstarted scrollto" href="./#login">Login</a>
                    <?php } ?>
                    </li>
                    <li>
                        <a class="getstarted scrollto" href="./"><i class='bx bx-arrow-back'></i> Back</a>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center"
        style="background: url('assets/img/client-images/<?php echo $cater_bg_image; ?>') top center; background-size: cover; height:70vh;padding-top:2em;">
        <div class="overlay"></div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                <div class="col-md-4 col-12 position-relative">
                    <?php
                    $image_path = 'assets/img/client-images/' . $client_image;
                    if (file_exists($image_path) && is_file($image_path)) {
                        // If image exists, use it
                        $image_source = $image_path;
                    } else {
                        // If image doesn't exist, use placeholder
                        $image_source = 'assets/img/client-images/Image_not_available.jpg';
                    }
                    ?>
                    <img src="<?php echo $image_source; ?>" alt="Profile" class="img-fluid img-thumbnail"
                        style="max-width: 190px; position: absolute; top: 0; left: 0;">
                </div>
                <div class="col-md-8 col-12">
                    <div class="text-end">
                        <h1>
                            <?php
                            if (!empty($cater_name)):
                                echo $cater_name;
                            else:
                                echo "No Catering Services Found.";
                            endif; ?>
                        </h1>
                        <p style="font-weight:600;">
                            <?php
                            if (!empty($cater_location)):
                                echo $cater_location;
                            else:
                                echo "No Address Found.";
                            endif; ?>
                        </p>
                        <p>
                            <?php
                            if (!empty($gallery_uniqid)): ?>
                                <a class="btn-get-main"
                                    href="gallery.php?cater=<?php echo $clientUsername; ?>&id=<?php echo $gallery_id; ?>&uniq_id=<?php echo $gallery_uniqid; ?>"><i
                                        class='bx bx-images'></i> Explore</a>
                            <?php endif; ?>
                        </p>
                        <a href="#feedbacks">
                            <p id="average-rating-mini" style="font-size:1.5rem;"></p>
                        </a>
                    </div>
                </div>
            </div>


    </section>

    <!-- End Hero -->

    <main id="main">
        <!-- ======= Services Section ======= -->
        <section id="services" class="portfolio">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Offered Services</h2>
                </div>

                <?php
                $client_id = isset($_GET['id']) ? $_GET['id'] : '';
                if (!empty($client_id)) {
                    // Prepare SQL statement
                    $sql = "SELECT * FROM tbl_packages AS A INNER JOIN tbl_clients AS B ON B.client_id = A.client_id WHERE B.client_id = :client_id";
                    $stmt = $DB_con->prepare($sql);
                    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                }
                ?>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <?php if (!empty($packages)): ?>
                                <li data-filter="*" class="filter-active">All</li>
                                <?php foreach ($packages as $package):
                                    ?>

                                    <li data-filter=".filter-<?php echo $package['package_id']; ?>">
                                        <?php echo $package['package_name']; ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>


                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="300">

                    <?php
                    if (!empty($client_id)) {
                        // Prepare SQL statement
                        $sql = "SELECT * FROM tbl_packages AS A INNER JOIN tbl_clients AS B ON B.client_id = A.client_id WHERE B.client_id = :client_id";
                        $stmt = $DB_con->prepare($sql);
                        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
                        $stmt->execute();
                        $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>
                    <?php if (!empty($packages)): ?>
                        <?php foreach ($packages as $package): ?>
                            <div class="col-lg-4 col-md-6 portfolio-item filter-<?php echo $package['package_id']; ?>">
                                <div class="portfolio-wrap">
                                    <?php
                                    $image_path = 'assets/img/package-uploads/' . $package['package_image'];
                                    if (file_exists($image_path) && is_file($image_path)) {
                                        // If image exists, use it
                                        $image_source = $image_path;
                                    } else {
                                        // If image doesn't exist, use placeholder
                                        $image_source = 'assets/img/package-uploads/Image_not_available.jpg';
                                    }
                                    ?>
                                    <img src="<?php echo $image_source; ?>" class="img-fluid" alt="">
                                    <div class="portfolio-info">
                                        <h4><?php echo $package['package_name']; ?></h4>
                                        <p><?php echo $package['package_desc']; ?></p>
                                        <div class="portfolio-links">
                                            <a href="<?php echo $image_source; ?>" data-gallery="portfolioGallery"
                                                class="portfolio-lightbox" title="<?php echo $package['package_name']; ?>"><span
                                                    style="font-size:18px;border:1px solid white;padding:0.5em;color:white;">View
                                                    image</span></a>
                                            <?php if (!isset($_SESSION['user_id'])) { ?>
                                                <a href="#" data-toggle="modal" data-target="#RedirectModal"
                                                    title="More Details"><span
                                                        style="font-size:18px;border:1px solid white;padding:0.5em;color:white;">View
                                                        menu</span></a>
                                            <?php } else { ?>
                                                <a href="view-details.php?package_id=<?php echo $package['package_id']; ?>&id=<?php echo $_GET['id']; ?>"
                                                    title="More Details"><span
                                                        style="font-size:18px;border:1px solid white;padding:0.5em;color:white;">View
                                                        menu</span></a>
                                            <?php } ?>
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




                    <!-- Redirect Modal -->
                    <div class="modal fade" id="RedirectModal" tabindex="-1" role="dialog"
                        aria-labelledby="RedirectModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="RedirectModal">Login Required</h5>
                                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;"
                                        data-dismiss="modal" aria-label="Close"></i>
                                </div>
                                <div class="modal-body">
                                    <div id="message"></div>
                                    Please login to proceed.
                                </div>
                                <div class="modal-footer">
                                    <a href="./#login" class="redirect-login">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Services Section -->
        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>About Us</h2>
                </div>

                <div class="row content justify-content-center">
                    <div class="col-lg-12 ">
                        <?php
                        if (!empty($cater_about_us)):
                            echo $cater_about_us;
                        else:
                            echo "<center>The Catering personnel did not provide any of their information.</center>";
                        endif; ?>
                    </div>
                </div>


            </div>
        </section><!-- End About Section -->

        <!-- ======= About Video Section ======= -->
        <section id="feedbacks" class="about-video">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Feedbacks</h2>

                </div>
                <div class="row">

                    <div class="col-lg-6 video-box align-self-baseline position-relative" data-aos="fade-right"
                        data-aos-delay="100">
                        <div id="rates-section" class="col-md-6">
                            <div id="rates-container">
                                <p id="average-rating"></p>
                                <br>
                                <h4 style="color:#2487ce;"><b>Overall Rating</b></h4>
                                <?php

                                // Check if cater parameter is set in the GET request
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    // Prepare and execute the SQL statement to fetch rates for the specified client_id
                                    $stmt = $DB_con->prepare("SELECT rate FROM tbl_feedbacks WHERE client_id = :id");
                                    $stmt->bindValue(":id", $id, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Define an array to store the counts of each rate
                                    $ratesCount = array(0, 0, 0, 0, 0);

                                    if ($result) {
                                        // Count the occurrences of each rate
                                        foreach ($result as $row) {
                                            $rate = intval($row['rate']);
                                            $ratesCount[$rate - 1]++;
                                        }

                                        // Display horizontal lines for each rate
                                        for ($i = 4; $i >= 0; $i--) {
                                            $rateCount = $ratesCount[$i];
                                            $rateValue = $i + 1;
                                            echo "<div class='rate'>";
                                            echo "<div class='rate-label'>$rateValue</div>";
                                            echo "<div class='rate-bar-gray' style='width: 300px;'>";
                                            echo "<div class='rate-bar' style='width: " . ($rateCount * 20) . "px;'></div></div>";
                                            // echo "&nbsp;<div class='rate-value'>$rateCount</div>"; 
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "No ratings found.";
                                    }
                                } else {
                                    echo "Client ID parameter is missing.";
                                }

                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 pt-3 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
                        <div id="comments-container" class="col-md-12">
                            <h2 style="color:#2487ce;"><b>Comments</b></h2>
                            <br>

                            <?php

                            // Check if cater parameter is set in the GET request
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];

                                // Prepare and execute the SQL statement to fetch comments
                                $stmt = $DB_con->prepare("SELECT f.comment, f.rate, f.createdAt, u.firstname, u.lastname 
                                  FROM tbl_feedbacks f 
                                  JOIN tbl_users u ON f.customer_id = u.user_id 
                                  WHERE f.client_id = :id");
                                $stmt->bindValue(":id", $id, PDO::PARAM_STR);
                                $stmt->execute();

                                // Fetch the results as an associative array
                                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($comments) {
                                    ?>
                                    <div class="comments-info">
                                        <?php
                                        // Loop through the comments and display them
                                        foreach ($comments as $comment) {
                                            // Calculate time elapsed since createdAt
                                            $timeElapsed = getTimeElapsedString($comment['createdAt']);
                                            echo "<strong>{$comment['firstname']} {$comment['lastname']}</strong> <br> ";

                                            // Display rate stars based on the value of rate
                                            for ($i = 0; $i < 5; $i++) {
                                                if ($i < $comment['rate']) {
                                                    echo "<span style='color: black;'>★</span>";
                                                } else {
                                                    echo "<span style='color: #ccc;'>★</span>";
                                                }
                                            }

                                            echo "&nbsp; $timeElapsed<br>{$comment['comment']}<br><hr>";
                                        }
                                } else {
                                    echo "<div class='comments-info-none'>";
                                    echo "No comments found.";
                                }

                            } else {
                                echo "Cater parameter is missing.";
                            }

                            // Close the database connection
                            $db = null;

                            function getTimeElapsedString($datetime, $full = false)
                            {
                                $now = new DateTime;
                                $ago = new DateTime($datetime);
                                $diff = $now->diff($ago);

                                $diff->w = floor($diff->d / 7);
                                $diff->d -= $diff->w * 7;

                                $string = array(
                                    'y' => 'year',
                                    'm' => 'month',
                                    'w' => 'week',
                                    'd' => 'day',
                                    'h' => 'hour',
                                    'i' => 'minute',
                                    's' => 'second',
                                );

                                foreach ($string as $k => &$v) {
                                    if ($diff->$k) {
                                        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                    } else {
                                        unset($string[$k]);
                                    }
                                }

                                if (!$full)
                                    $string = array_slice($string, 0, 1);
                                return $string ? implode(', ', $string) . ' ago' : 'just now';
                            }
                            ?>
                            </div>
                            <br>
                            <?php if (!isset($_SESSION['user_id'])) { ?>
                                <div class="text-end col-12"><button class='btn-get-main' data-toggle="modal"
                                        data-target="#RedirectModal" data-dismiss="modal">Provide
                                        Feedback</button></div>
                            <?php } else { ?>
                                <div class="text-end col-12"><button class='btn-get-main' data-toggle="modal"
                                        data-target="#feedbackModal" data-dismiss="modal">Provide
                                        Feedback</button></div>
                            <?php } ?>
                        </div>

                    </div>

                </div>

            </div>
        </section><!-- End About Video Section -->
        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="faq" class="faq section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Frequently Asked Questions</h2>
                </div>

                <div class="faq-list">
                    <ul>

                        <?php
                        if (isset($_GET['id'])) {
                            $client_id = $_GET['id'];
                            // Fetch data from the database
                            $stmt = $DB_con->prepare("SELECT * FROM tblclient_faqs WHERE client_id = :client_id");

                            $stmt->bindParam(':client_id', $client_id);
                            $stmt->execute();
                            $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Check if there are any FAQs
                            if (count($faqs) === 0) { ?>
                                <li data-aos="fade-up">
                                    <p>Currently, there are no frequently asked questions on record. If you have any inquiries
                                        or need assistance, please don't hesitate to reach out.</p>
                                </li>
                            <?php } else {
                                foreach ($faqs as $faq): ?>
                                    <li data-aos="fade-up">
                                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
                                            data-bs-target="#faq-list-<?php echo $faq['faq_id']; ?>"><?php echo $faq['cater_question'] ?><i
                                                class="bx bx-chevron-down icon-show"></i><i
                                                class="bx bx-chevron-up icon-close"></i></a>
                                        <div id="faq-list-<?php echo $faq['faq_id']; ?>" class="collapse "
                                            data-bs-parent=".faq-list">
                                            <hr>
                                            <p>
                                                <?php echo $faq['cater_answer']; ?>
                                            </p>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php }
                        } else {
                            echo "No Catering FAQ found.";
                        } ?>
                    </ul>
                </div>

            </div>
        </section><!-- End Frequently Asked Questions Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                </div>

                <?php if (!empty($cater_gmaplink)): ?>
                    <div>
                        <iframe style="border:0; width: 100%; height: 270px;" src="<?php echo $cater_gmaplink; ?>"
                            frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php else: ?>
                    <div>
                        <p>No Google Map Available</p>
                    </div>
                <?php endif; ?>

                <div class="row mt-5">

                    <div class="col-lg-4">
                        <div class="info">
                            <?php if (!empty($cater_location)): ?>
                                <div class="address">
                                    <i class="bi bi-geo-alt"></i>
                                    <h4>Location:</h4>
                                    <p><?php echo $cater_location; ?></p>
                                </div>
                            <?php else: ?>
                                <div class="address">
                                    <i class="bi bi-geo-alt"></i>
                                    <h4>Location:</h4>
                                    <p>No Contact Location</p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($cater_email)): ?>
                                <div class="email">
                                    <i class="bi bi-envelope"></i>
                                    <h4>Email:</h4>
                                    <p><?php echo $cater_email ?></p>
                                </div>
                            <?php else: ?>
                                <div class="email">
                                    <i class="bi bi-envelope"></i>
                                    <h4>Email:</h4>
                                    <p>No Email Available</p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($cater_contactno)): ?>
                                <div class="phone">
                                    <i class="bi bi-phone"></i>
                                    <h4>Call:</h4>
                                    <p><?php echo $cater_contactno; ?></p>
                                </div>
                            <?php else: ?>
                                <div class="phone">
                                    <i class="bi bi-phone"></i>
                                    <h4>Call:</h4>
                                    <p>No Contact Number</p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($socmed_link)): ?>
                                <div class="phone">
                                    <i class='bx bx-git-merge'></i>
                                    <h4>Social Media:</h4>
                                    <a href="<?php echo $socmed_link; ?>">
                                        <p><u>Go to link</u></p>
                                    </a>

                                </div>
                            <?php else: ?>
                                <div class="phone">
                                    <i class='bx bx-git-merge'></i>
                                    <h4>Social Media:</h4>
                                    <p>No Social Media Available</p>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                    <div class="col-lg-8 mt-5 mt-lg-0">

                        <div class="row gy-2 gx-md-3">
                            <div id="contact_message"></div>
                            <div class="col-md-6 form-group">
                                <input type="text" name="customer_name" class="form-control" id="customer_name"
                                    placeholder="Your Name" required>
                                <input type="hidden" name="client_email" value="<?php echo $client_email; ?>"
                                    id="client_email">
                                <input type="hidden" name="client_username" value="<?php echo $clientUsername; ?>"
                                    id="client_username">
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="email" class="form-control" name="customer_email" id="customer_email"
                                    placeholder="Your Email" required>
                            </div>
                            <div class="form-group col-12">
                                <input type="text" class="form-control" name="customer_subject" id="customer_subject"
                                    placeholder="Subject" required>
                            </div>
                            <div class="form-group col-12">
                                <textarea class="form-control" name="customer_message" id="customer_message" rows="5"
                                    placeholder="Message" required></textarea>
                            </div>
                            <div class="text-end col-12"><button type="submit" class='btn-get-main'>Send
                                    Message</button></div>
                        </div>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->


        <!-- Feedback Modal -->
        <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Customer Review Form</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div id="review-message"></div>
                        </div>
                        <div class="form-group">
                            <p>We value your feedback. Please take a moment to review your experience with us.</p>
                        </div>
                        <div class="form-group">
                            <label for="rating">
                                <h5><b>Quality of Service:</b></h5>
                            </label>
                            <br>
                            <small>Rate the quality of service provided</small>
                            <br>
                            <div class="feedback-container">
                                <div class="container__items">
                                    <input type="radio" name="stars" id="st5" value="5">
                                    <label for="st5">
                                        <div class="star-stroke">
                                            <div class="star-fill"></div>
                                        </div>
                                        <div class="label-description" data-content="Excellent"></div>
                                    </label>
                                    <input type="radio" name="stars" id="st4" value="4">
                                    <label for="st4">
                                        <div class="star-stroke">
                                            <div class="star-fill"></div>
                                        </div>
                                        <div class="label-description" data-content="Good"></div>
                                    </label>
                                    <input type="radio" name="stars" id="st3" value="3">
                                    <label for="st3">
                                        <div class="star-stroke">
                                            <div class="star-fill"></div>
                                        </div>
                                        <div class="label-description" data-content="OK"></div>
                                    </label>
                                    <input type="radio" name="stars" id="st2" value="2">
                                    <label for="st2">
                                        <div class="star-stroke">
                                            <div class="star-fill"></div>
                                        </div>
                                        <div class="label-description" data-content="Bad"></div>
                                    </label>
                                    <input type="radio" name="stars" id="st1" value="1">
                                    <label for="st1">
                                        <div class="star-stroke">
                                            <div class="star-fill"></div>
                                        </div>

                                        <div class="label-description" data-content="Terrible"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="comments">Comments:</label>
                            <textarea class="form-control" id="comments" rows="3"></textarea>
                        </div>
                        <br>
                        <small style="color:red;font-size:0.8rem;font-style:italic;"><b>Notice:</b>
                            Kindly ensure all feedback is respectful.
                            Offensive content will be promptly deleted.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-get-del" data-dismiss="modal">Close</button>
                        <button type="button" class="btn-get-main" id="submitFeedback">Submit Feedback</button>
                    </div>
                </div>
            </div>
        </div>



    </main><!-- End #main -->

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
    <script src="assets/js/customer-message.js"></script>
    <script>
        var clientId = <?php echo json_encode($_GET['id']); ?>;
    </script>

    <script src="assets/js/fetch-feedbacks.js"></script>
    <script src="assets/js/submit-feedbacks.js"></script>

</body>

</html>