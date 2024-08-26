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
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-user"></i>&nbsp;
                                <b>Profile</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="e-profile">
                                <div id="message"></div>
                                <div class="row">
                                    <div class="col-12 col-sm-auto mb-3">
                                        <div class="mx-auto" style="width: 110px;">
                                            <div class="d-flex justify-content-center align-items-center rounded"
                                                style="height: 140px; background-color: rgb(233, 236, 239);">
                                                <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">

                                                    <?php
                                                    $image_path = '../../assets/img/client-images/' . $client_img;
                                                    if (file_exists($image_path) && is_file($image_path)) {
                                                        // If image exists, use it
                                                        $image_source = $image_path;
                                                    } else {
                                                        // If image doesn't exist, use placeholder
                                                        $image_source = '../../assets/img/client-images/Image_not_available.jpg';
                                                    } ?>

                                                    <img src="<?php echo $image_source; ?>"
                                                        alt="" style="height: 140px;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                                            <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $client_username; ?>
                                            </h4>
                                            <p class="mb-0"><?php echo $client_email ?></p>
                                            <div class="mt-2">
                                                <button class="btn-get-main edit-profile" type="button" data-toggle="modal"
                                                    data-target="#editBGModal"
                                                    data-profile-id="<?php echo $_SESSION['client_id'] ?>">
                                                    <i class="fa fa-fw fa-camera"></i>
                                                    <span>Change Photo</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-center text-sm-right">
                                            <span class="badge badge-secondary">administrator</span>
                                            <div class="text-muted"><small>Joined <?php echo $client_joined ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content pt-3">
                                    <div class="tab-pane active">
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="hidden" id="edit_client_id"
                                                                value="<?php echo $_SESSION['client_id']; ?>"
                                                                name="edit_client_id">
                                                            <label>Username</label>
                                                            <input class="form-control" type="text" name="edit_username"
                                                                id="edit_username"
                                                                value="<?php echo $client_username ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Contact No.</label>
                                                            <input class="form-control" type="text" name="contact"
                                                                id="contact" value="<?php echo $client_contact ?>">
                                                        </div>

                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input class="form-control" type="text" name="edit_email"
                                                                id="edit_email" value="<?php echo $client_email ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <div class="mb-2 modal-header"><b>Change Password</b></div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>New Password</label>
                                                            <input class="form-control" type="password" name="newpass"
                                                                id="newpass" id="newpass">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Confirm <span
                                                                    class="d-none d-xl-inline">Password</span></label>
                                                            <input class="form-control" type="password" id="confirmpass"
                                                                name="confirmpass" id="confirmpass">
                                                        </div>
                                                    </div>
                                                            <small id="passwordLengthMessage"
                                                                style="color: red;display:none;">&#9679; Password must
                                                                be at least 8
                                                                characters long.</small><br>
                                                            <small id="passwordUppercaseMessage"
                                                                style="color: red;display:none;">&#9679; Password must
                                                                contain at
                                                                least one
                                                                uppercase letter.</small><br>
                                                            <small id="passwordSpecialCharMessage"
                                                                style="color: red;display:none;">
                                                                &#9679; Password must contain at
                                                                least one
                                                                special character.</small><br>
                                                            <small id="confirmPasswordMessage"
                                                                style="color: red;display:none;">&#9679; Passwords do
                                                                not
                                                                match.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col d-flex justify-content-end">
                                                <button class="btn-get-main" type="submit" id="saveChangesBtn">Save
                                                    Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </main>
            <?php require_once 'includes/footer.php'; ?>
        </div>
    </div>



    <!-- Edit Modal -->
    <div class="modal fade" id="editBGModal" tabindex="-1" role="dialog" aria-labelledby="editBGModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBGModalLabel">Update Profile Picture</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>
                    <div class="form-group" id="editImagePreviewContainer" style="display: none;">
                        <label for="editCanv1">Profile Image:</label>
                        <br>
                        <canvas id="editCanv1" style="max-width: 150px;height:200px;"></canvas>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="edit_profile_image">Update Image:</label>
                        <input type="file" class="form-control-file" id="edit_profile_image" name="edit_profile_image"
                            accept="image/*" onchange="upload2()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-get-main" id="saveChangesBtn_profile">Save changes</button>
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
    <script src="functions/js/validate-profile.js"></script>
    <script src="functions/js/edit-fetchimage-profile.js"></script>
    <script src="functions/js/update-profile-img.js"></script>
</body>

</html>