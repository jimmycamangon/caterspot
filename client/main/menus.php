<?php
include_once 'functions/fetch-menus.php';
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
                        <li class="breadcrumb-item active">Menus</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-bowl-food"></i>&nbsp;
                                <b>List of Items from Menu</b>
                                &nbsp; | &nbsp;
                                <button type="button" class="btn-get-main" data-toggle="modal"
                                    data-target="#AddNewModal">
                                    <i class="fa-solid fa-plus"></i> Add New
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th>Package</th>
                                        <th>Item Name</th>
                                        <th>Item Description</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Modified At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($menus as $menu): ?>
                                        <tr>
                                            <td>
                                                <?php echo $menu['package_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $menu['menu_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $menu['menu_description']; ?>
                                            </td>
                                            <td>
                                                <center><img
                                                        src="../../assets/img/menu-uploads/<?php echo $menu['menu_image']; ?>"
                                                        class="image-table" alt="No Image"></center>
                                            </td>
                                            <td>
                                                <?php echo $menu['menu_price']; ?>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php
                                                    if ($menu['availability'] == "Not available"): ?>
                                                        <span class="badge bg-danger">Not available</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Available</span>
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <?php echo $menu['createdAt']; ?>
                                            </td>
                                            <td>
                                                <button class="btn-get-main edit-btn" data-toggle="modal"
                                                    data-target="#editPackageModal"
                                                    data-menu-id="<?php echo $menu['menu_id'] ?>"><i
                                                        class="fa-solid fa-pen-to-square"></i>
                                                    Edit</button>
                                                <button class="btn-get-del" data-toggle="modal" data-target="#DeleteModal"
                                                    data-menu-id="<?php echo $menu['menu_id'] ?>"><i
                                                        class="fa-solid fa-trash"></i>
                                                    Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
                    <h5 class="modal-title" id="AddNewModalLabel">Add New Food Item</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>

                <div class="modal-body">
                    <div id="message"></div>

                    <!-- Add form -->
                    <div id="packageDropdownContainer" class="form-group">
                        <label for="package_id">Select Package:</label>
                        <select class="form-control" id="package_id" name="package_id">
                            <?php
                            // Fetch packages from tbl_packages
                            $sql = "SELECT package_id, package_name FROM tbl_packages WHERE client_id = :client_id";
                            $stmt = $DB_con->prepare($sql);
                            $stmt->bindParam(':client_id', $_SESSION['client_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Display options if available, otherwise show message
                            if ($packages) {
                                foreach ($packages as $package) {
                                    echo '<option value="' . $package['package_id'] . '">' . $package['package_name'] . '</option>';
                                }
                            } else {
                                echo '<option value="" disabled selected>No packages available. Please create a package first.</option>';
                                echo '</select>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="menu_name">Item Name:</label>
                        <input type="text" class="form-control" id="menu_name" name="menu_name">
                    </div>
                    <div class="form-group">
                        <label for="menu_description">Item Description:</label>
                        <textarea class="form-control" id="menu_description" name="menu_description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="menu_price">Item Price (Per pax):</label>
                        <input type="number" class="form-control" id="menu_price" name="menu_price"
                            oninput="validatePrice(this)">


                    </div>
                    <br>
                    <div class="form-group">
                        <label for="menu_image">Upload Image:</label>
                        <input type="file" class="form-control-file" id="menu_image" name="menu_image" accept="image/*"
                            onchange="upload()">
                    </div>

                    <br>
                    <div class="form-group" id="imagePreviewContainer" style="display: none;">
                        <center><canvas id="canv1" style="max-width: 200px;"></canvas></center>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-get-main my-4 py-2" style="width:100%;" id="AddMenu">Add
                            Item</button>
                    </div>
                </div>

            </div>
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
                    Are you sure you want to delete this item? This action will also remove any associated images found
                    in additional menu image pages, if they exist.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-main" data-dismiss="modal">Cancel</button>
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
                    <h5 class="modal-title" id="editPackageModalLabel">Edit Item</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>

                    <!-- Edit form -->
                    <div id="editPackageForm">
                        <!-- Existing dropdown for package -->
                        <div id="editPackageDropdownContainer" class="form-group">
                            <label for="edit_package_id">Select Package:</label>
                            <select class="form-control" id="edit_package_id" name="edit_package_id">
                                <?php
                                // Fetch packages from tbl_packages
                                if ($packages) {
                                    foreach ($packages as $package) {
                                        echo '<option value="' . $package['package_id'] . '">' . $package['package_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled selected>No packages available. Please create a package first.</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_menu_name">Item Name:</label>
                            <input type="text" class="form-control" id="edit_menu_name" name="edit_menu_name">
                        </div>
                        <div class="form-group">
                            <label for="edit_menu_description">Item Description:</label>
                            <textarea class="form-control" id="edit_menu_description"
                                name="edit_menu_description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_menu_price">Item Price (Per pax):</label>
                            <input type="number" class="form-control" id="edit_menu_price" name="edit_menu_price"
                                oninput="validatePrice(this)">
                        </div>
                        <!-- Dropdown for availability -->
                        <div class="form-group">
                            <label for="edit_availability">Availability:</label>
                            <select class="form-control" id="edit_availability" name="edit_availability">

                            </select>
                        </div>

                        <div class="form-group" id="editImagePreviewContainer" style="display: none;">
                            <label for="editCanv1">Image:</label>
                            <br>
                            <canvas id="editCanv1" style="max-width: 200px;"></canvas>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="edit_menu_image">Update Image:</label>
                            <input type="file" class="form-control-file" id="edit_menu_image" name="edit_menu_image"
                                accept="image/*" onchange="upload2()">
                        </div>
                        <br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-get-main" id="saveChangesBtn">Save changes</button>
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

        document.getElementById('saveChangesBtn').addEventListener('click', function (event) {
            // Get input values
            var packageId = document.getElementById('edit_package_id').value;
            var menuName = document.getElementById('edit_menu_name').value;
            var menuDescription = document.getElementById('edit_menu_description').value;
            var menuPrice = document.getElementById('edit_menu_price').value;
            var menuImage = document.getElementById('edit_menu_image').files.length > 0;

            // Check if any field has been modified
            if (packageId === "" && menuName === "" && menuDescription === "" && menuPrice === "" && !menuImage) {
                // If no changes, prevent form submission
                event.preventDefault();
                alert('Please make some changes before saving.');
            }
        });
    </script>
    <script src="functions/js/add-menus.js"></script>
    <script src="functions/js/upload-image.js"></script>
    <script src="functions/js/validate-price.js"></script>
    <script src="functions/js/delete-menus.js"></script>
    <script src="functions/js/edit-menu.js"></script>
    <script src="functions/js/edit-fetchimage-menu.js"></script>
</body>

</html>