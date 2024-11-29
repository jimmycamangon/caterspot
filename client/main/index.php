<?php
require_once '../../config/conn.php';
require_once 'functions/fetch-client.php';
require_once 'functions/sessions.php';
include_once 'functions/fetch-feedbacks.php';

redirectToLogin();
$client_id = $_SESSION['client_id'];

// Get date range from the request or set defaults
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of the current month
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');   // Last day of the current month

// Prepare the base query to count statuses, including the client_id condition
$query = "
    SELECT COUNT(CASE WHEN A.status = 'Pending' THEN 1 END) AS pending_count, 
           COUNT(CASE WHEN A.status = 'Booked' THEN 1 END) AS approved_count, 
           COUNT(CASE WHEN A.status = 'Completed' THEN 1 END) AS completed_count, 
           COUNT(CASE WHEN A.status = 'Rejected' OR A.status = 'Request for cancel' THEN 1 END) AS rejected_count 
    FROM tbl_orders AS A 
    LEFT JOIN tblclient_settings AS B ON A.cater = B.cater_name 
    LEFT JOIN tbl_userinformationorder AS C ON A.transactionNo = C.transactionNo
    WHERE A.cater = :username AND B.client_id = :client_id";

// Add date range filtering if dates are provided
if ($startDate && $endDate) {
    $query .= " AND C.created_at BETWEEN :start_date AND :end_date";
}

$stmt = $DB_con->prepare($query);
$stmt->bindParam(':username', $client_cater_name, PDO::PARAM_STR);
$stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT); // Ensure you're binding the correct client_id here

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

// Prepare query to calculate total revenue for the current month with optional date filtering
$currentMonth = date('Y-m');
$currentMonthRevenueQuery = "
    SELECT SUM(revenue) AS total_revenue 
    FROM tblclient_revenue_stats 
    LEFT JOIN tbl_clients AS D ON tblclient_revenue_stats.client_id = D.client_id
    WHERE DATE_FORMAT(collectedAt, '%Y-%m') = :currentMonth AND tblclient_revenue_stats.client_id = :client_id";

// Add date range condition if filters are provided
if ($startDate && $endDate) {
    $currentMonthRevenueQuery .= " AND collectedAt BETWEEN :start_date AND :end_date";
}

$stmt = $DB_con->prepare($currentMonthRevenueQuery);
$stmt->bindParam(':currentMonth', $currentMonth, PDO::PARAM_STR);
$stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT); // Ensure you're binding the correct client_id here

if ($startDate && $endDate) {
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
}

$stmt->execute();
$currentRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

// Prepare the previous month's value with the same client_id filter
$lastMonth = date('Y-m', strtotime('-1 month'));

$lastMonthRevenueQuery = "
    SELECT SUM(revenue) AS total_revenue 
    FROM tblclient_revenue_stats 
    LEFT JOIN tbl_clients AS D ON tblclient_revenue_stats.client_id = D.client_id
    WHERE DATE_FORMAT(collectedAt, '%Y-%m') = :lastMonth AND tblclient_revenue_stats.client_id = :client_id";

$stmt = $DB_con->prepare($lastMonthRevenueQuery);
$stmt->bindParam(':lastMonth', $lastMonth, PDO::PARAM_STR);
$stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT); // Ensure you're binding the correct client_id here
$stmt->execute();
$lastRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

// Calculate the percentage change
if ($lastRevenue > 0) {
    $percentageChange = (($currentRevenue - $lastRevenue) / $lastRevenue) * 100;
} else {
    $percentageChange = $currentRevenue > 0 ? 100 : 0; // Assume 100% increase if no revenue last month
}

// Determine the label for the month or date range
if ($startDate && $endDate && $startDate !== date('Y-m-01') && $endDate !== date('Y-m-t')) {
    // Convert start and end dates to readable format (e.g., July 01, 2024)
    $startMonthName = date('F d, Y', strtotime($startDate));
    $endMonthName = date('F d, Y', strtotime($endDate));
    $filteredMonthLabel = "$startMonthName and $endMonthName";
} else {
    // Default to the current month
    $filteredMonthLabel = "Month of " . date('F');
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
                    <form id="filter-form" method="GET" action="index.php" class="mb-4">
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
                        <!-- KPI Cards: Pending -->
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

                        <!-- KPI Cards: Booked -->
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

                        <!-- KPI Cards: Completed -->
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

                        <!-- KPI Cards: Rejected -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <h4>
                                        <?php echo $status_counts['rejected_count']; ?>
                                    </h4>Rejected / Request for cancellation
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="reject_cancel.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actual Sales KPI Card -->
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card text-white mb-4"
                                style="background: #3a3939; color: white; margin-bottom: 1.5rem;">
                                <div class="card-body">
                                    <h4>₱<?php echo number_format($currentRevenue, 2); ?></h4>
                                    Actual Sales as of <?php echo $filteredMonthLabel; ?>
                                    <p>
                                        <?php if ($percentageChange > 0): ?>
                                            <span class="text-success">
                                                <i class="fas fa-arrow-up"></i>
                                                +<?php echo number_format($percentageChange, 2); ?>%
                                            </span>
                                        <?php elseif ($percentageChange < 0): ?>
                                            <span class="text-danger">
                                                <i class="fas fa-arrow-down"></i>
                                                <?php echo number_format($percentageChange, 2); ?>%
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">No Change</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="sales-details.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fa-solid fa-chart-line"></i>
                                    Performance Rating
                                </div>
                                <div class="card-body">
                                    <canvas id="topCaterChart" style="width: 100%; height: auto;"></canvas>
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
                    <div class="row">
                        <div class="col">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fa-solid fa-star"></i>
                                    Top Best Seller Products
                                </div>
                                <div class="card-body">
                                    <div class="row" id="package-cards">
                                    </div>
                                </div>
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



    <!-- Pop up Notification -->
    <div class="modal fade" id="notifyModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationCompleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationCompleteModalLabel">
                        Important Notice
                    </h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <p>For security purposes, please update your temporary password in your cater settings at your
                        earliest convenience.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-get-main" data-dismiss="modal">
                        <a href="setting.php" style="color:white;text-decoration:none;">Update Now</a>
                    </button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="functions/js/chart-revenue-perday.js"></script>
    <script src="functions/js/chart-revenue-permonth.js"></script>
    <script src="functions/js/chart-cater.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>


    <script src="../vendor/js/datatables-simple-demo.js"></script>
    <script>
        // Check if the client has not been notified (isNotified = 0)
        document.addEventListener("DOMContentLoaded", function () {
            <?php
            // Fetch the current client's notification status
            $client_id = $_SESSION['client_id']; // Assuming client_id is stored in session after login
            $stmt = $DB_con->prepare("SELECT isNotified FROM tbl_clients WHERE client_id = :client_id");
            $stmt->bindParam(':client_id', $client_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && $result['isNotified'] == 0): ?>
                // Show the modal automatically
                var notifyModal = new bootstrap.Modal(document.getElementById('notifyModal'));
                notifyModal.show();

                // Update the isNotified status using AJAX
                fetch('functions/update-notification-status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ client_id: <?php echo $client_id; ?> })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Notification status updated successfully.');
                        } else {
                            console.log('Failed to update notification status.');
                        }
                    }).catch(error => console.error('Error:', error));
            <?php endif; ?>
        });
        // Function to fetch packages from the backend with date filters
        function fetchTopPackages() {
            // Get the start date and end date, defaulting to today's date if not provided
            const startDate = encodeURIComponent(document.querySelector('input[name="start_date"]').value || new Date().toISOString().split('T')[0]); // Default to today if empty
            const endDate = encodeURIComponent(document.querySelector('input[name="end_date"]').value || new Date().toISOString().split('T')[0]);   // Default to today if empty

            return fetch(`functions/fetch-package-rate.php?start_date=${startDate}&end_date=${endDate}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                });
        }

        // Function to populate the package cards
        function populatePackageCards(packages) {
            const container = document.getElementById('package-cards');
            container.innerHTML = ''; // Clear any existing content

            if (packages.length === 0) {
                // Display a placeholder message if no packages are available
                container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert" style="font-size: 1.2rem;">
                    No ratings available for packages yet.
                </div>
            </div>
        `;
                return;
            }

            // Display packages if available
            packages.forEach(package => {
                const averageRate = package.average_rate ? parseFloat(package.average_rate) : 0; // Ensure it's a number
                const card = document.createElement('div');
                card.classList.add('col');

                card.innerHTML = `
            <div class="card h-100">
                <img src="../../assets/img/package-uploads/${package.package_image}" class="card-img-top" alt="${package.package_name}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">${package.package_name}</h5>
                    <p class="card-text">Average Rating: ${averageRate.toFixed(1)} <i class="fa-solid fa-star" style="color: gold;"></i></p>
                </div>
            </div>
        `;

                container.appendChild(card);
            });
        }

        // Fetch and display the packages when the page loads
        window.addEventListener('DOMContentLoaded', (event) => {
            // Trigger the package fetch with default date range on page load
            fetchTopPackages()
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    populatePackageCards(data); // Update the cards with the data
                })
                .catch(error => console.error('Error fetching packages:', error));
        });

        // Add event listener to the filter form
        document.getElementById('filter-form').addEventListener('submit', function (event) {


            // Fetch the filtered data and update the package cards
            fetchTopPackages()
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    populatePackageCards(data); // Update the cards with filtered results
                })
                .catch(error => console.error('Error fetching packages:', error));
        });
        // Fetch the actual sales data with filters
        function fetchActualSales() {
            const startDate = document.querySelector('input[name="start_date"]').value || '';
            const endDate = document.querySelector('input[name="end_date"]').value || '';

            fetch(`path-to-your-script.php?start_date=${startDate}&end_date=${endDate}`)
                .then(response => response.json())
                .then(data => {
                    // Update the sales data on the page
                    document.querySelector('#actual-sales-amount').textContent = `₱${data.currentRevenue}`;
                    document.querySelector('#percentage-change').textContent = `${data.percentageChange}%`;
                })
                .catch(error => console.error('Error fetching sales data:', error));
        }


    </script>
    </script>

</body>

</html>