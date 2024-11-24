<?php
require_once '../../config/conn.php';
require_once 'functions/fetch-admin.php';
require_once 'functions/sessions.php';
include_once 'functions/fetch-feedbacks.php';

redirectToLogin();

$sql = "SELECT COUNT(*) AS user_count FROM tbl_users";

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of the current month
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');   // Last day of the current month

// Prepare the statement
$stmt = $DB_con->prepare($sql);
// Execute the query
$stmt->execute();
// Fetch the result
$row = $stmt->fetch(PDO::FETCH_ASSOC);
// Get the user count
$user_count = $row['user_count'];

// ======

$sql2 = "SELECT COUNT(*) AS client_count FROM tbl_clients";

// Prepare the statement
$stmt2 = $DB_con->prepare($sql2);
// Execute the query
$stmt2->execute();
// Fetch the result
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
// Get the user count
$client_count = $row2['client_count'];

// ======

$sql3 = "SELECT COUNT(*) AS application_count FROM tbl_applications";

// Prepare the statement
$stm3 = $DB_con->prepare($sql3);
// Execute the query
$stm3->execute();
// Fetch the result
$row3 = $stm3->fetch(PDO::FETCH_ASSOC);
// Get the user count
$application_count = $row3['application_count'];

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
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h4><?php echo $user_count; ?></h4>Total Customers
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="customers.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <h4><?php echo $client_count ?></h4>Total Clients
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="clients.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <h4>
                                        <?php echo $application_count ?>
                                    </h4> Total Applications
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="applications.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <form method="GET" action="index.php" class="mb-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="<?php echo $startDate; ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" name="end_date" class="form-control"
                                        value="<?php echo $endDate; ?>">
                                </div>
                                <div class="col-md-2 align-self-end">
                                    <button type="submit" class="btn-get-main"><i class="fa-solid fa-filter"></i> &nbsp;
                                        Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Daily tax report
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Monthly tax report
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Best Performing Catering Services
                        </div>
                        <div class="card-body"><canvas id="topCaterChart" width="100%" height="30"></canvas></div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Feedbacks Section
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Review To</th>
                                        <th>Comment</th>
                                        <th>Rate</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($feedbacks as $feedback): ?>
                                        <tr>
                                            <td>
                                                <?php echo $feedback['firstname'] . ' ' . $feedback['lastname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $feedback['cater_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $feedback['comment']; ?>
                                            </td>
                                            <td>
                                                <?php echo $feedback['rate']; ?>
                                            </td>
                                            <td>
                                                <?php echo $feedback['createdAt']; ?>
                                            </td>
                                            <td>
                                                <button class="btn-get-del" data-toggle="modal" data-target="#DeleteModal"
                                                    data-customer-id="<?php echo $feedback['customer_id'] ?>"
                                                    data-feed-id="<?php echo $feedback['id'] ?>"><i
                                                        class="fa-solid fa-trash"></i>
                                                    Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog"
                            aria-labelledby="DeleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="DeleteModalLabel">Delete Confirmation</h5>
                                        <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;"
                                            data-dismiss="modal" aria-label="Close"></i>
                                    </div>
                                    <div class="modal-body">
                                        <div id="message"></div>
                                        Are you sure you want to delete this Review?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-get-main" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn-get-del" id="confirmDeleteBtn">Delete</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="functions/js/chart-tax-perday.js"></script>
    <script src="functions/js/chart-tax-permonth.js"></script>
    <script src="functions/js/chart-top-cater.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/datatables-simple-demo.js"></script>

    <!-- Modal -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="functions/js/delete-review.js"></script>
</body>

</html>