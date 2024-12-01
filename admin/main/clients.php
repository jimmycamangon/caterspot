<?php
include_once 'functions/fetch-clients.php';
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
                        <li class="breadcrumb-item active">Clients</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-cube"></i>&nbsp;
                                <b>List of Clients</b>
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
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Image</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($clients as $client): ?>
                                        <tr>
                                            <td>
                                                <?php echo $client['username']; ?>
                                            </td>
                                            <td>
                                                <?php echo $client['email']; ?>
                                            </td>
                                            <td>
                                                <center><img
                                                        src="../../assets/img/client-images/<?php echo $client['client_image']; ?>"
                                                        class="image-table" alt="No Uploaded Image"></center>
                                            </td>
                                            <td>
                                                <?php echo $client['contact']; ?>
                                            </td>
                                            <td>
                                                <?php echo $client['address']; ?>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php
                                                    if ($client['status'] == "Unavailable" || $client['status'] == ""): ?>
                                                        <span class="badge bg-danger">Unavailable</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Available</span>
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <button class="btn-get-main edit-btn" data-toggle="modal"
                                                    data-target="#editStatus"
                                                    data-status-id="<?php echo $client['client_id'] ?>"><i
                                                        class="fa-solid fa-pen-to-square"></i>
                                                    Edit Status</button>
                                                <button class="btn-get-del" data-toggle="modal" data-target="#DeleteModal"
                                                    data-client-id="<?php echo $client['client_id'] ?>"><i
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
                    <h5 class="modal-title" id="AddNewModalLabel">Add New Client</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>

                <div class="modal-body">
                    <div id="message"></div>

                    <!-- Add form -->

                    <div class="form-group">
                        <label for="cater_name">Catering Name:</label>
                        <select class="form-control" id="cater_name" name="cater_name">
                            <option value="" selected disabled>Select a Catering Name</option>
                            <?php
                            // Fetch catering names from the database
                            $sql = "SELECT business_name FROM tbl_applications WHERE status = 'Approved'";
                            $result = $DB_con->query($sql);
                            if ($result->rowCount() > 0) {
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['business_name'] . '">' . $row['business_name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" disabled>
                    </div>
                    <div class="form-group">
                        <label for="password">Temporary Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <br>
                    <div class="form-group">
                        <input type="submit" class="btn-get-main  py-2" value="Add" style="width:100% !important;"
                            id="Addclient">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStatus" tabindex="-1" role="dialog" aria-labelledby="editStatusLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusLabel">Edit Status</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>

                    <!-- Edit form -->
                    <div id="editPackageForm">
                        <!-- Dropdown for availability -->
                        <div class="form-group">
                            <label for="edit_status">Status:</label>
                            <select class="form-control" id="edit_status" name="edit_status">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-get-main" id="saveChangesBtn">Save changes</button>
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
                    <div id="message"></div>
                    Are you sure you want to delete this Client?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-main" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-get-del" id="confirmDeleteBtn">Delete</button>
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
        var clientId = <?php echo $client['client_id'] ?>;
    </script>
    <script src="functions/js/add-clients.js"></script>
    <script src="functions/js/delete-client.js"></script>
    <script src="functions/js/edit-available.js"></script>
</body>

</html>