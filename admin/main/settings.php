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
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>

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
                                <img src='../../assets/img/hero-bg4.jpg' class="img-fluid bg-image"
                                    alt="Responsive image">
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-main" type="submit" id="saveChangesBtn">Update Background
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
                                <div class="col mb-3">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-main" type="submit" id="saveChangesBtn">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-gear"></i>&nbsp;
                                <b>Frequently Asked Questions Section</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-main" type="submit" id="saveChangesBtn">Save Changes</button>
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
                                <div class="col mb-3">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn-get-main" type="submit" id="saveChangesBtn">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php require_once 'includes/footer.php'; ?>
        </div>
    </div>

    <!-- Add New Modal -->
    <div class="modal fade" id="AddNewModal" tabindex="-1" role="dialog" aria-labelledby="AddNewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="AddNewModalLabel">Add New Package</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>

                <div class="modal-body">
                    <div id="message"></div>

                    <!-- Add form -->

                    <div class="form-group">
                        <label for="package_name">Package Name:</label>
                        <input type="text" class="form-control" id="package_name" name="package_name">
                    </div>
                    <div class="form-group">
                        <label for="package_desc">Package Description:</label>
                        <textarea class="form-control" id="package_desc" name="package_desc"></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="package_image">Upload Image:</label>
                        <input type="file" class="form-control-file" id="package_image" name="package_image"
                            multiple="false" accept="image/*" onchange="upload()">
                    </div>
                    <br>
                    <div class="form-group" id="imagePreviewContainer" style="display: none;">
                        <center><canvas id="canv1" style="max-width: 200px;"></canvas></center>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn-get-main  py-2" value="Add" style="width:100% !important;"
                            id="AddPackage">
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                    <div id="messages"></div>
                </div>
                <div class="modal-footer" id="returnDel">
                    <button type="button" class="btn-get-main" data-dismiss="modal">Back</button>
                </div>
                <div class="modal-footer" id="conformeDel">
                    <button type="button" class="btn-get-main" data-dismiss="modal">Back</button>
                    <button type="button" class="btn-get-del" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editPackageModal" tabindex="-1" role="dialog" aria-labelledby="editPackageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPackageModalLabel">Edit Package</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>

                    <!-- Edit form -->
                    <div class="form-group">
                        <label for="edit_package_name">Package Name:</label>
                        <input type="text" class="form-control" id="edit_package_name" name="edit_package_name">
                    </div>
                    <div class="form-group">
                        <label for="edit_package_desc">Package Description:</label>
                        <textarea class="form-control" id="edit_package_desc" name="edit_package_desc"></textarea>
                    </div>
                    <div class="form-group" id="editImagePreviewContainer" style="display: none;">
                        <label for="editCanv1">Image:</label>
                        <br>
                        <canvas id="editCanv1" style="max-width: 200px;"></canvas>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="edit_package_image">Update Image:</label>
                        <input type="file" class="form-control-file" id="edit_package_image" name="edit_package_image"
                            accept="image/*" onchange="upload2()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-main" id="saveChangesBtn">Save changes</button>
                    <button type="button" class="btn-get-del" data-dismiss="modal">Close</button>
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
    <script src="functions/js/add-package.js"></script>
    <script src="functions/js/delete-package.js"></script>
    <script src="functions/js/edit-package.js"></script>
    <script src="functions/js/upload-package-image.js"></script>
    <script src="functions/js/edit-fetchimage-package.js"></script>
</body>

</html>