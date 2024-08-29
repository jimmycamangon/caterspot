<?php
include_once 'functions/fetch-clients.php';
require_once 'functions/sessions.php';

redirectToLogin();

// Fetch the client ID from the query string or another source
$client_id = isset($_GET['client_id']) ? intval($_GET['client_id']) : 0;

// Initialize a flag for the application existence
$applicationFound = false;

// Fetch application data based on client ID
$sql = 'SELECT * FROM tbl_applications WHERE client_id = :client_id';
$stmt = $DB_con->prepare($sql);
$stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
$stmt->execute();
$application = $stmt->fetch(PDO::FETCH_ASSOC);

if ($application) {
    $applicationFound = true;

    // Decode file paths from JSON
    $permitPaths = json_decode($application['permit']);
    $menuPaths = json_decode($application['menu']);
    $businessImgPaths = json_decode($application['business_img']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CaterSpot</title>
    <!-- Favicons -->
    <link href="../../assets/img/favicon.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../vendor/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
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
    <script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

</head>



<body class="sb-nav-fixed">
    <?php require_once 'includes/top-nav.php'; ?>
    <div id="layoutSidenav">
        <?php require_once 'includes/left-nav.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <br>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item"><a href="applications.php" class="link-ref">Applications</a></li>
                        <li class="breadcrumb-item active">Client Application Details</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-cube"></i>&nbsp;
                                <b>Client Application Details</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($applicationFound): ?>
                                <div class="row">
                                    <!-- Details Column -->
                                    <div class="col-md-6">
                                        <div class="application-container">
                                            <h5><b>Business Name:</b>
                                                <?php echo htmlspecialchars($application['business_name']); ?></h5>
                                            <p><b>Owner:</b> <?php echo htmlspecialchars($application['owner']); ?></p>
                                            <p><b>Contact Number:</b>
                                                <?php echo htmlspecialchars($application['contact_number']); ?></p>
                                            <p><b>Email:</b> <?php echo htmlspecialchars($application['gmail']); ?></p>
                                            <p><b>Region:</b> <?php echo htmlspecialchars($application['region']); ?></p>
                                            <p><b>Province:</b> <?php echo htmlspecialchars($application['province']); ?>
                                            </p>
                                            <p><b>City:</b> <?php echo htmlspecialchars($application['city']); ?></p>
                                            <p><b>Street:</b> <?php echo htmlspecialchars($application['street']); ?></p>
                                        </div>
                                    </div>
                                    <!-- Files Column -->
                                    <div class="col-md-6">
                                        <div class="application-container">
                                            <h5><b>Permit Files:</b></h5>
                                            <?php if (!empty($permitPaths)): ?>
                                                <ul>
                                                    <?php foreach ($permitPaths as $path): ?>
                                                        <li><a href="../<?php echo htmlspecialchars($path); ?>" target="_blank">View
                                                                Permit File <i class="fa-solid fa-paperclip"></i></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p>No permit files uploaded.</p>
                                            <?php endif; ?>

                                            <h5><b>Menu Files:</b></h5>
                                            <?php if (!empty($menuPaths)): ?>
                                                <ul>
                                                    <?php foreach ($menuPaths as $path): ?>
                                                        <li><a href="../<?php echo htmlspecialchars($path); ?>" target="_blank">View
                                                                Menu File <i class="fa-solid fa-paperclip"></i></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p>No menu files uploaded.</p>
                                            <?php endif; ?>

                                            <h5><b>Business Images:</b></h5>
                                            <div class="b-images">
                                                <?php if (!empty($businessImgPaths)): ?>
                                                        <?php foreach ($businessImgPaths as $path): ?>
                                                            <a href="../<?php echo htmlspecialchars($path); ?>"
                                                                class="glightbox menu-img" data-glightbox="gallery">
                                                                <img src="../<?php echo htmlspecialchars($path); ?>"
                                                                    class="img-thumbnail" alt="Business Image" />
                                                            </a>
                                                        <?php endforeach; ?>
                                                <?php else: ?>
                                                    <p>No business images uploaded.</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="text-end">
                                            <?php if ($application['status'] === 'Approved') { ?>
                                                <!-- If status is Approved, display the status text -->
                                                <b>Status:</b> <span
                                                    class="badge bg-success"><?php echo $application['status'] ?></span>
                                            <?php } else if ($application['status'] === 'Rejected') { ?>
                                                    <!-- If status is Approved, display the status text -->
                                                    <b>Status:</b> <span
                                                        class="badge bg-danger"><?php echo $application['status'] ?></span>
                                            <?php } else { ?>
                                                    <!-- If status is not Approved, display the approval button -->
                                                    <button class="btn-get-main view-btn" data-toggle="modal"
                                                        data-target="#ApproveModal"
                                                        data-client-id="<?php echo htmlspecialchars($client['client_id']); ?>">
                                                        <i class="fa-solid fa-check-to-slot"></i> Approve application
                                                    </button>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </div>
                            <?php else: ?>
                                <div class="not-found">
                                    <h4>Client ID Not Found</h4>
                                    <p>No application exists for the provided client ID. Please check the ID and try again.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
            <?php require_once 'includes/footer.php'; ?>
        </div>
    </div>


    <div class="modal fade" id="ApproveModal" tabindex="-1" role="dialog" aria-labelledby="ApproveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ApproveModalLabel">Approval Confirmation</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    Are you sure you want to approve the application of this client?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-get-main" id="confirmApprove">Approve</button>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <!-- Modal CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="../vendor/js/datatables-simple-demo.js"></script>
    <script src="functions/js/approve-client.js"></script>

    <script>
        $(document).ready(function () {
            $('#confirmApprove').click(function () {
                var client_id = '<?php echo $client_id; ?>';
                approveApplication(client_id);
            });
        });

        // Initialize GLightbox once when the document is ready
        const lightbox = GLightbox({
            selector: ".glightbox",
            touchNavigation: true,
            loop: true,
            closeOnOutsideClick: true,
            closeButton: true,
            slideEffect: "fade",
            openEffect: "fade",
            closeEffect: "fade",
            autoplayVideos: true,
            videoMaxWidth: 800,
            keyboardNavigation: true
        });

        // Initialize lightbox with custom configuration
        var lightbox2 = GLightbox({
            selector: '.glightboxs',
            loop: true, // Enable looping through images
            touchNavigation: true, // Enable touch navigation
            closeOnOutsideClick: true, // Close lightbox when clicking outside the content
            closeButton: true, // Show close button
            closeOnEscape: true, // Close lightbox when pressing the escape key
            autoplayVideos: true, // Autoplay YouTube/Vimeo videos
            plyr: {
                settings: ['quality', 'speed', 'loop'], // Customize Plyr settings
            },
        });

    </script>
</body>

</html>