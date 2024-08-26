<?php
require_once '../../config/conn.php';
require_once 'functions/fetch-client.php';
require_once 'functions/sessions.php';
include_once 'functions/fetch-feedbacks.php';

redirectToLogin();

// Get date range from the request or set defaults
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of the current month
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');   // Last day of the current month

// Prepare the base query
$query = "SELECT COUNT(CASE WHEN A.status = 'Pending' THEN 1 END) AS pending_count, 
          COUNT(CASE WHEN A.status = 'Booked' THEN 1 END) AS approved_count, 
          COUNT(CASE WHEN A.status = 'Completed' THEN 1 END) AS completed_count, 
          COUNT(CASE WHEN A.status = 'Rejected' OR A.status = 'Request for cancel' THEN 1 END) AS rejected_count 
          FROM tbl_orders AS A 
          LEFT JOIN tblclient_settings AS B ON A.cater = B.cater_name 
          LEFT JOIN tbl_userinformationorder AS C ON A.transactionNo = C.transactionNo
          WHERE A.cater = :username";

// Add date range filtering if dates are provided
if ($startDate && $endDate) {
    $query .= " AND C.created_at BETWEEN :start_date AND :end_date";
}

$stmt = $DB_con->prepare($query);
$stmt->bindParam(':username', $client_cater_name, PDO::PARAM_STR);

if ($startDate && $endDate) {
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
}

$stmt->execute();
$status_counts = $stmt->fetch(PDO::FETCH_ASSOC);

// Initialize counts to zero if no data
$status_counts = array_merge([
    'pending_count' => 0,
    'approved_count' => 0,
    'completed_count' => 0,
    'rejected_count' => 0,
], $status_counts);

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
                    <form method="GET" action="index.php" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="<?php echo $startDate; ?>">
                            </div>
                            <div class="col-md-2">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" class="form-control" value="<?php echo $endDate; ?>">
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn-get-main"><i class="fa-solid fa-filter"></i> &nbsp;
                                    Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <h4>
                                        <?php echo $status_counts['pending_count']; ?>
                                    </h4>Pendings
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="pendings.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h4>
                                        <?php echo $status_counts['approved_count']; ?>
                                    </h4>Booked
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="booked.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <h4>
                                        <?php echo $status_counts['completed_count']; ?>
                                    </h4>Completed
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="completed.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <h4>
                                        <?php echo $status_counts['rejected_count']; ?>
                                    </h4> Rejected / Request for cancellation
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="reject_cancel.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Revenue per Day
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Revenue per Month
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Feedback Section
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="functions/js/chart-revenue-perday.js"></script>
    <script src="functions/js/chart-revenue-permonth.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>


    <script src="../vendor/js/datatables-simple-demo.js"></script>
</body>

</html>