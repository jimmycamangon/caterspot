<?php
include_once 'functions/fetch-client.php';
require_once 'functions/sessions.php';

redirectToLogin();
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

    <!-- text editor cdn -->
    <script src="https://cdn.tiny.cloud/1/msqxe7rp8pw2s5wyjimvt8lkxjppsksmim20cpk0scm0slrz/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>


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
                        <li class="breadcrumb-item"><a href="index.php" class="link-ref">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                    <input type="hidden" id="edit_client_id" value="<?php echo $_SESSION['client_id']; ?>"
                        name="edit_client_id">

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-gear"></i>&nbsp;
                                <b>Catering Description Section</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="form-group">
                                        <div id="message_desc"></div>
                                        <textarea class="form-control" rows="5" id="description"
                                            name="description"><?php echo trim($client_description); ?></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-main" type="submit" id="saveChangesBtn_description">Save
                                        Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-gear"></i>&nbsp;
                                <b>Background Image</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-info" role="alert" style="font-size:0.8rem;">
                                            <b>Notice:</b> <i style>For optimal display, we recommend using background
                                                images
                                                with dimensions that are at least 1920 x 1080 pixels. Larger images may
                                                provide better quality and flexibility for different screen sizes and
                                                resolutions.</i>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="bg-img-setting">
                                <img src='../../assets/img/client-images/<?php echo $client_bg_image; ?>'
                                    class="img-fluid bg-image" alt="No Background image available.">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-main edit-bg" type="submit" id="saveChangesBtn_bgimage"
                                        data-toggle="modal" data-target="#editBGModal"
                                        data-bg-id="<?php echo $_SESSION['client_id'] ?>">Update
                                        Background
                                        Image</button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-gear"></i>&nbsp;
                                <b>About Us Section</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div id="message_about"></div>
                                <div class="col mb-3">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="about_us"
                                            name="about_us"><?php echo trim($client_about_us); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-main" type="submit" id="saveChangesBtn_about">Save
                                        Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    $client_id = $_SESSION['client_id'];

                    // Fetch data from the database
                    $stmt = $DB_con->prepare("SELECT * FROM tblclient_faqs WHERE client_id = :client_id");

                    $stmt->bindParam(':client_id', $client_id);
                    $stmt->execute();
                    $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Check if there are any FAQs
                    if (count($faqs) === 0) {
                        echo '<div class="card mb-4">';
                        echo '<div class="card-header">';
                        echo '<div class="form-group">';
                        echo '<i class="fa-solid fa-gear"></i>&nbsp;';
                        echo '<b>Frequently Asked Questions Section</b>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<div id="message_faq"></div>';
                        echo '<div class="alert alert-info" role="alert" style="font-size:0.8rem;">';
                        echo 'No FAQ\'s existing. Create a new one.';
                        echo '</div>';
                    } else {
                        // If there are existing FAQs, display them
                        ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="form-group">
                                    <i class="fa-solid fa-gear"></i>&nbsp;
                                    <b>Frequently Asked Questions Section</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="message_faq"></div>
                                <div class="row">
                                    <?php foreach ($faqs as $faq): ?>
                                        <div class="card-body">
                                            <div class="faq-card">
                                                <?php echo $faq['cater_question']; ?>
                                                <button class="edit-faq btn-get-main" type="submit"
                                                    data-faq-id="<?php echo $faq['faq_id']; ?>">Edit</button>
                                                <input type="hidden" id="edit_faq_id" name="edit_faq_id"
                                                    value="<?php echo $faq['faq_id']; ?>">
                                                <button class="del-faq btn-get-del" type="button"
                                                    data-faqs-id="<?php echo $faq['faq_id']; ?>" data-toggle="modal"
                                                    data-target="#DeleteModal">Delete</button>


                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="modal-header"><b>Frequently asked:</b></p>
                                    <div class="form-group">
                                        <input type="hidden" id="edit_faq_id" name="edit_faq_id">
                                        <textarea class="form-control" rows="5" id="question"
                                            name="question"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="modal-header"><b>Your response:</b></p>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="answer" name="answer"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-del edit-faqs" type="submit" id="newChangesBtn"
                                        style="display: none;">Cancel</button> &nbsp;
                                    <button class="btn-get-main" type="submit" id="saveChangesBtn-faq">Add New
                                        FAQ</button>
                                    &nbsp;
                                    <button class="btn-get-main" type="submit" id="EditChangesBtn"
                                        style="display: none;">Save
                                        Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-gear"></i>&nbsp;
                                <b>Contact Section</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div id="message_contact"></div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div id="message_desc"></div>
                                        <label for="cater_email">Your Catering Name:</label>
                                        <input type="text" class="form-control" name="cater_name" id="cater_name"
                                            value="<?php echo trim($client_cater_name); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cater_location">Your Location:</label>
                                        <input type="text" class="form-control" name="cater_location"
                                            id="cater_location" value="<?php echo trim($client_cater_location); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cater_email">Your Email:</label>
                                        <input type="text" class="form-control" name="cater_email" id="cater_email"
                                            value="<?php echo trim($client_cater_email); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cater_contactno">Your Contact No:</label>
                                        <input type="text" class="form-control" name="cater_contactno"
                                            id="cater_contactno" value="<?php echo trim($client_cater_contactno); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="socmed_link">Social Media Link:</label>
                                        <input type="text" class="form-control" name="socmed_link" id="socmed_link"
                                            value="<?php echo trim($socmed_link); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div id="instructions" class="alert alert-info" role="alert">
                                        <p><strong>Instructions for Adding Google Maps Address to Input Field</strong>
                                        </p>
                                        <ol>
                                            <li>Find Address on Google Maps:
                                                <ul>
                                                    <li>Go to Google Maps and search for the desired address.</li>
                                                    <li>Right-click on the pin marker and select "What's here?"</li>
                                                    <li>Click "Share" and then "Embed a map" to get the HTML code.</li>
                                                </ul>
                                            </li>
                                            <li>Insert into Input Field:
                                                <ul>
                                                    <li>Copy the Google Maps link starting from "https://" (excluding
                                                        the iframe part).</li>
                                                    <li>Paste the link directly into the input field below:</li>
                                                </ul>
                                            </li>
                                        </ol>
                                        <p>For detailed instructions with visuals, visit <a
                                                href="https://support.google.com/maps/answer/144361?co=GENIE.Platform%3DDesktop&hl=en"
                                                target="_blank">Google's guide</a>.</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="cater_gmaplink">Your Google Map Link (Paste the link here):</label>
                                        <input type="text" class="form-control" name="cater_gmaplink"
                                            id="cater_gmaplink" value="<?php echo trim($client_cater_gmaplink); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-main" type="submit" id="saveChangesBtn_contact">Save
                                        Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php require_once 'includes/footer.php'; ?>
        </div>
    </div>




    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel">Delete Confirmation</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    Are you sure you want to delete this FAQ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-main" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-get-del" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editBGModal" tabindex="-1" role="dialog" aria-labelledby="editBGModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBGModalLabel">Update Background Image</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>
                    <div class="form-group" id="editImagePreviewContainer" style="display: none;">
                        <label for="editCanv1">Background Image:</label>
                        <br>
                        <canvas id="editCanv1" style="max-width: 200px;"></canvas>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="edit_bg_image">Update Image:</label>
                        <input type="file" class="form-control-file" id="edit_bg_image" name="edit_bg_image"
                            accept="image/*" onchange="upload2()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-get-main" id="saveChangesBtn_bg">Save changes</button>
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


    <script src="../vendor/js/datatables-simple-demo.js"></script>
    <script>
        var clientId = <?php echo json_encode($_SESSION['client_id']); ?>;
    </script>
    <script>
        // Initialize TinyMCE editor
        var editor = tinymce.init({
            selector: 'textarea',
            plugins: 'lists',
            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
            menubar: false,
            branding: false,
            statusbar: false,
            resize: false,
            setup: function (editor) {
                editor.on('change', function () {
                    // Update the underlying textarea with TinyMCE content
                    editor.save();
                });
            }
        });


    </script>
    <script src="functions/js/validate-settings.js"></script>
    <script src="functions/js/edit-fetchimage-bg.js"></script>
</body>

</html>